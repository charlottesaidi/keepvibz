$(document).ready(function(){
    // Page de chargement
    $(window).on('load', function(){
        $('.chargement').delay(1000).fadeOut("slow");
        $(".loader").fadeOut();
        $(".logo_chargement").fadeOut();
        $("#preloader").delay(500).fadeOut("slow");
    });

    //HEADER
    var headerOffset = $('.header').offset().top;

    $(window).on('scroll', function(){
      var header = $('.header'),
          scroll = $(window).scrollTop();
    
      if (scroll >= headerOffset) header.addClass('fixed');
      else header.removeClass('fixed');
    });

    //BURGER
    $('.btn_burger').on('click', function(){
        $('.navigation_mobile').slideToggle('slow');
    })
// ==============================================================

    //SEARCH
    $(".btn_search, .icon_arrow").on('click', function(){
        $(".block_filters").toggle('slide');
    })



    if (window.matchMedia("(max-width: 550px)").matches) {
        $('.flexslider').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 250,
            itemMargin: 20,
            minItems: 1,
            maxItems: 1,
            controlNav: false,
            controlsContainer: $(".custom-controls-container"),
            customDirectionNav: $(".custom-navigation a")
            });}
    else if (window.matchMedia("(max-width: 800px)").matches) {
        $('.flexslider').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 200,
            itemMargin: 20,
            minItems: 2,
            maxItems: 2,
            controlNav: false,
            controlsContainer: $(".custom-controls-container"),
            customDirectionNav: $(".custom-navigation a")
            });}
    else if (window.matchMedia("(max-width: 1100px)").matches) {
        $('.flexslider').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 200,
            itemMargin: 20,
            minItems: 3,
            maxItems: 3,
            controlNav: false,
            controlsContainer: $(".custom-controls-container"),
            customDirectionNav: $(".custom-navigation a")
            });}
    else if (window.matchMedia("(max-width: 1300px)").matches) {
        $('.flexslider').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 200,
            itemMargin: 20,
            minItems: 4,
            maxItems: "",
            controlNav: false,
            controlsContainer: $(".custom-controls-container"),
            customDirectionNav: $(".custom-navigation a")
            });}
    else {
        $('.flexslider').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 200,
            itemMargin: 20,
            minItems: 5,
            maxItems: 5,
            controlNav: false,
            controlsContainer: $(".custom-controls-container"),
            customDirectionNav: $(".custom-navigation a")
    });}


    //CAROUSSEL MOST DOWNLOADED
    $('.flexslider').flexslider({
    animation: "slide",
    animationLoop: false,
    itemWidth: 200,
    itemMargin: 20,
    minItems: 5,
    maxItems: 5,
    controlNav: false,
    controlsContainer: $(".custom-controls-container"),
    customDirectionNav: $(".custom-navigation a")
    });

    //ANCOR SMOOOTH SCROLL
    $(document).on('click', 'a[href^="#"]', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top
        }, 1000);
    });
    

    //SECTION BOTTOM
    $('.btn_bottom_keepvibz').on('click', function(){
        $('.submenu_center1').slideToggle('slow');
    })
    $('.btn_bottom_explorer').on('click', function(){
        $('.submenu_center2').slideToggle('slow');
    })
    
})