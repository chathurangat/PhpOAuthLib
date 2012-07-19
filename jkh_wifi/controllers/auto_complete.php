<?php

//require_once('../config/config.php');
//session_start();
require_once('../config/config.php');
//require_once('../classess/packages.php');



$action = $_GET['action'];


switch($action){

    case 'autoload_hotel_room_list':
        autoloadHotelRooms();
        break;

}

/*
function autoloadHotelRooms(){


    $output = '[';

    $index=0;
    while($index<5)
    {
        $output .= '"chathuranga'.$_GET['username'].'",';

        $index++;
    }

    $output = substr($output,0,-1); //Get rid of the trailing comma
    $output .= ']';

    echo   $output;
}

*/



/*
function autoloadHotelRooms(){


    echo PACKAGES :: getWifiEnableRoomsForGivenHotel();
}
*/

function autoloadHotelRooms(){

    $hotelId = $_SESSION['custermer_id'];

    if($_SESSION['custermer_id']!=0){
    $sql = "select * from system_wifi_enable_hotel_rooms where hotel_id = ".$hotelId." AND room_id like '%".$_GET['username']."%'";
    }
    else if(isset($_GET['hotel_id']) && $_GET['hotel_id']!=""){

        $hotelId = $_GET['hotel_id'];
        $sql = "select * from system_wifi_enable_hotel_rooms where hotel_id = ".$hotelId." AND room_id like '%".$_GET['username']."%'";

    }
    else{
      $sql="select * from system_wifi_enable_hotel_rooms where room_id like '%".$_GET['username']."%'";
    }

    $result = mysql_query($sql) or die("Error occured ".mysql_errno());

    $output = '[';

   // $index=0;
  //  while($index<5)
    while($data = mysql_fetch_array($result))
    {
        //$output .= '"'.$data['room_id']."[".$sql.']",';
       // $output .= '"chathuranga'.$_SESSION['custermer_id'].'",';
       $output .= '"'.$data['room_id'].'",';

     //   $index++;
    }

    $output = substr($output,0,-1); //Get rid of the trailing comma
    $output .= ']';

    echo   $output;
}




?>
