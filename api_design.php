<?php

/* API Design (GET/POST/PUT/DELETE) 
 * 
 * keyword: node sequelize rest api mysql express epilogue
 * 
 * https://swagger.io/docs/specification/2-0/describing-parameters/
 * 1. query parameters, such as /users?role=admin
 * 2. path parameters, such as /users/{id}
 * 3. header parameters, such as X-MyHeader: Value
 * 4. form parameters, requests with Content-Type of application/x-www-form-urlencoded 
 * 
 * APIs use API keys for authorization
 * Api Key => GET /controller/action?api_key=abcdef12345
 * 
 *  User
 *  [GET]/admin/user                 //get all user data
 *  [GET]/admin/user/{user_id}       //get user by id
 *  [POST]/admin/user                //create user
 *  [PUT]/admin/user/{user_id}       //update user details
 *  [DELETE]/admin/user/{user_id}    //delete user by id
 * 
 *  Account
 *  [GET]/account/checklogin    //check login authentication by ac&pw
 *  [GET]/account/apikey        //return unique api key for a specific user
 *  [GET]/account/{user_id}     //get user information
 *  [PUT]/account/{user_id}     //update user details
 * 
 *  Hotel-User
 *  [GET]/hotel                         //get All hotel information
 *  [GET]/hotel/{hotel_id}              //get hotel information by specific id
 *  [POST]/hotel/comment/{hotel_id}     //create hotel comment
 *  [GET]/hotel/comment/{hotel_id}      //get hotel all comment
 *  [GET]/hotel/room/{hotel_id}         //get hotel all room information
 * 
 *  Hotel-admin
 *  [POST]/hotel                    //create hotel
 *  [POST]/hotel/fac                //create hotel facilities
 *  [PUT]/hotel/{hotel_id}          //update hotel information
 *  [PUT]/hotel/fac/{hotel_id}      //update hotel facilities
 *  [DELETE]/hotel/{hotel_id}       //delete hotel
 *  [POST]/hotel/room/{hotel_id}    //create hotel room by specific hotel id
 *  [PUT]/hotel/room/{room_id}      //update hotel room information
 *  [DELETE]/hotel/room/{room_id}   //delete a room from a specific room_id
 * 
 *  Hotel-Booking&Payment
 *  [GET]/hotel/room/status/{room_id}   //get room booking status by date
 *  [GET]/hotel/room/validation         //valid room booking status
 *  [GET]/hotel/booking/{user_id}       //get all booking by a user
 *  [GET]/hotel/payment/{user_id}       //get all payment by a user
 *  [POST]/hotel/booking/{room_id}      //Create a booking&payment
 * 
 *  Hotel-Booking&Payment-Admin
 *  [PUT]/hotel/booking/{booking_id}        //update a booking information by booking_id
 *  [PUT]/hotel/payment/{payment_id}        //update a payment information by payment_id
 *  [PUT]/hotel/guest/{booking_id}          //update all booking's guest information by specific booking_id
 *  [DELETE]/hotel/booking/{booking_id}     //delete a set(booking,payment,guest) of booking
 * 
 *  Searching
 *  [GET]/hotel/search              //searching hotel by input params
 *  [GET]/hotel/advanced_search     //searching hotel by advanced options
 *  
 *  
 * 
 * 
 * 
 */

?>