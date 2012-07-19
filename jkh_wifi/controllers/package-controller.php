<?php
require_once('../config/config.php');
require_once('../classess/user-sql.php');
require_once('../classess/Mail.php');
require_once('../classess/packages.php');
require_once('../classess/randomStringGenerator.php');
//require_once('../Excel/reader.php');



$action = $_POST['action'];



switch ($action) {

    case 'act_searchbyusername':
        echo searchbyusername();
        break;

    case 'act_filtercards':
        echo filtercards();
        break;

    case 'act_filterservices_by_nas':
        echo filterServices();
        //echo $_POST['id'];
        break;
    case 'act_roominfo':
        echo  PACKAGES :: getroominfo();
        //echo PACKAGES :: generatecards();
        break;

    case 'act_generatecards':
        echo generatecards();
        //echo PACKAGES :: generatecards();
        break;

    case 'act_addcardsviaexcel':
        echo addcardsviaexcel();

        break;

    case 'act_addcardsbyhtlroom_admin':
        echo act_addcardsbyhtlroom();

        break;

    case 'act_addcardsbyhtlroom_reception':
        echo act_addcardsbyhtlroom_reception();

        break;

    case 'act_editcardsbyhtlroom':
        echo act_editcardsbyhtlroom();

        break;


    case 'act_getahavailablecardamount':
        echo PACKAGES :: getahavailablecardamount();
        break;

    case 'act_activatingcards':
        $activatedcards = PACKAGES :: activatingcards();
        if(count($activatedcards)==$_POST['nofcards']){
            MAIL :: notifyofactivatedcards($activatedcards);
            echo 1;
        }else{
            echo 2;
        }
        break;


    case 'change_WiFi_user_password':
        echo PACKAGES :: updatePasswordOfWiFiUsers();
        break;

    case 'change_hotel_WiFi_user_password':
        PACKAGES :: updatePasswordOfWiFiUsersInHotel();
        break;

    case 'get_hotel_graph_code':
        echo PACKAGES ::getGraphCodeBasedOnHotel();
        break;

    case 'get_hotel_graph_interface_code':
        echo PACKAGES ::getGraphAndInterfaceCodeBasedOnHotel();
        break;

    case 'load_rooms_for_hotel':
        echo PACKAGES :: showRoomListForHotel();
        break;

    case 'is_user_in_hotel_room':
        echo PACKAGES :: isUserInHotelRoom();
        break;

    default:
        echo "You dont have direct access to this page";
        die();
        break;
}




function searchbyusername(){

    $result = PACKAGES :: searchbyusername();

    //echo mysql_num_rows($result);die();
    if(mysql_num_rows($result)==0){
        echo "<br/><br/><center><b>No results found.</b></center>";
    }else{
        ?>
    <table>
        <thead>
        <tr>
            <th>Room number</th>
            <th>Hotel</th>
<!--            <th>Password</th>-->
            <th>Simultaneous Users</th>
            <th>Expiry date</th>
            <th>Service Id</th>
            <?php

            // if($_SESSION['group_id']!=1 ){ ?>
            <th>Action</th>
            <?php //}?>
        </tr>
        </thead>
        <?php
        while($rowallusers=mysql_fetch_array($result)){
            ?>
            <tr id="rmcards<?php echo $rowallusers['username'] ?>                        ">
                <!--                <td>  <a href="edit_cards.php?id=--><?php //echo $rowallusers['username']; ?><!--"><b>--><?php //echo $rowallusers['username']; ?><!--</a></b></td>-->
                <td>  <a href="../cardmanagement/view_user_history.php?id=<?php echo $rowallusers['username']; ?>"><b><?php echo $rowallusers['username']; ?></a></b></td>

                <td><?php echo PACKAGES :: getHotelbyid($rowallusers['groupid']); ?></td>
<!--                <td>--><?php //echo PACKAGES :: getPassword($rowallusers['username']); ?><!--</td>-->
                <td><?php echo PACKAGES :: getSimultanoususers($rowallusers['username']); ?></td>
                <td><?php echo $rowallusers['expiration']; ?></td>
                <td><?php echo $rowallusers['srvname']; ?></td>

                <td>

                    <a href="edit_cards.php?id=<?php echo $rowallusers['username']; ?>&srv_id=<?php echo $rowallusers['srvid']; ?>"><img src="../images/icons/pencil.png"  style="cursor:pointer;" title="Edit User Details" /></a>

                    <!--                --><?php
                    //
                    //                if($_SESSION['group_id']!=1 ){ ?>
                    <!---->
                    <!--                    <img src="../images/icons/cross.png" style="cursor:pointer;" onclick="deletefunc('rmcards--><?php //echo $rowallusers['username']; ?><!--','act_delhtlroomcard','--><?php //echo $rowallusers['username']; ?><!--','Are you sure want to delete this card ?')"/>-->
                    <!---->
                    <!--                         </td>-->
                    <!--                         --><?php //}?>



                    <?php

                    if($_SESSION['group_id']!=1 ){ ?>

                        <img src="../images/icons/cross.png" style="cursor:pointer;" onclick="deletefunc('rmcards<?php echo $rowallusers['username']; ?>','act_delhtlroomcard','<?php echo $rowallusers['username']; ?>','Are you sure want to delete this card ?')" title="Remove User" />


                        <?php }

                    if($_SESSION['group_id']==2 || $_SESSION['group_id']==3 || $_SESSION['group_id']==4 ){
                        ?>

                                                <a href="../usermanagement/change-user-password.php?id=<?php echo base64_encode($rowallusers['username']); ?>"" ><img width="16px" height="16px" src="../images/icons/key.png"  style="cursor:pointer;" title="Change Password" /></a>
                                                <?php
                                            }

                    ?>

                </td>



            </tr>
            </tr>
            <?php } ?>


    </table>
    <?php
    }



}














