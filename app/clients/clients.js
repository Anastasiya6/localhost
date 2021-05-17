// html список клиентов
function readClientsTemplate(data, keywords){

    var read_clients_html = `
   
    <!-- начало таблицы -->
    <table class='clients table table-bordered table-hover'>

        <!-- создание заголовков таблицы -->
        <thead>
            <tr>
                <th class='w-25-pct'>Категория</th>
                <th class='w-10-pct'>Имя</th>
                <th class='w-15-pct'>Фамилия</th>
                <th class='w-25-pct'>email</th>
                <th class='w-10-pct'>Пол</th>
                <th class='w-15-pct'>Дата рождения</th>
            </tr>
        <thead>`;

    // перебор возвращаемого списка данных 
    $.each(data.records, function(key, val) {

        // создание новой строки таблицы для каждой записи 
        read_clients_html+=`
        <tbody>
            <tr>

                <td>` + val.category + `</td>
                <td>` + val.firstname + `</td>
                <td>` + val.lastname + `</td>
                <td>` + val.email + `</td>
                <td>` + val.gender + `</td>
                <td>` + val.birthDate + `</td>

            </tr>
        </tbody>`;

    });

    read_clients_html+=`</table>`;

    // pagination 
    if (data.paging) {
        read_clients_html+="<ul class='pagination pull-left margin-zero padding-bottom-2em'>";

            // первая 
            if(data.paging.first!=""){
                read_clients_html+="<li><a data-page='" + data.paging.first + "'>Первая страница</a></li>";
            }

            // перебор страниц 
            $.each(data.paging.pages, function(key, val){
                var active_page=val.current_page=="yes" ? "class='active'" : "";
                read_clients_html+="<li " + active_page + "><a data-page='" + val.url + "'>" + val.page + "</a></li>";
            });

            // последняя 
            if (data.paging.last!="") {
                read_clients_html+="<li><a data-page='" + data.paging.last + "'>Последняя страница</a></li>";
            }
            read_clients_html+="</ul>";
    }

    // добавим в «page-content» нашего приложения 
    $("#page-content").html(read_clients_html);


}