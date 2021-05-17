<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение файлов 
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/client.php';

// utilities 
$utilities = new Utilities();

// создание подключения 
$database = new Database();
$db = $database->getConnection();

// инициализация объекта 
$client = new Client($db);

$filter = "";

$filter_count = "";

if ( isset($_GET['category']) ){

    $filter = " category = '".$_GET['category'] . "' ";

    $filter_count = "&category=".$_GET['category'];

}
if( isset($_GET['gender']) ){

    if($filter != ""){

        $filter .= "&&";

    }

    $filter .= " gender = '".$_GET['gender'] . "'";

    $filter_count .= "&gender=". $_GET['gender'];

}
if( isset($_GET['birthdate']) ){

    if($filter != ""){

        $filter .= "&&";
    }

    $filter .= " Year(birthDate) = '".$_GET['birthdate'] . "'";

    $filter_count .= "&birthdate=". $_GET['birthdate'];

}
if( isset($_GET['year']) ){

    if($filter != ""){

        $filter .= "&&";

    }

    $date1 = $_GET['year']."-01-01";
    $date2 = $_GET['year']."-".date("m-d");

    $date3= ($_GET['year'] - 1)."-".date("m-d");
    $date4= ($_GET['year'] - 1)."-12-31";

    $filter .= " (DATE(birthDate) >= '". $date1 ."' &&  DATE(birthDate) < '". $date2."') ||
                (DATE(birthDate) > '".$date3."' && DATE(birthDate) <= '".$date4."')";

    $filter_count .= "&year=". $_GET['year'];

}
if( isset($_GET['interval_age']) ){

    if($filter != ""){

        $filter .= "&&";
    }

    switch($_GET['interval_age']){

        case "1" : $year1 = date("Y") - 16 - 1; $year2 = date("Y") - 20 - 1;
        break;
        case "2" : $year1 = date("Y") - 20 - 1; $year2 = date("Y") - 25 - 1;
        break;
        case "3" : $year1 = date("Y") - 25 - 1; $year2 = date("Y") - 30 - 1;
        break;
        case "4" : $year1 = date("Y") - 30 - 1; $year2 = date("Y") - 35 - 1;
        break;
        case "5" : $year1 = date("Y") - 35 - 1; $year2 = date("Y") - 40 - 1;
        break;
        case "6" : $year1 = date("Y") - 40 - 1; $year2 = date("Y") - 45 - 1;
        break;
        case "7" : $year1 = date("Y") - 45 - 1; $year2 = date("Y") - 50 - 1;
        break;
    }

    $date1 = $year1."-12-31";

    $date2= $year2."-".date("m-d");
  
    $filter .= " (DATE(birthDate) > '". $date2 ."' &&   DATE(birthDate) <= '".$date1."')";

    $filter_count .= "&interval_age=". $_GET['interval_age'];
}

// запрос товаров 
$stmt = $client->readPaging($from_record_num, $records_per_page, $filter);
$num = $stmt->rowCount();

// если больше 0 записей 
if ($num>0) {

    $clients_arr=array();
    $clients_arr["records"]=array();
    $clients_arr["paging"]=array();

    // получаем содержимое нашей таблицы 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // извлечение строки 
        extract($row);

        $client_item=array(
            "id" => $id,
            "category" => $category,
            "firstname" => $firstname,
            "lastname" => html_entity_decode($lastname),
            "email" => $email,
            "gender" => $gender,
            "birthDate" => $birthDate
        );

        array_push($clients_arr["records"], $client_item);
    }

    // подключим пагинацию 
    $total_rows=$client->count($filter);
    $page_url="{$home_url}client/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url, $filter_count);
    $clients_arr["paging"]=$paging;

    // установим код ответа - 200 OK 
    http_response_code(200);

    // вывод в json-формате 
    echo json_encode($clients_arr);
} else {

    // код ответа - 404 Ничего не найдено 
    http_response_code(404);

    // сообщим пользователю, что товаров не существует 
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
?>