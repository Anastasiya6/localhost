jQuery(function($){

    $(document).on('change', '#filter-categories', function(){

        var json_url = $('ul.pagination li.active').find('a').attr('data-page');
        json_url = json_url + "&category=" + this.value;

        $.getJSON(json_url, function(data){

            // шаблон в products.js 
            readClientsTemplate(data, "");
    
    });
    // предотвращаем перезагрузку всей страницы 
    return false;

    });

    $(document).on('change', '#filter-gender', function(){

        var json_url = $('ul.pagination li.active').find('a').attr('data-page');
        //console.log(json_url);
       
        json_url = json_url + "&gender=" + this.value;
      //  console.log(json_url);
        $.getJSON(json_url, function(data){
            // шаблон в products.js 
            readClientsTemplate(data, "");
    
    });
    // предотвращаем перезагрузку всей страницы 
    return false;

    });

    $(document).on('change', '#filter-birthdate', function(){

        var json_url = $('ul.pagination li.active').find('a').attr('data-page');
        json_url = json_url + "&birthdate=" + this.value;

        $.getJSON(json_url, function(data){

        // шаблон в products.js 
        readClientsTemplate(data, "");
    
    });
    // предотвращаем перезагрузку всей страницы 
    return false;

    });

    $(document).on('change', '#filter-age', function(){

        var json_url = $('ul.pagination li.active').find('a').attr('data-page');
        json_url = json_url + "&year=" + this.value;

        $.getJSON(json_url, function(data){

         // шаблон в products.js 
         readClientsTemplate(data, "");
     
     });
     // предотвращаем перезагрузку всей страницы 
     return false;
 
     });

     $(document).on('change', '#filter-interval-age', function(){

        var json_url = $('ul.pagination li.active').find('a').attr('data-page');
        json_url = json_url + "&interval_age=" + this.value;

        $.getJSON(json_url, function(data){
        
        // шаблон в products.js 
        readClientsTemplate(data, "");
    
    });
    // предотвращаем перезагрузку всей страницы 
    return false;

    });
});
