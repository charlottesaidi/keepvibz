$('#filter_btn').on('click', function() {
    $('#filter_block').slideToggle('slow');
})
$('#search_form').on('submit', function(e) {
    e.preventDefault();
    var search = $('#search').val();
    console.log(search);
    $.ajax({
        type: "POST",
        url: "/instrus/filter",
        data: search,
        dataType: "json",
        success: function(response) {
            console.log(response)
            for (var item in response) {
                // console.log(response[item].user) (vide)
                
            }
        }
    });
}) 
