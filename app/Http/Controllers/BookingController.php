<?php

namespace App\Http\Controllers;

use App\BookingGuest;
use App\BookingPayment;
use App\PaymentMethod;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Hotel;
use App\Tag;
use App\Category;
use App\PostTag;
use App\HotelRoom;
use App\RoomType;
use App\HotelFacility;
use App\HotelRoomFacility;
use App\HotelImage;
use App\Booking;
use App\User;
use App\HotelComment;
use Session;
use Purifier;
use Image;
use Auth;
use Redirect;
use DB;

class BookingController extends Controller
{

    public function __construct() {
        $this->middleware(['auth']);
    }
    
    public function book($id,$roomid)
    {
        //$id = hotel's id;
        if(!Auth::check()){
            Session::flash('success', 'Please login!');
            return redirect('auth/login');
        }
        
        $hotel = Hotel::where('id','=',$id)->first();
        $room = HotelRoom::where('id','=',$roomid)->where('hotel_id','=',$id)->first();

        if($room == null){
            return redirect('/');
        }

        $room_type_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap(RoomType::all(),'id','type');
        $payment_method = PaymentMethod::all();

        $today = date('Y-m-d');

        $user_id = Auth::user()->id;
        $user = User::where('id','=',$user_id)->first();

        return view('hotel.book')
            ->with('room',$room)
            ->with('room_type_list', $room_type_list)
            ->with('hotel',$hotel)
            ->with('today', $today)
            ->with('user',$user)
            ->with('payment_method', $payment_method);
    }


    public function booking(Request $request,$id,$roomid)
    {

        //$post->name = $request->title;
        $this->validate($request, array(
            'name'         => 'required',
        ));

        sleep(5);

        $booking = new Booking;
        $booking->user_id = Auth::user()->id;
        $booking->hotel_id = $id;
        $booking->hotel_room_id = $roomid;
        $booking->people = count($request->name);
        $booking->in_date = $request->in_date;
        $booking->out_date = $request->out_date;
        $booking->book_date = date('Y-m-d H:i:s');
        $booking->total_price = $request->total_price;
        $booking->payment_method_id = $request->payment_method;
        $booking->approved = 1;
        $booking->status = 1;
        $booking->save();

        if($booking->save()){

            $payment = new BookingPayment();
            $payment->booking_id = $booking->id;
            $payment->user_id = $booking->user_id;
            $payment->single_price = $request->single_price;
            $payment->handling_price = $request->handling_price;
            $payment->total_price = $booking->total_price;
            $payment->payment_method_id = $request->payment_method;
            $payment->card_number = $request->card_number;
            $payment->expired_date = $request->expired_date;
            $payment->security_number = $request->security_number;
            if($request->payment_method == 5) {
                $payment->status = 0;
            } else {
                $payment->status = 1;
            }
            $payment->save();

            if($payment->save()){

                for ($x = 0; $x < count($request->name); $x++) {
                    $guest = new BookingGuest();
                    $guest->booking_id = $booking->id;
                    $guest->name = $request->name[$x];
                    $guest->phone = $request->phone[$x];

                    $c = $x + 1;
                    if($request['gender'.$c][0] != null){
                        $gender = $request['gender'.$c][0];
                    } else {
                        $gender = '';
                    }

                    $guest->gender = $gender;
                    $guest->email = $request->email[$x];
                    $guest->save();
                }

                return redirect()->route('hotel.booklist');
            }
        }


        Session::flash('success', 'Sucess booking!');

        //return redirect()->route('hotel.index', $post->id);
    }

    public function booklist()
    {

        if(!Auth::check()){
            return redirect('auth/login');
        } else {
            $user_id = Auth::user()->id;
        };

        $booking = Booking::where('user_id', '=', $user_id)->orderby('in_date','DESC')->get();
        $room_type_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap(RoomType::all(),'id','type');
        $pay_method_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap(PaymentMethod::all(),'id','type');

        $room_type = null;
        $pay_method = null;

        if($booking != null) {
            foreach ($booking as $k => $bk) {
                $room[$k] = HotelRoom::where('id', '=', $bk->hotel_room_id)->get()->toarray();
                $room_type[$k] = $room_type_list[$room[$k][0]['room_type_id']];
                $pay_method[$k] = $pay_method_list[$bk->payment['payment_method_id']];
            }
        }

        //print_r($pay_method);die();

        return view('pages.booklist')
            ->with('room_type',$room_type)
            ->with('room_type_list', $room_type_list)
            ->with('pay_method', $pay_method)
            ->with('booking', $booking);
    }

    public function Payment()
    {

        if(!Auth::check()){
            return redirect('auth/login');
        } else {
            $user_id = Auth::user()->id;
        };

        $booking = Booking::where('user_id', '=', $user_id)->orderby('in_date','DESC')->get();
        $room_type_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap(RoomType::all(),'id','type');
        $pay_method_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap(PaymentMethod::all(),'id','type');

        $room_type = null;
        $pay_method = null;

        if($booking != null) {
            foreach ($booking as $k => $bk) {
                $room[$k] = HotelRoom::where('id', '=', $bk->hotel_room_id)->get()->toarray();
                $room_type[$k] = $room_type_list[$room[$k][0]['room_type_id']];
                $pay_method[$k] = $pay_method_list[$bk->payment['payment_method_id']];
            }
        }

        //print_r($pay_method);die();

        return view('pages.payment')
            ->with('room_type',$room_type)
            ->with('room_type_list', $room_type_list)
            ->with('pay_method', $pay_method)
            ->with('booking', $booking);
    }
    


}
