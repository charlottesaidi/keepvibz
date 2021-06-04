$(document).ready(function(){
    //SEARCH
    $(".btn_search").on('click', function(){
        $(".block_filters").toggle('slide');
    })
    $(".icon_arrow").on('click', function(){
        $(".block_filters").toggle('slide');
    })

    //SEARCH
    $(".link").on('hover', function () {
        $("a").slideDown(500);
      })

    //CAROUSSEL MOST DOWNLOADED
    $(window).load(function() {
        $('.flexslider').flexslider({
          animation: "slide",
          animationLoop: false,
          itemWidth: 210,
          itemMargin: 5
        });
    });

}