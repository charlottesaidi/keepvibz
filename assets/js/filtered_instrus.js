
$('#search_form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/instrus/filter",
        // data: formData,
        dataType: "json",
        success: function(response) {
            // console.log(response)
            for (var item in response) {
                // console.log(response[item].user) (vide)
                $('#ajaxTest').append(
                    '<p>' + response[item].title + '</p>' // (ok)
                )
            }
        }
    });
}) 
