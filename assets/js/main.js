$(document).ready(function(){
    //SEARCH
    $(".btn_search").on('click', function(){
        $(".block_filters").toggle('slide');
    })
    $(".icon_arrow").on('click', function(){
        $(".block_filters").toggle('slide');
    })

    //CAROUSSEL MOST DOWNLOADED
    $(window).on('load', function() {
        $('.flexslider').flexslider({
          animation: "slide",
          animationLoop: false,
          itemWidth: 210,
          itemMargin: 5
        });$(document).ready(function(){
            //Page de chargement
            // $(window).on('load', function(){
            //     $('.chargement').css({
            //         "display": "none",
        
        
            //     })
            });
        
            //HEADER
            var headerOffset = $('.header').offset().top;
        
            $(window).on('scroll', function(){
              var header = $('.header'),
                  scroll = $(window).scrollTop();
            
              if (scroll >= headerOffset) header.addClass('fixed');
              else header.removeClass('fixed');
            });
        
            //SEARCH
            $(".btn_search").on('click', function(){
                $(".block_filters").toggle('slide');
            })
            $(".icon_arrow").on('click', function(){
                $(".block_filters").toggle('slide');
            })
        
            //CAROUSSEL MOST DOWNLOADED
            $('.flexslider').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 200,
            itemMargin: 20,
            minItems: 5,
            maxItems: 5,
            controlNav: false
            });
        
            $('.baba').on('click', function(e){
                e.preventDefault();
                $('#slider').flexslider('next')
            });
        
        
        
        
        
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
            
                //SEARCH
                $(".btn_search, .icon_arrow").on('click', function(){
                    $(".block_filters").toggle('slide');
                })
            
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
            
            
            
                //FOOTER
                function footerAlwayInBottom(footerSelector) {
                    var docHeight = $(window).height();
                    var footerTop = footerSelector.position().top + footerSelector.height();
                    if (footerTop < docHeight) {
                        footerSelector.css("margin-top", (docHeight - footerTop) + "px");
                    }
                }
                footerAlwayInBottom($("#footer"));
                $(window).resize(function() {
                    footerAlwayInBottom($("#footer"));
                });
            
            
                //ANCOR SMOOOTH SCROLL
                $(document).on('click', 'a[href^="#"]', function(e) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: $($.attr(this, 'href')).offset().top
                    }, 1000);
                });
                
            
            
            })
        
        
            //FOOTER
            function footerAlwayInBottom(footerSelector) {
                var docHeight = $(window).height();
                var footerTop = footerSelector.position().top + footerSelector.height();
                if (footerTop < docHeight) {
                    footerSelector.css("margin-top", (docHeight - footerTop) + "px");
                }
            }
            footerAlwayInBottom($("#footer"));
            $(window).resize(function() {
                footerAlwayInBottom($("#footer"));
            });
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        })
    });