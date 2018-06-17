var globalServices = (function() {
    this.getSearchResults = function(callBack) {
        var formData = $('#form').serialize();

        /*$.ajax({
            type: 'POST',
            url: 'http://localhost/www-simple-zillow/services/getSearchResults/',
            dataType: 'json',
            cache: false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                $('#modal-search').modal('show');
            },
            success: function(data) {
                console.log(data);
            },
            error: function(xhr, status, thrownError, error){
                console.log('error');
                console.log(xhr);
                console.log(status);
                console.log(thrownError);
                console.log(error);
            },
            complete: function(data) {
                console.log(data.responseJSON);
                setTimeout(function() {
                    $('#modal-search').modal('hide');
                    
                    var properties = data.responseJSON;

                    for ( var i = 0; i < properties.length; i++ ) {
                        var property = properties[i];
                        var html     = '';

                        html += '<tr>';
                            html += '<td scope="row" class="text-center">' + property.price + '</td>';
                            html += '<td scope="row" class="text-center">' + property.bedrooms + '</td>';
                            html += '<td scope="row" class="text-center">' + property.bathrooms + '</td>';
                            html += '<td scope="row" class="text-center">' + property.sqft + '</td>';
                            html += '<td scope="row">N/A</td>';
                        html += '</tr>';

                        $('#table-list').append(html);
                    }
                    //for (var i = 1; i < 21; i++) {
                        //$('#table-list').append('<tr><th scope="row">' + i + '</th></tr>');
                    //}
                }, 3000);
            },
            async: true
        });*/
    };

    return self;
}());