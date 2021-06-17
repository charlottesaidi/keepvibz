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
    // $(".btn_search, .icon_arrow").on('click', function(){
    //     $(".block_filters").slideToggle('slow');
    // })
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
    
    $('.btn').click(function(){
        const id = $(this).attr('id');
        const words = id.split('_');

        $('.player_audio_selected').not(this).each(function() {
            $(this).get(0).pause();
            this.currentTime = 0;
        });

        $('.btn').not(this).each(function() {
            $(this).removeClass('audioactive')
        });
        if($(this).hasClass('audioactive')){
            $('#player_'+ words[2])[0].pause(); 
            $(this).removeClass('audioactive')
        } else {
            $('#player_'+ words[2])[0].play(); 
            $(this).addClass('audioactive')
        }
    });

// ==============================================================

    //ANCRES SMOOOTH SCROLL FOOTER
    $('#anchor_instrus_pop').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $($('#instrus_populaires')).offset().top
        }, 1500);
        console.log('dede');
    });

// ==============================================================

    //SECTION BOTTOM
    $('.btn_bottom_keepvibz').on('click', function(){
        $('.submenu_center1').slideToggle('slow');
        console.log('dede')

    })
    $('.btn_bottom_navigation').on('click', function(){
        $('.submenu_center2').slideToggle('slow');
    })
    

// ================================================================

    //SHOW INSTRUS - DISPLAY NONE / DISPLAY BLOCK - BOTTOM SECTION
    $('.second_textes').click(function(){
        $(this).hide();
        $('.first_autres_instrus').show();
        $('.third_topline').show();
        $('.fourth_auteur').show();
        $('.bottom_autres_instrus_show_instrus').hide();
        $('.bottom_toplines_associees_show_instrus').hide();
        $('.bottom_textes_associees_show_instrus').show();
        $('.bottom_informations_auteur_show_instrus').hide();

    })

    $('.first_autres_instrus').click(function(){
        $(this).hide();
        $('.second_textes').show();
        $('.third_topline').show();
        $('.fourth_auteur').show();
        $('.bottom_autres_instrus_show_instrus').show();
        $('.bottom_textes_associees_show_instrus').hide();
        $('.bottom_toplines_associees_show_instrus').hide();
        $('.bottom_informations_auteur_show_instrus').hide();

    })

    $('.third_topline').click(function(){
        $(this).hide();
        $('.second_textes').show();
        $('.first_autres_instrus').show();
        $('.fourth_auteur').show();
        $('.bottom_autres_instrus_show_instrus').hide();
        $('.bottom_textes_associees_show_instrus').hide();
        $('.bottom_toplines_associees_show_instrus').show();
        $('.bottom_informations_auteur_show_instrus').hide();

    })

    $('.fourth_auteur').click(function(){
        $(this).hide();
        $('.first_autres_instrus').show();
        $('.second_textes').show();
        $('.third_topline').show();
        $('.bottom_autres_instrus_show_instrus').hide();
        $('.bottom_textes_associees_show_instrus').hide();
        $('.bottom_toplines_associees_show_instrus').hide();
        $('.bottom_informations_auteur_show_instrus').show();
    })

    //SHOW TEXTES - DISPLAY NONE / DISPLAY BLOCK - BOTTOM SECTION
    $('.second_instrus').click(function(){
        $(this).hide();
        $('.first_autres_textes').show();
        $('.fourth_auteur').show();
        $('.bottom_autres_textes_show_textes').hide();
        $('.bottom_instrus_associees_show_textes').show();
        $('.bottom_informations_auteur_show_textes').hide();
    })

    $('.first_autres_textes').click(function(){
        $(this).hide();
        $('.second_instrus').show();
        $('.fourth_auteur').show();
        $('.bottom_autres_textes_show_textes').show();
        $('.bottom_instrus_associees_show_textes').hide();
        $('.bottom_informations_auteur_show_textes').hide();
    })

    $('.fourth_auteur').click(function(){
        $(this).hide();
        $('.second_instrus').show();
        $('.first_autres_textes').show();
        $('.bottom_autres_textes_show_textes').hide();
        $('.bottom_instrus_associees_show_textes').hide();
        $('.bottom_informations_auteur_show_textes').show();
    })
})


// ==============================================================

    //SECTION FAQ
    $('.btn_bottom_3').on('click', function(){
        $('.submenu_center3').slideToggle('slow');
    })
    
    $('.btn_bottom_4').on('click', function(){
        $('.submenu_center4').slideToggle('slow');
    })
    
    $('.btn_bottom_5').on('click', function(){
        $('.submenu_center5').slideToggle('slow');
    })
    
    $('.btn_bottom_6').on('click', function(){
        $('.submenu_center6').slideToggle('slow');
    })
    
    $('.btn_bottom_7').on('click', function(){
        $('.submenu_center7').slideToggle('slow');
    })
    
    $('.btn_bottom_8').on('click', function(){
        $('.submenu_center8').slideToggle('slow');
    })
    
    $('.btn_bottom_9').on('click', function(){
        $('.submenu_center9').slideToggle('slow');
    })
    
// ================================================================
// COMPTEUR LECTURES
    // var count = 0;
    // $(".btn").on("click", function(e){
    //     e.preventDefault();
    //     count++;
    //     $('.resultat_nbre_lectures').html(
    //        count 
    //     )
    // });
