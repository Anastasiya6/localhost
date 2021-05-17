jQuery(function($){

    showClientsFirstPage();
 
    // когда была нажата кнопка «страница» 
    $(document).on('click', '.pagination li', function(){
        // получаем json url 
        var json_url=$(this).find('a').attr('data-page');

        // покажем список клиентов 
        showClients(json_url);
    });

});

function showClientsFirstPage(){
    var json_url="http://localhost/api/client/read_paging.php";
    showClients(json_url);
}

// функция для отображения списка товаров 
function showClients(json_url){

    // получаем список товаров из API 
    $.getJSON(json_url, function(data){

        // HTML для перечисления товаров 
        readClientsTemplate(data, "");
    });
}