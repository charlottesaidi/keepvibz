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

})