function addcardsviaexcel(){

    $data = new Spreadsheet_Excel_Reader();

    $data->setOutputEncoding('CP1251');

    $data->read("../cardmanagement/card_excelfiles/".$_POST['file_name']);

    $num_rows = $data->sheets[0]['numRows'] ;

    for ($i=1; $i<=$num_rows; $i++) {

        $card_no  = addslashes($data->sheets[0]['cells'][$i][1]);
        $username  = addslashes($data->sheets[0]['cells'][$i][2]);
        $pw = addslashes($data->sheets[0]['cells'][$i][3]);

        //remove LCS00
        $find[] = 'LCS00';
        $replace[] = '';
        $card_no = str_replace($find, $replace, $card_no);

        // echo $card_no."<br/>";
        // echo $username."<br/>";
        // echo $pw."<br/>";

        echo PACKAGES::addnewcardsviaexcel($card_no,$username,$pw);
    }

}



function act_addcardsbyhtlroom(){


    //    $htl_prefix = PACKAGES :: getHotelprefix();//this is to get teh hotel prefix
    //    $pw  = RANDOMSTRING::random_generator(5);
    //    PACKAGES :: deleteCurreentnumbers($htl_prefix);
    //    echo PACKAGES :: act_addcardsbyhtlroom($pw,$htl_prefix);
    //    MAIL :: notificatonOfActivatedcards($pw,$htl_prefix);




    $htl_prefix = PACKAGES :: getHotelprefix();//this is to get teh hotel prefix
    //check whether the user is avaialble
    $userName = $htl_prefix.$_POST['user_name'];


    $AvailabilityResult =  PACKAGES :: checkWhetherTheUserNameAlreadyExists($userName);

    //    if($AvailabilityResult==TRUE){
    $pw  = RANDOMSTRING::random_generator(5);
    PACKAGES :: deleteCurreentnumbers($htl_prefix);
    echo PACKAGES :: act_addcardsbyhtlroom($pw,$htl_prefix);
    MAIL :: notificatonOfActivatedcards($pw,$htl_prefix);
    //    }
    //    else{
    //
    //        echo "error#######----#######UserName is Already Taken";
    //    }

    //checking whether the user is avaialble

}



function act_addcardsbyhtlroom_reception(){


    //    $htl_prefix = PACKAGES :: getHotelprefix();//this is to get teh hotel prefix
    //    $pw  = RANDOMSTRING::random_generator(5);
    //    PACKAGES :: deleteCurreentnumbers($htl_prefix);
    //    echo	PACKAGES :: act_addcardsbyhtlroom($pw,$htl_prefix);
    //    MAIL :: notificatonOfActivatedcards($pw,$htl_prefix);

    // echo "error#######----#######Room Number is Invalid".$_POST['user_name']."|".$_SESSION['custermer_id'];

    $room_no = $_POST['user_name'];
    $hotel_no = $_SESSION['custermer_id'];

    $isValidRoom = PACKAGES :: isWiFiEnabledHotelRoom($hotel_no,$room_no);

    if($isValidRoom==TRUE){

        $htl_prefix = PACKAGES :: getHotelprefix();//this is to get teh hotel prefix
        $pw  = RANDOMSTRING::random_generator(5);
        PACKAGES :: deleteCurreentnumbers($htl_prefix);
        echo	PACKAGES :: act_addcardsbyhtlroom($pw,$htl_prefix);
        MAIL :: notificatonOfActivatedcards($pw,$htl_prefix);



    }
    else{

        echo "error#######----#######Room Number is Invalid";

    }

}


function act_editcardsbyhtlroom(){



    echo PACKAGES :: act_editcardsbyhtlroom();


}




function generatecards(){
    //echo 444;
    $add_Serial_nos = array();


    for($x=1; $x<= $_POST['no_f_cards'];$x++){
        $add_Serial_nos[] =  PACKAGES :: generatecards(RANDOMSTRING::random_generator(6),RANDOMSTRING::random_generator(10));
        //echo $x;
    }
    //require_once('../cardmanagement/printable_cards/index.php?serials="'.Serializable($add_Serial_nos).'"');
    $page=file_get_contents('http://localhost/wifinew/cardmanagement/printable_cards/index.php?serials="'.serialize($add_Serial_nos).'"');
    $fp=fopen(''.time().'hotelcreationindex.html','w+');
    fputs($fp,$page);
    fclose($fp);
    //return print_r($add_Serial_nos);
}



function filterServices(){

    $servicesofthenas = PACKAGES:: getServicesofthenas();
    echo "
	<select  name='service' id='service' onchange='filtercards()'>
	<option value=''>Please select</option>
	";
    while($row = mysql_fetch_array($servicesofthenas)){
        ?>
    <option value="<?php echo $row['srvid'];?>"><?php echo $row['srvname'];?></option>
    <?php
    }
    echo "</select>";


}


function filtercards(){

    $filtereddata = PACKAGES :: getFiltertedcards();

    if(mysql_num_rows($filtereddata)==0){
        echo "<br/><br/><center><b>No, results found.</b></center>";

    }else{


        echo "<table>
        <thead>
        <th>Serial No</th>
        <th>Username</th>
        <th>Expiry date</th>             
        </thead>";
        while($rowfiltereddata = mysql_fetch_array($filtereddata)){
            ?>

        <tr>
            <td><?php echo "LCS00".$rowfiltereddata['id']; ?></td>
            <td><?php echo $rowfiltereddata['username']; ?></td>
            <td><?php echo $rowfiltereddata['expiration']; ?></td>

        </tr>





        <?php
        }

        echo "   </table>";

    }


}





?>