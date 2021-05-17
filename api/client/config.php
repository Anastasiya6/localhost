<?php

include_once $_SERVER['DOCUMENT_ROOT']."/api/config/database.php";

// создание подключения 
$database = new Database();
$db = $database->getConnection();

$sql = "SELECT COUNT(*) as count FROM clients";
$res = $db->query($sql);
$count = $res->fetchColumn();

if ( $count == 0) {

    $url = "https://drive.google.com/u/0/uc?id=1Dwb1alDAQCAPwz7Eg306BVbWtGdfkUCy&export=download";

    $newfilename = $_SERVER['DOCUMENT_ROOT'].'/dataset.csv';

    $file = fopen($url,"r");

    $output = fopen($newfilename, 'wb');

    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
        fputcsv($output, $data);
    }

    $sql = "LOAD DATA INFILE '$newfilename'
        INTO TABLE clients  
            FIELDS TERMINATED BY ',' 
        LINES TERMINATED BY '\n'
        IGNORE 1 ROWS
        (category,firstname,lastname,email,gender,birthDate)";
    
    $res = $db->query($sql);
}
function fillSelect( $count ){

        $query = "SELECT
                        c.id, c.category, c.firstname, c.lastname, c.email, c.gender, c.birthDate
                    FROM
                        " . $this->table_name . " c
                    ORDER BY c.birthDate DESC";

// подготовка запроса 
$stmt = $this->conn->prepare( $query );

// выполняем запрос 
$stmt->execute();
$num = $stmt->rowCount();

// если больше 0 записей 
if ($num>0) {
// вернём значения из базы данных 
//return $stmt;
    
    }
}
$query = "SELECT
            category, gender, Year(birthDate) AS birthDate, birthDate as bdate
            FROM
            clients 
            ORDER BY bdate ASC";

// подготовка запроса 
$stmt = $db->prepare( $query );

// выполняем запрос 
$stmt->execute();
?>