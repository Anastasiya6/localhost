<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>клиенты</title>

    <!-- bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">

    <!-- основной CSS -->
    <link href="app/assets/css/style.css" rel="stylesheet" />
</head>
<body>

<!-- здесь будет выводиться наше приложение -->
<div id="app"></div>
<div class="container">

    <?php include_once $_SERVER['DOCUMENT_ROOT']."/api/client/config.php";
    $filter_arr=array();

    $result = $stmt->fetchAll();

    $filter_arr['category'] = array_unique(array_column($result, 'category'));

    $filter_arr['gender'] = array_unique(array_column($result, 'gender'));
    //year birthdate
    $filter_arr['birthdate'] = array_unique(array_column($result, 'birthDate'));
    //date birthdate
    $filter_arr['bdate'] = array_unique(array_column($result, 'bdate'));
    
    $date = explode('-',$filter_arr['bdate'][0]);
    
    if( date("Y")."-".$date[1]."-".$date[2] > date("Y-m-d") ){
 
        array_shift($filter_arr['birthdate']);

    }
 
    foreach($filter_arr['birthdate'] as $val){

        $filter_arr['age'][$val] = date ( 'Y' ) - $val;
    }
    $last = array_slice($filter_arr['bdate'], -1)[0];

    $date1 = explode('-',$last);

    if( date("Y")."-".$date1[1]."-".$date1[2] > date("Y-m-d") ){

        $filter_arr['age'][$val+1] = date ( 'Y' ) - $val-1;

    }
    asort($filter_arr["age"]);
?>
<div id="page-select">
    <table class='table'>
    <tr>
        <td>
            <select id='filter-categories' class='form-control'>
            <?php
                echo "<option value = 0 selected>   </option>";
                foreach($filter_arr['category'] as $val){
                    echo "<option value = $val >  $val </option>";
                }?>
            </select>   
        </td>
        <td>
            <select id='filter-gender' class='form-control'>
                <?php
                echo "<option value = 0 selected>   </option>";
                foreach($filter_arr['gender'] as $val){
                    echo "<option value = $val >  $val  </option>";
                }?>
            </select>
        </td>
        <td>
            <select id='filter-birthdate' class='form-control'>
                <?php 
                echo "<option value = 0 selected>   </option>";
                foreach($filter_arr['birthdate'] as $val){
                    echo "<option value = $val >  $val  </option>";
                }?>
            </select>
        </td>
        <td>
            <select id='filter-age' class='form-control'>
                <?php
                echo "<option value = 0 selected>   </option>";
                foreach($filter_arr['age'] as $key => $val){
                    echo "<option value = $key > $val   </option>";
                }?>
            </select>
        </td>
        <td>
            <select id='filter-interval-age' class='form-control'><?
                echo "<option value = 0 selected>   </option>";
                echo "<option value = 1 > 16-20  </option>";
                echo "<option value = 2 > 20-25  </option>";
                echo "<option value = 3 > 25-30  </option>";
                echo "<option value = 4 > 30-35  </option>";
                echo "<option value = 5 > 35-40  </option>";
                echo "<option value = 6 > 40-45  </option>";
                echo "<option value = 7 > 45-50  </option>";
                ?>
            </select>
        </td>
        <td>
            <button class='btn btn-primary m-r-10px read-one-product-button v-csv-button'>
                <span class='glyphicon glyphicon-eye-open'></span> В csv
            </button>
        </td>
    </tr>
    </table>            
</div>

<!-- jQuery -->
<script src="app/assets/js/jquery.js"></script>

<!-- bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<!-- основной файл скриптов -->
<script src="app/app.js"></script>

<!-- clients scripts -->
<script src="app/clients/read-clients.js"></script>
<script src="app/clients/clients.js"></script>
<script src="app/clients/filter-clients.js"></script>
<script src="app/clients/v-csv-clients.js"></script>
</body>
</html>