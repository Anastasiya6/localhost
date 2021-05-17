<?php
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты 
include_once '../config/database.php';
include_once '../objects/client.php';

// получаем соединение с базой данных 
$database = new Database();
$db = $database->getConnection();

$client = new Client($db);
 
// запрашиваем клиентов 
$stmt = $client->read();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей 
if ($num>0) {

    // массив клиентов 
    $clients_arr=array();
    $clients_arr["records"]=array();

    // получаем содержимое нашей таблицы 
    // fetch() быстрее, чем fetchAll() 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        // извлекаем строку 
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

    // устанавливаем код ответа - 200 OK 
    http_response_code(200);

    // выводим данные о товаре в формате JSON 
    echo json_encode($clients_arr);
}
else {

    // установим код ответа - 404 Не найдено 
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены 
    echo json_encode(array("message" => "Клиенты не найдены."), JSON_UNESCAPED_UNICODE);
}