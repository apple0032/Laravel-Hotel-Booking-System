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
 *  [GET]/hotel/list                    //get All hotel information
 *  [GET]/hotel/{hotel_id}              //get hotel information by specific id
 *  [POST]/hotel/comment/{hotel_id}     //create hotel comment
 *  [GET]/hotel/comment/{hotel_id}      //get hotel all comment
 *  [GET]/hotel/room/{hotel_id}         //get hotel all room information
 * 
 *  Hotel-Booking&Payment
 *  [GET]/hotel/room/status/{room_id}       //get room booking status by date
 *  [GET]/hotel/room/validation             //validate room booking status
 *  [GET]/hotel/booking/{user_id}           //get all booking by a user
 *  [GET]/hotel/payment/{user_id}           //get all payment by a user
 *  [POST]/hotel/booking/{room_id}          //Create a booking&payment
 *  [POST]/hotel/booking/guest/{booking_id} //Add guest to a booking
 * 
 *  Searching
 *  [GET]/hotel/search/normal       //searching hotel by input params
 *  [GET]/hotel/search/advanced     //searching hotel by advanced options and include algorithm search later
 * 
 *  Hotel-admin
 *  [POST]/admin/hotel                    //create hotel
 *  [POST]/admin/hotel/fac                //create hotel facilities
 *  [PUT]/admin/hotel/{hotel_id}          //update hotel information
 *  [PUT]/admin/hotel/fac/{hotel_id}      //update hotel facilities
 *  [DELETE]/admin/hotel/{hotel_id}       //delete hotel
 *  [POST]/admin/hotel/room/{hotel_id}    //create hotel room by specific hotel id
 *  [PUT]/admin/hotel/room/{room_id}      //update hotel room information
 *  [DELETE]/admin/hotel/room/{room_id}   //delete a room from a specific room_id
 * 
 *  Hotel-Booking&Payment-Admin
 *  [PUT]/admin/hotel/booking/{booking_id}        //update a booking information by booking_id
 *  [PUT]/admin/hotel/payment/{payment_id}        //update a payment information by payment_id
 *  [PUT]/admin/hotel/guest/{booking_id}          //update all booking's guest information by specific booking_id
 *  [DELETE]/admin/hotel/guest/{booking_id}       //delete a guest by specific booking_id
 *  [DELETE]/admin/hotel/booking/{booking_id}     //delete a set(booking,payment,guest) of booking
 *  
 *  Category-Admin
 *  [GET]/admin/category                    //get all hotel categories
 *  [POST]/admin/category                   //create new category
 *  [PUT]/admin/category/{category_id}      //update a category name
 *  [DELETE]/admin/category/{category_id}   //delete a category name
 * 
 *  Tags-Admin
 *  [GET]/admin/tags                        //get all hotel categories
 *  [POST]/admin/tags                       //create new tags
 *  [PUT]/admin/tags/{tags_id}              //update a tag name
 *  [DELETE]/admin/tags/{tags_id}           //delete a tag name
 *  [POST]/admin/tags/hotel/{hotel_id}      //Add tags into hotel
 *  [DELETE]/admin/tags/hotel/{hotel_id}    //Delete tags from hotel
 *  
 *  Payment method-Admin
 *  [GET]/admin/paymentMethod                       //get all payment method
 *  [POST]/admin/paymentMethod                      //create new paymentMethod
 *  [PUT]/admin/paymentMethod/{category_id}         //update a paymentMethod
 *  [DELETE]/admin/paymentMethod/{category_id}      //delete a paymentMethod
 * 
 *  Statistic API
 *  [GET]/admin/stat/bookingStatus      //get all hotel all booking status by a specific period
 *  [GET]/admin/stat/rank               //get the rank list of all hotel
 *  [GET]/admin/stat/invoice            //get the total invoice/income by a specific period
 *  [GET]/admin/stat/searching          //return statistic data which calculated by user input
 *  
 *  Config API
 *  [PUT]/admin/config/pageno       //config the number of hotels displayed in one page
 *  [PUT]/admin/config/about        //config about page content
 * 
 * 
 */

?>