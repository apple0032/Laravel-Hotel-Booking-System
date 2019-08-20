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
use DateTime;
use Illuminate\Support\Facades\Input;

class BookingController extends Controller
{

    public function __construct() {
        $this->middleware(['auth']);
    }
    
    public function book($id,$roomid)
    {
        
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

        $this->validate($request, array(
            'name'         => 'required',
        ));

        //Wait for process preparation
        sleep(4);

        //Validation & calculation backend process
        $valid = self::BookingValidation($request);
        if($valid == false){
            return redirect()->route('pages.error');
        }

        $total_price = self::BookingCalculation($request,$id,$roomid);
        if($total_price != $request->total_price){
            return redirect()->route('pages.error');
        }

        //If finished validation & calculation, then handle credit card payment here
        $payment = self::BookingPayment($request,$total_price);

        if($payment == false){
            return redirect()->route('pages.error');
        }

        //If payment settled, then handle data storage in local db

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

                return redirect()->route('hotel.booklist',['bkhotel' => $booking->id]);
            }
        }


        Session::flash('success', 'Sucess booking!');

        //return redirect()->route('hotel.index', $post->id);
    }

    public function booklist()
    {
        $user_id = Auth::user()->id;

        $booking = Booking::where('user_id', '=', $user_id)->orderby('in_date','DESC')->get();
        $room_type_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap(RoomType::all(),'id','type');
        $pay_method_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap(PaymentMethod::all(),'id','type');

        $room_type = null;
        $pay_method = null;

        if($booking != null) {
            foreach ($booking as $k => $bk) {
                $room[$k] = HotelRoom::where('id', '=', $bk->hotel_room_id)->get()->toarray();
                $room_type[$k] = $room_type_list[$room[$k][0]['room_type_id']];
                if($bk->payment['payment_method_id']){
                    $pay_method[$k] = $pay_method_list[$bk->payment['payment_method_id']];
                } else {
                    $pay_method[$k] = null;
                }
            }
        }

        //print_r($pay_method);die();

        $booked_hotel = null;
        $bkhotel = Input::get('bkhotel');
        if($bkhotel != null){
            $booked_hotel = Booking::where('id', '=', $bkhotel)->first();
            $range = substr($booked_hotel->in_date, 0, 10).' - '.substr($booked_hotel->out_date, 0, 10);
            if($booked_hotel->count() == null){
                return redirect()->route('pages.error');
            }
        } else {
            $bkhotel = null;
            $range = null;
        }

        return view('pages.booklist')
            ->with('room_type',$room_type)
            ->with('room_type_list', $room_type_list)
            ->with('pay_method', $pay_method)
            ->with('booking', $booking)
            ->with('bkhotel',$bkhotel)
            ->with('booked_hotel',$booked_hotel)
            ->with('range', $range);
    }

    public function Payment()
    {
        $user_id = Auth::user()->id;

        $booking = Booking::where('user_id', '=', $user_id)->orderby('in_date','DESC')->get();
        $room_type_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap(RoomType::all(),'id','type');
        $pay_method_list = \App\Helpers\AppHelper::instance()->ObjectToArrayMap(PaymentMethod::all(),'id','type');

        $room_type = null;
        $pay_method = null;

        if($booking != null) {
            foreach ($booking as $k => $bk) {
                $room[$k] = HotelRoom::where('id', '=', $bk->hotel_room_id)->get()->toarray();
                $room_type[$k] = $room_type_list[$room[$k][0]['room_type_id']];
                if($bk->payment['payment_method_id']){
                    $pay_method[$k] = $pay_method_list[$bk->payment['payment_method_id']];
                } else {
                    $pay_method[$k] = null;
                }
            }
        }

        //print_r($pay_method);die();

        return view('pages.payment')
            ->with('room_type',$room_type)
            ->with('room_type_list', $room_type_list)
            ->with('pay_method', $pay_method)
            ->with('booking', $booking);
    }


    protected function BookingValidation($request){

        foreach ($request->email as $guest_email){
            if($guest_email != null) {
                if (!filter_var($guest_email, FILTER_VALIDATE_EMAIL)) {
                    return false;
                }
            }
        }

        foreach ($request->phone as $guest_phone) {
            if($guest_phone != null) {
                if (!filter_var($guest_phone, FILTER_VALIDATE_INT)) {
                    return false;
                }
            }
        }

        foreach ($request->name as $guest_name) {
            if($guest_name == null) {
                return false;
            }
        }

        $in_date = self::validateDate($request->in_date);
        if($in_date == false){
            return false;
        }

        $out_date = self::validateDate($request->out_date);
        if($out_date == false){
            return false;
        }

        if (!filter_var($request->single_price, FILTER_VALIDATE_INT)) {
            return false;
        }

        if (!filter_var($request->handling_price, FILTER_VALIDATE_INT)) {
            if($request->handling_price != '0') {
                return false;
            }
        }

        if (!filter_var($request->total_price, FILTER_VALIDATE_INT)) {
            return false;
        }

        return true;
    }

    protected function BookingCalculation($request,$id,$roomid){

        $hotel = Hotel::where('id','=',$id)->first();
        $room = HotelRoom::where('id','=',$roomid)->where('hotel_id','=',$id)->first();

        $hand = $hotel['handling_price'];
        $rm_price = $room['price'];

        $start = strtotime($request->in_date);
        $end = strtotime($request->out_date);
        $days = ceil(abs($end - $start) / 86400);

        $total_price = ($rm_price * $days) + $hand;

        return $total_price;
    }

    protected function BookingPayment($request,$price){

        if($request->payment_method == '5'){
            return true; //payment will settled at hotel, return true to skip payment process.
        } else {

            //Validate credit card input type
            if (!filter_var($request->card_number, FILTER_VALIDATE_INT)) {
                return false;
            }

            if (!filter_var($request->security_number, FILTER_VALIDATE_INT)) {
                return false;
            }

            //If credit card info basically ok
            //Then validate credit card info via calling those credit card company APIs.
            /*
             * Pseudo Process
             * 1. Call credit card authentication api to check the card is suit for payment
             * 2. if(return = true) -> call credit card payment api to request payment
             * 3. if request payment api return true and/or return a api payment token, then we get token for temp
             * 4. use that temp api token to request a payment, wait for that company to process payment
             * 5. if payment api return success, then we got successful payment status, thus process local db storage
             * 6. if payment api return fail/error/exception/reject etc.. then we stop booking process, break out of the program.
             *
             * Noted that payment price = $price that validated anc calculated before run this function.
             */

            //The payment gateway is still under developing now, so always return true.
            return true;
        }

    }


    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }


}
