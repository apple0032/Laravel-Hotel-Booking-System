$('.select2-multi').select2();
$('[data-toggle="tooltip"]').tooltip();


$(document).ready(function () {
    $(".small_search_container").sticky({topSpacing: 0});
});
var lastScrollTop = 100;
$(window).scroll(function (event) {
    var st = $(this).scrollTop();
    var scrollPercent = 100 * $(window).scrollTop() / ($(document).height() - $(window).height());
    if ($(window).width() > 990) {
        if (st > lastScrollTop) {
            if (scrollPercent > 30) {
                $('.small_search_container').fadeOut();
            }
        } else {
            $('.small_search_container').fadeIn();
        }
    }

    if ($(window).width() < 990) {
        if (scrollPercent > 0) {
            $('#sticky-wrapper').fadeOut();
            $('.btn-search-small').show();
        }
    }

    lastScrollTop = st;
});
$(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
        $('.scrolltop:hidden').stop(true, true).fadeIn();
    } else {
        $('.scrolltop').stop(true, true).fadeOut();
    }
});
$(".scroll").click(function () {
    $('html,body').animate({scrollTop: 0}, 'slow');
})




$(".small_search_container input[name='name'],.small_search_container select[name='category_id'], .small_search_container select[name='star'], .small_search_container #tags, .small_search_container select[name='room_type'], .small_search_container select[name='people_limit']").change(function () {

    var name = $("input[name='name']").val();
    name = name.replace(/ /g, "|") ;

    var category = $("select[name='category_id'] option:selected").val();
    var star = $("select[name='star'] option:selected").val();
    var room_type = $("select[name='room_type'] option:selected").val();
    var ppl = $("select[name='people_limit'] option:selected").val();
    var tags = $("#tags").val();
    SearchByAjax(name, category, star, room_type, ppl, tags);
});

function SearchByAjax(name, category, star, room_type, ppl, tags) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: 'searchbyajax',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            name: name,
            category: category,
            star: star,
            room_type: room_type,
            ppl: ppl,
            tags: tags
        },
        dataType: 'JSON',
        beforeSend: function () {
            $('.loading_icon').show();
            $(".hotel_grid_container").css("opacity", "0.4");
        },
        success: function (data) {
            $('.loading_icon').hide();
            $(".hotel_grid_container").css("opacity", "1");
            $('.total_result').remove();
            $('.hotel_grid_index').remove();
            $('.hotel_page').remove();
            //console.log(data);
            //console.log(tags);

            var etag = '';
            if (tags) {
                for (i = 0; i < tags.length; i++) {
                    etag += '&tags[' + i + ']=' + tags[i];
                }
            } else {
                etag = '';
            }

            name = name.split("|").join("%20");

            $('.hotel_grid_container').load('search?name=' + name + '&category=' + category + etag + '&star=' + star + '&room_type=' + room_type + '&people_limit=' + ppl + '&price_low=&price_up=&page=1 .hotel_grid_container', function () {
                $('[data-toggle="tooltip"]').tooltip();

                $(".btn-search-small").click(function(){
                    $('.btn-search-small').hide();
                    $('#sticky-wrapper').fadeIn();
                    //$(".hotel_grid_container").css("margin-top", "520px", "!important");
                    $('#sticky-wrapper').css("height", "580px", "!important");
                });
            });
        }
    });
}


var wallpapers = ['italy', 'japan', 'japan2', 'japan3'];
setInterval(function () {
    var wallpaper = wallpapers[Math.floor(Math.random() * wallpapers.length)];
    $('.search_container').css("background-image", "url(\"images/" + wallpaper + ".jpg\")");
}, 7000);


$(".list-unstyled").css("width", $('.search_hotelname').width() + 100);

$("#search_hotelname").focus(function () {
    $("#search_hotelname").trigger("keyup");
});

$("#search_hotelname").blur(function () {
    $(".list-unstyled").fadeOut();
});


$("#search_hotelname").keyup(function(){
    //console.log('ajax');
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var name =  $("#search_hotelname").val();

    if ($(window).width() > 990) {
        $.ajax({
            url: 'searchname',
            async: false,
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                name: name,
            },
            dataType: 'JSON',
            beforeSend: function () {
                $(".list-unstyled").html('');
                console.log('ajax');
            },
            success: function (data) {

                var hotels = data.hotels;

                if (data.status == 'success') {
                    if (hotels.length > 0) {

                        for (i = 0; i < hotels.length; i++) {

                            if (hotels[i]["default_image"] != '') {
                                var image = 'http://photo.hotellook.com/image_v2/limit/h' + hotels[i]["default_image"] + '_0/640/480.jpg';
                            } else {
                                var image = 'images/upload/' + hotels[i]["image"];
                            }

                            $('.list-unstyled').append('' +
                                '<li class="search_opt" value="value55">' + '<div class="row"><div class="col-md-3 nopadding">' +
                                '<img src=' + image + ' style="width:60px; height:40px; margin-right: 8px;"></div><div class="col-md-9 nopadding-left">' +
                                hotels[i]["name"] + '</div>' +
                                '</div></li>');
                        }

                        $(".list-unstyled").fadeIn();
                    } else {
                        console.log('not found');
                        $(".list-unstyled").fadeOut();
                    }

                    $(".search_opt").each(function (index) {
                        $(this).on("click", function () {
                            var name = $(this).text();
                            $("#search_hotelname").val(name);
                        });
                    });

                } else {
                    console.log('not found');
                    $(".list-unstyled").fadeOut();
                }
            }
        });
    }
});


$(".btn-search-small").click(function(){
    $('.btn-search-small').hide();
    $('#sticky-wrapper').fadeIn();
    //$(".hotel_grid_container").css("margin-top", "520px", "!important");
    $('#sticky-wrapper').css("height", "580px", "!important");
});