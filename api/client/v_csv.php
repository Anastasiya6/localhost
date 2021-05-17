<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../objects/client.php';
include_once '../config/database.php';

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

      $filter_count .= "&";
  }

  $filter .= " gender = '".$_GET['gender'] . "'";

  $filter_count .= "&gender=". $_GET['gender'];

}
if( isset($_GET['birthdate']) ){

  if($filter != ""){

      $filter .= "&&";

      $filter_count .= "&";
  }

  $filter .= " Year(birthDate) = '".$_GET['birthdate'] . "'";

  $filter_count .= "&birthdate=". $_GET['birthdate'];

}
if( isset($_GET['year']) ){

  if($filter != ""){

      $filter .= "&&";

      $filter_count .= "&";
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

      $filter_count .= "&";
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

$stmt = $client->read($filter);
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
  } 

$file = $_SERVER['DOCUMENT_ROOT'].'/file.csv';

$fp = fopen($file, 'w');

foreach ($clients_arr["records"] as $fields) {
	fputcsv($fp, $fields, ',', '"');
}
fclose($fp);
  // установим код ответа - 201 создано 
  http_response_code(201);

  // сообщим пользователю 
  echo json_encode(array("message" => $data), JSON_UNESCAPED_UNICODE);
?>