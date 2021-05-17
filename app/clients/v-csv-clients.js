jQuery(function($){

    $(document).on('click', '.v-csv-button', function(){

        var json_url = $('ul.pagination li.active').find('a').attr('data-page');

        var new_json_url = json_url.replace('read_paging', 'v_csv');
     
        $.getJSON(new_json_url, function(data){

            // readClientsTemplate(data, "");
        });

    });
 
});