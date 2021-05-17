<?php
class Client {

    // подключение к базе данных и таблице 'clients' 
    private $conn;
    private $table_name = "clients";

    // свойства объекта 
    //public $id;
    public $category;
    public $firstname;
    public $lastname;
    public $email;
    public $gender;
    public $birthDate;

    // конструктор для соединения с базой данных 
    public function __construct($db){
        $this->conn = $db;
    }

    // метод read() - получение клиентов 
    function read( $filter="" ){
        
        if ($filter !="" ){
            $filter = "WHERE " . $filter;
        }

        // выбираем все записи 
        $query = "SELECT
                    c.id, c.category, c.firstname, c.lastname, c.email, c.gender, c.birthDate
                FROM
                    " . $this->table_name . " c
                ". $filter ."
                ORDER BY
                    c.category DESC";

        // подготовка запроса 
        $stmt = $this->conn->prepare($query);

        // выполняем запрос 
        $stmt->execute();

        return $stmt;
    }

    // чтение клиентов с пагинацией 
    public function readPaging($from_record_num, $records_per_page, $filter=""){
        
        if ($filter !="" ){
            $filter = "WHERE " . $filter;
        }
        // выборка 
        $query = "SELECT
                   id, category, firstname, lastname, email, gender, birthDate
                FROM
                    " . $this->table_name . "
                ". $filter ." 
                ORDER BY birthDate ASC
                LIMIT ?, ?";

        // подготовка запроса 
        $stmt = $this->conn->prepare( $query );

        // свяжем значения переменных 
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        // выполняем запрос 
        $stmt->execute();

        // вернём значения из базы данных 
        return $stmt;
    }

    // используется для пагинации клиентов 
    public function count($filter = ""){

        if ($filter !="" ){

            $filter = "WHERE " . $filter;
        }
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name ." " . $filter ;
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }
}
?>