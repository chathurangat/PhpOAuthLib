<?php
/*
if(isset($_SESSION['user_id']) && isset($_SESSION['group_id']) &&  isset($_SESSION['name']) &&  isset($_SESSION['custermer_id'])){


   // if($_SESSION['group_id']!=4){
    if($_SESSION['group_id']==1){
        if(basename($_SERVER["PHP_SELF"])=='add-new-user.php' || basename($_SERVER["PHP_SELF"])=='marketiers-management.php' || basename($_SERVER["PHP_SELF"])=='add-cards.php' || basename($_SERVER["PHP_SELF"])=='generate-cards.php'){
            echo "<h2><center>Access denied for ".$_SESSION['name']."</center></h2>";
            die();
        }

    }

    if(basename($_SERVER["PHP_SELF"])=='activate-cards.php'){

        if($_SESSION['group_id']==4 || $_SESSION['group_id']==5){

        }else{
            echo "<h2><center>Access denied for ".$_SESSION['name']."</center></h2>";
            die();
        }



    }


    if(basename($_SERVER["PHP_SELF"])=='change-user-password.php'){

        if($_SESSION['group_id']!=2 && $_SESSION['group_id']!=3 && $_SESSION['group_id']!=4 && $_SESSION['group_id']!=1){

            echo "<h2><center>Access denied for ".$_SESSION['name']."</center></h2>";
            die();

        }
    }

        //echo basename($_SERVER["PHP_SELF"]);
        //	if(basename($_SERVER["PHP_SELF"])=='edit_cards.php'){
        //
        //	if($_SESSION['group_id']!=1 ){
        //
        //		}else{
        //				echo "<h2><center>Access denied for ".$_SESSION['name']."</center></h2>";
        //				die();
        //			}
        //
        //
        //
        //	}


    }else{

        header("Location:".HTTP_PATH."login");

    }
*/

if(!isset($_SESSION['user_id'])){

    header("Location:".HTTP_PATH."login");
}


?>