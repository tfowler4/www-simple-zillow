var globalServices = (function() {
    this.getSearchResults = function(callBack) {
        var formData = $('#form').serialize();

        $.ajax({
            type: 'POST',
            url: 'http://localhost/www-simple-zillow/services/getSearchResults/',
            data: formData,
            dataType: 'json',
            cache: false,
            contentType : false,
            processData : false,
            beforeSend: function() {
                $('#modal-search').modal('show');
            },
            success: function(data) {

            },
            error: function(xhr, status, thrownError, error){
                console.log('error');
                console.log(xhr);
                console.log(status);
                console.log(thrownError);
                console.log(error);
            },
            complete: function(data) {        
                $('#modal-search').modal('hide');
                
                var properties = data.responseJSON;

                for ( var i = 0; i < properties.length; i++ ) {
                    var property = properties[i];
                    var html     = '';

                    html += '<tr>';
                        html += '<td scope="row" class="text-right"><img src="' + property.large_photo + '"></td>';
                        html += '<td scope="row" class="text-center"><a href="' + property.url + '" target="_blank">' + property.address + '</a></td>';
                        html += '<td scope="row" class="text-center">' + property.city + '</td>';
                        html += '<td scope="row" class="text-center">' + property.county + '</td>';
                        html += '<td scope="row" class="text-center">' + property.price + '</td>';
                        html += '<td scope="row" class="text-center">' + property.bedrooms + '</td>';
                        html += '<td scope="row" class="text-center">' + property.bathrooms + '</td>';
                        html += '<td scope="row" class="text-center">' + property.sqft + '</td>';
                        html += '<td scope="row" class="text-center">' + property.lot + '</td>';
                        html += '<td scope="row" class="text-center">' + property.work_distance + ' miles</td>';
                        html += '<td scope="row" class="text-center">' + property.work_duration + ' minutes</td>';
                    html += '</tr>';

                    $('#table-list').append(html);
                }
            },
            async: true
        });
    };

    return self;
}());