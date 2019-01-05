@extends('main')

@section('title', '| About')

@section('content')
    <style>
        .affix {
            top: 20px;
            z-index: 9999 !important;
        }

        div.col-sm-9 div {
            /*height: 550px;*/
            font-size: 28px;
        }

        p{
            font-size: 17px;
        }

        .nav-pills{
            border-right: 5px solid #eee;
        }

        #section7 {
            margin-bottom: 400px;
        }


        #section1, #section2, #section3, #section4, #section5 , #section6 , #section7{
            margin-left: 30px;
            padding-bottom: 50px;
        }


        @media screen and (max-width: 810px) {
            #section1, #section2, #section3, #section4, #section5, #section6, #section7{
                margin-left: 150px;
            }
        }

        .code{
            color: white;
            background-color: black;
            padding: 5px;
            margin: 10px;
            font-style: italic;
            font-weight: bold;
        }

        .signature{
            float: right;
        }
    </style>

    <body data-spy="scroll" data-target="#myScrollspy" data-offset="15">

    <div class="container">
        <div class="row">
            <nav class="col-sm-3" id="myScrollspy">
                <ul class="nav nav-pills nav-stacked" data-spy="affix" data-offset-top="205">
                    <li class="active"><a href="#section1">Introduction</a></li>
                    <li><a href="#section2">Database Design</a></li>
                    <li><a href="#section3">User interface design</a></li>
                    <li><a href="#section4">Technique / Framework & System Design</a></li>
                    <li><a href="#section5">Data and Service Security</a></li>
                    <li><a href="#section6">Frontend Development</a></li>
                    <li><a href="#section7">Conclusion</a></li>
                </ul>
            </nav>
            <div class="col-sm-9">
                <div id="section1">
                    <h1>Introduction</h1>
                    <p>‘Hotelsdb’ is a web application that provide a platform for people to book and manage their hotel booking through our system. Our system stored more than 700+ hotels or guest houses in database , which is including almost 90% of available booking living-areas in HK. In frontend, Hotelsdb contain member function, booking function, search engine, browse all HK hotel information. In backend, manage hotel info, book hotels, control any content in website for admin to use.</p>
                </div>
                <div id="section2">
                    <h1>Database Design</h1>
                    <p>
                        <img src="images/doc/ERD.png" class="img-responsive">
                        The database built with MySQL and it has been done fully database normalization. The structure of the database designed all around table ‘hotel’ which is the leading role of our system. All of them using <b>id</b> as a primary key in hotel table, and <i>hotel_id</i> as foreign key in the other related tables.
                        <br><br>
                        The design of this database is divided as two parts. The first one is <b>Hotel Information</b> and the second one is <b>Booking and Payment</b>. Hotel Information aims to display the content and info of all hotels in our database and also provide a comprehensive search function to user.
                        <br><br>

                        Booking and Payment is the part that handle booking created by the user, it is a process that getting information from hotel’s table such as room, price, and facility , then calculate the total price and confirm the payment.
                        <br><br>

                        Each hotel will have one record in table ‘hotel_facility’ and ‘categories’ , many records of ‘hotel_comment’, ‘hotel_image’, ‘post_tags’ and ‘booking‘.
                        <br><br>

                    </p>
                </div>
                <div id="section3">
                    <h1>User interface design</h1>
                    <p>
                        The UI/UX design referenced some of the popular hotel booking companies in the world such as <b><i>Expedia , Trivago and hotels.com</i></b>. All webpages in Hotelsdb can be browse at both desktop and mobile devices because I had applied some open source libraries to handle responsive browsing. <br><br>

                        There are many pages in Hotelsdb, It’s hard to discuss it one by one, but we can divided as <b>THREE</b> parts briefly. The first one is index page, this page is the first screen that user to browse and attract them to use. Therefore i have to design it very simple and clear.<br><br>
                        <img src="images/doc/ui1.png" class="img-responsive">
                        <br>

                        Just simple, menu bar above web page, search engine in center and showing random hotels in the bottom. It is easy to let user try to click into the hotel page or try to search with our search engine.<br><br>

                        The second one is hotel info page. A gallery with hotel pictures will be displayed at top, a map in right hand corner can be clicked to support address information via <b>Google Map</b>.
                        The hotel/room information will be also displayed in the center and the bottom of the page which can be more attractive to the user. The design is <b>clear, simple and beautiful</b> for the user to browse which is my expected consequent.<br><br>

                        <img src="images/doc/ui2.jpg" class="img-responsive">
                        <br>

                        The last UI design is hotel booking which is the main function of Hotelsdb. The process of booking will be handled in one page, one action and one validation form. The step process will mark at the top of the page, user need to fill their guest information and then select the booking date.<br><br>
                        <img src="images/doc/ui3.png" class="img-responsive">
                        <br>

                        Finally, they need to fill in their credit card information to deal with the payment. The calendar will be displayed in step-2 , so the user no need to enter the date by hand to avoid data format error and careless mistake.<br><br>
                        <img src="images/doc/ui4.png" class="img-responsive">
                        <br>
                    </p>
                </div>
                <div id="section4">
                    <h1>Technique / Framework & System Design</h1>
                    <p>
                        Basically, the application was developed with PHP framework - Laravel, which is running in server-side as a backend MVC framework. The member system (including user authentication and registration) is a in-built function when i downloaded in the official website. When Laravel handle login & register, the request by user will firstly go through a ‘routes.php’ file , which is a <b>master controller</b> to redirect all of the request action come from user. <br><br>
                        <img src="images/doc/ui5.png" class="img-responsive">
                        <br>

                        The routes file will call login/register controller to do further authentication. After that, authentication controller will call several of models to access the database and authenticate the user input. The <b>Eloquent ORM</b> is used as an ORM component to interact with the database. Once server received request from user, the ORM will interact with database and retrieve the data via a specific model , then return the result to <b>Controller</b>, render the message to the <b>VIEW</b> finally.
                        <br><br>

                        This is a typical MVC software application which means that Hotelsdb is divided as three parts/processes to handle different kinds of work. I choose to use Laravel framework because of its clear and simple MVC structure. The controller is convenient to call via routes.php, the ORM is easy to interact with model to retrieve data, the content is also fast to render from controller to view. <br><br>


                        The structure design of Hotelsdb started with routes.php. First i group the url route by functions such as hotel info, hotel room, hotel facility, booking and payment. Example: <br><br>

                        <i class="fab fa-freebsd"></i> http://host/hotel/room <br>
                        <i class="fab fa-freebsd"></i> http://host/hotel/facility <br>
                        <i class="fab fa-freebsd"></i> http://host/hotel/booking <br>

                        <br>

                    These functions has been group as hotel-related function. Then i create the controller (like HotelController) one by one, all functions has been grouped and called separately. Therefore, any request from user will have its own route to call, only a part of code in specific controller and model will run in server side. <br><br>

                    <b>It makes Hotelsdb as a good structure and high performance system.</b> <br><br>

                    Below is an example on how Eloquent ORM retrieve data.<br>
                    <span class="code"><b>$hotels = Hotel::where('name','=','peninsula')->orderBy('id', 'asc')->paginate(10);</b></span>    <br>
                    Without writing complicated SQL statement, ORM syntax is more easy to code and understand.

                    <br><br>
                    Other then that, ORM has been widely applied in all functions in Hotelsdb when it is related to the database, Search Engine would be the best example.

                    <img src="images/doc/ui6.png" class="img-responsive">

                    The search engine is powerful to search the most suitable result for user. Notice that hotel is not only single table result in our database, It also related to category, tags, room and price. These kinds of attributes describing hotels, but they are come from other tables and/or with different structure. Joining tables and writing multiple SQL statement maybe can handle this requirement, but It must be <b>very complicated</b>. However, building SQL statement with Laravel ORM is more easier. Try to look at this example.

                    <br><br>
                    Let say the server got two variables : hotel name and category. I can split it into two SQL statement and handle it independently. <br><br>

                    <span class="code">
                        if ($name != null) {
                        $hotels = Hotel::Where('name', 'like', '%' . $name . '%');
                        }
                    </span>

                    <br>

                    <span class="code">
                        if ($category != null) {
                        $hotels = Category::Where('category_id', '=', $category)->andwhere(‘hotel_id’,’=’,$id);
                        }
                    </span>
                    <br><br>

                    Finally, I can merge this two SQL statement into one, hence retrieve the possible data. <br><br>

                    </p>
                </div>

                <div id="section5">
                    <h1>Data and Service Security</h1>
                    <p>
                        To ensure data security, Laravel use <b>Bcrypt</b> to encrypt user password. Bcrypt is a password hashing functionis that encrypt password by using some of mathematical algorithms. The encrypted password that stored in our database is irreversible, it can not convert to the original string but available to verify the password. <br><br>

                        When encrypt the password using Laravel framework, just call the bcrypt model. <br>
                        <span class="code">$password = bcrypt($request->password);</span>  <br><br>

                        Second, Booking form validation is an essential measure to ensure the application got accurate data. I have applied Jquery (Javascript library) to handle the checking of booking form. Each step on booking form, it will trigger a checking to validate the input , if passed, the process go on, else the process stop at that step. <br><br>

                        Laravel also provide <b>CSRF token</b> in each form in the system that request to input data. The token will generate when the page is loaded, so that some other site can not post the data via the url of the form. <br><br>

                    </p>


                </div>

                <div id="section6">
                    <h1>Frontend Development</h1>
                    <p>
                    Jquery is a small javascript library that provide very clear and easy syntax for me to develop Hotelsdb, especially in frontend. Other than select specific element on the pages to controI element attributes. I also use <b>AJAX</b> function to get <b>JSON data</b> from server-side, without reloading the whole page in some parts of the system. It makes user feel more user-friendly, and also ease the pressure for the server to reload all resources of the webpages. <br><br>

                    With the help with bootstrap and CSS3, I had created a fully responsive website that can be browsed both in desktop and mobile. Therefore, Hotelsdb is good to browse at home or outside through a browser.<br>

                    <img src="images/doc/front1.png" class="img-responsive">

                    </p>
                </div>


                <div id="section7">
                    <h1>Conclusion</h1>
                    <p>
                        To conclude, Hotelsdb is a user-friendly, clear, easy and structural system. With the help of the framework & libraries, the system is very convenient for user to browse hotel and manage booking. The system design of Hotelsdb is clear and simple, the database is structural and suitable for further development. I believe that it would be a great platform to do further development under a software development life cycle. <br><br><br><br><br><br><br><br>

                        <span class="signature">Created at 2019-01-01 KenIp - Software Developer</span>
                    </p>
                </div>

            </div>
        </div>
    </div>

    </body>

@endsection
