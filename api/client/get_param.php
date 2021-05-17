<?php
if ( isset($_GET['category']) ){

    $filter = "WHERE category = '".$_GET['category'] . "'";

    $filter_count = "&category=".$_GET['category'];

}elseif( isset($_GET['gender']) ){

    $filter = "WHERE gender = '".$_GET['gender'] . "'";

    $filter_count = "&gender=". $_GET['gender'];

}elseif( isset($_GET['birthdate']) ){

    $filter = "WHERE Year(birthDate) = '".$_GET['birthdate'] . "'";

    $filter_count = "&birthdate=". $_GET['birthdate'];

}elseif( isset($_GET['year']) ){

    $date1 = $_GET['year']."-01-01";
    $date2 = $_GET['year']."-".date("m-d");

    $date3= ($_GET['year'] - 1)."-".date("m-d");
    $date4= ($_GET['year'] - 1)."-12-31";

    $filter = " WHERE (DATE(birthDate) >= '". $date1 ."' &&  DATE(birthDate) < '". $date2."') ||
                (DATE(birthDate) > '".$date3."' && DATE(birthDate) <= '".$date4."')";

    $filter_count = "&year=". $_GET['year'];

}elseif( isset($_GET['interval_age']) ){

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
  
    $filter = " WHERE (DATE(birthDate) > '". $date2 ."' &&   DATE(birthDate) <= '".$date1."')";

    $filter_count = "&interval_age=". $_GET['interval_age'];

}
?>