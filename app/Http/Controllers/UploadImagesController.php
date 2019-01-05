<?php

namespace App\Http\Controllers;

use App\HotelImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class UploadImagesController extends Controller
{

    private $photos_path;

    public function __construct()
    {
        $this->photos_path = public_path('/images/upload');
    }

    /**
     * Display all of the images.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = HotelImage::all();
        return view('uploaded-images', compact('photos'));
    }

    /**
     * Show the form for creating uploading new images.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('upload');
    }

    /**
     * Saving images uploaded through XHR Request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $photos = $request->file('file');
        $hotel_id = $request->hotel_id;

        if (!is_array($photos)) {
            $photos = [$photos];
        }

        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0777);
        }

        for ($i = 0; $i < count($photos); $i++) {
            $photo = $photos[$i];
            $name = sha1(date('YmdHis') . str_random(5));
            $save_name = $name . '.' . $photo->getClientOriginalExtension();
            $resize_name = $name . str_random(2) . '.' . $photo->getClientOriginalExtension();

            Image::make($photo)
                ->resize(250, null, function ($constraints) {
                    $constraints->aspectRatio();
                })
                ->save($this->photos_path . '/' . $resize_name);

            $photo->move($this->photos_path, $save_name);

            $upload = new HotelImage();
            $upload->hotel_id = $hotel_id;
            $upload->filename = $save_name;
            $upload->resized_name = $resize_name;
            $upload->original_name = basename($photo->getClientOriginalName());
            $upload->save();
        }
        return Response::json([
            'message' => 'Image saved Successfully'
        ], 200);
    }

    /**
     * Remove the images from the storage.
     *
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        $filename = $request->id;
        $uploaded_image = HotelImage::where('original_name', basename($filename))->first();

        if (empty($uploaded_image)) {
            return Response::json(['message' => 'Sorry file does not exist'], 400);
        }

        $file_path = $this->photos_path . '/' . $uploaded_image->filename;
        $resized_file = $this->photos_path . '/' . $uploaded_image->resized_name;

        if (file_exists($file_path)) {
            unlink($file_path);
        }

        if (file_exists($resized_file)) {
            unlink($resized_file);
        }

        if (!empty($uploaded_image)) {
            $uploaded_image->delete();
        }

        return Response::json(['message' => 'File successfully delete'], 200);
    }


    public function deleteimg(Request $request)
    {
        $img = $request->image_id;
        $uploaded_image = HotelImage::where('id', $img)->first();

        $uploaded_image->delete();

        $file_b = 'images/upload/'.$uploaded_image->filename;
        if(file_exists($file_b)) {
            unlink($file_b);
        }

        $file_s = 'images/upload/'.$uploaded_image->resized_name;
        if(file_exists($file_s)) {
            unlink($file_s);
        }

        return Response::json(['message' => 'File successfully delete - id : '.$img], 200);
    }
}