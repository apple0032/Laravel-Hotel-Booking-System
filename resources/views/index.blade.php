<!DOCTYPE html>
<html lang="en">
  <head>
    @include('partials._head')
  </head>

  <body>

    @include('partials._nav')
    @yield('content')

    <div class="container"> <!-- The difference between index.blade & main.blade is that content section outside container in index.blade-->

      @include('partials._messages')
      @yield('content.grid')

    </div> <!-- end of .container -->

    <div class="footer_section" style="height:100px;padding-top: 0px;">
      @include('partials._footer')
    </div>

        @include('partials._javascript')

        @yield('scripts')

  <style>
    .footer_text {
      padding-top: 30px;
      height: 50px;
    }
  </style>

  <script>

//      $( ".navbar-nav a" ).each(function(index) {
//          $(this).on("click", function(e){
//              e.preventDefault();
//
//              var a_href = $(this).attr('href');
//              $('.search_container').fadeOut();
//
//              $('.container').load(a_href+' .container', function () {
//
//              });
//          });
//      });

  </script>

  </body>
</html>
