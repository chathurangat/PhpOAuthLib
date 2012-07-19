<?php


$action = $_GET['action'];


switch($action){

    case 'autoload_hotel_room_list':
        autoloadHotelRooms();
        break;

}


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


?>
