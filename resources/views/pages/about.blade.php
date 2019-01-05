@extends('main')

@section('title', '| About')

@section('content')

    <style>
        .content{
            font-size: 18px;
            font-family: 'Noto Sans TC', sans-serif !important;
            margin-bottom: 50px;
        }

        .content-img{
            text-align: center;
        }
    </style>



        <div class="row">
            <div class="col-md-12 content">
                <h1>About HotelsDB</h1><br>
                <p>
                    ‘Hotelsdb’ is a web application that provide a platform for people to book and manage their hotel booking through our system. Our system stored more than 700+ hotels or guest houses in database , which is including almost 90% of available booking living-areas in HK. In frontend, Hotelsdb contain member function, booking function, search engine, browse all HK hotel information. In backend, manage hotel info, book hotels, control any content in website for admin to use.
                </p>
                <br>
                <p>
                    'Hotelsdb'是一個Web應用程序，為人們通過我們的系統預訂和管理酒店預訂提供了一個平台。 我們的系統在數據庫中存儲了超過700多家酒店或賓館，其中包括香港近90％的可預訂生活區。 在前端，Hotelsdb包含會員功能，預訂功能，搜索引擎，瀏覽所有香港酒店信息。 在後端，管理酒店信息，預訂酒店，控製網站中的任何內容供管理員使用。
                </p>

                <br>

                <div class="content-img">
                    <img src="images/logo/logo.jpg">
                </div>
            </div>
        </div>

@endsection
