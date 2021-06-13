$(document).ready(function(){
    // Page de chargement
    $(window).on('load', function(){
        $('.chargement').delay(1000).fadeOut("slow");
        $(".loader").fadeOut();
        $(".logo_chargement").fadeOut();
        $("#preloader").delay(500).fadeOut("slow").scrollTop();
    });
// ==============================================================

    //BURGER
    $('.btn_burger').on('click', function(){
        $('.navigation_mobile').slideToggle('slow');
    })
// ==============================================================

    //SEARCH
    $(".btn_search, .icon_arrow").on('click', function(){
        $(".block_filters").slideToggle('slow');
    })
// ==============================================================

    //CAROUSSEL Top 10 des Instrus HOME
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
            maxItems: 4,
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

// ==============================================================

    //CAROUSSEL Textes Populaires HOME
    if (window.matchMedia("(max-width: 550px)").matches) {
        $('.flexslider2').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 250,
            itemMargin: 20,
            minItems: 1,
            maxItems: 1,
            controlNav: false,
            controlsContainer: $(".custom-controls-container2"),
            customDirectionNav: $(".custom-navigation2 a")
            });}
    else if (window.matchMedia("(max-width: 800px)").matches) {
        $('.flexslider2').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 200,
            itemMargin: 20,
            minItems: 2,
            maxItems: 2,
            controlNav: false,
            controlsContainer: $(".custom-controls-container2"),
            customDirectionNav: $(".custom-navigation2 a")
            });}
    else if (window.matchMedia("(max-width: 1100px)").matches) {
        $('.flexslider2').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 200,
            itemMargin: 20,
            minItems: 3,
            maxItems: 3,
            controlNav: false,
            controlsContainer: $(".custom-controls-container2"),
            customDirectionNav: $(".custom-navigation2 a")
            });}
    else if (window.matchMedia("(max-width: 1300px)").matches) {
        $('.flexslider2').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 200,
            itemMargin: 20,
            minItems: 4,
            maxItems: 4,
            controlNav: false,
            controlsContainer: $(".custom-controls-container2"),
            customDirectionNav: $(".custom-navigation2 a")
            });}
    else {
        $('.flexslider2').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 200,
            itemMargin: 20,
            minItems: 5,
            maxItems: 5,
            controlNav: false,
            controlsContainer: $(".custom-controls-container2"),
            customDirectionNav: $(".custom-navigation2 a")
    });}

// ==============================================================
    // LECTEUR AUDIO 
    // 1
    $(".btn").on('click', function() {
        // if ($("#player_1")[0].paused == false) {
        //     $("#player_1")[0].pause();
        // } else {
        //     $("#player_2")[0].pause();
        //     $("#player_1")[0].play();
        // }
        // if(this[0].paused == false) {
        //     this[0].pause();
        // } else {
        //     this[0].play();
        // }
        // if(("#player_" + $id)[0].paused == false) {
        //     this[0].pause();
        // } else {
        //     this[0].play();
        // }
        $(function(){
                var audio = $(this).prev(".audioplayer");
                audio.get(0).play();
            });
    });
    
    // 2
    // $(".btn_2").on('click', function() {
    //     if ($("#player_2")[0].paused == false) {
    //         $("#player_2")[0].pause();
    //     } else {
    //         $("#player_1")[0].pause();
    //         $("#player_2")[0].play();
    //     }
    // });


// ==============================================================

    //ANCRES SMOOOTH SCROLL FOOTER
    $(document).on('click', 'a[href^="#"]', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top
        }, 1000);
    });
// ==============================================================

    //SECTION BOTTOM
    $('.btn_bottom_keepvibz').on('click', function(){
        $('.submenu_center1').slideToggle('slow');
    })
    $('.btn_bottom_navigation').on('click', function(){
        $('.submenu_center2').slideToggle('slow');
    })
    
// ================================================================

    //GENRE INSTRUS HOME
    $('.btn_genre').on('click', function(){
        $('.block_genre').slideToggle('slow');
    })


// ================================================================

    //SHOW INSTRUS - DISPLAY NONE / DISPLAY BLOCK - BOTTOM SECTION
    $('.second_textes').click(function(){
        $(this).hide();
        $('.first_autres_instrus').show();
        $('.third_topline').show();
        $('.bottom_autres_instrus_show').hide();
        $('.bottom_toplines_associees_show').hide();
        $('.bottom_textes_associees_show').show();
    })

    $('.first_autres_instrus').click(function(){
        $(this).hide();
        $('.second_textes').show();
        $('.third_topline').show();
        $('.bottom_autres_instrus_show').show();
        $('.bottom_textes_associees_show').hide();
        $('.bottom_toplines_associees_show').hide();
    })

    $('.third_topline').click(function(){
        $(this).hide();
        $('.second_textes').show();
        $('.first_autres_instrus').show();
        $('.bottom_autres_instrus_show').hide();
        $('.bottom_textes_associees_show').hide();
        $('.bottom_toplines_associees_show').show();
    })

    //SHOW TEXTES - DISPLAY NONE / DISPLAY BLOCK - BOTTOM SECTION
    $('.second_instrus').click(function(){
        $(this).hide();
        $('.first_autres_textes').show();
        $('.bottom_autres_textes_show').hide();
        $('.bottom_instrus_associees_show').show();
    })

    $('.first_autres_textes').click(function(){
        $(this).hide();
        $('.second_instrus').show();
        $('.bottom_autres_textes_show').show();
        $('.bottom_instrus_associees_show').hide();
    })

})