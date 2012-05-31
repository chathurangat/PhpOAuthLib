<?php
/**
 * Created by
 * Author : Chathuranga Tennakoon
 * Email  : chathuranga.t@gmail.com
 * Blog   : http://chathurangat.blogspot.com
 * Date   : 5/30/12
 * Time   : 12:40 PM
 * IDE    : JetBrains PhpStorm
 *
 */


$con = mysql_connect("localhost","root","abc123@#");
if (!$con)
{
    die('Could not connect: ' . mysql_error());
}

mysql_select_db("openvpn", $con);

$result = mysql_query("SELECT max(id) as max_id FROM tun_comp");

$result_array =array();

$result_array = mysql_fetch_array($result);

$max_id = $result_array['max_id'];


//before
$before = $max_id -1;

//getting last record

$sql =" SELECT * FROM `tun_comp` WHERE id =16";
//$sql =" SELECT * FROM `tun_comp` WHERE id =".$max_id."";

//max data
$resultsSet = mysql_query($sql);


//before data
$sql2 =" SELECT * FROM `tun_comp` WHERE id =15";
//$sql2 =" SELECT * FROM `tun_comp` WHERE id =".$before."";

$beforeResult = mysql_query($sql2);


//start

$max_data = mysql_fetch_array($resultsSet);

while($before_data = mysql_fetch_array($beforeResult)){

    $decompress = 0;
    $compress = 0;

    if(($max_data['post_decompress']-$before_data['post_decompress'])!=0){
        $decompress =  ((($max_data['pre_decompress']-$before_data['pre_decompress']) / ($max_data['post_decompress']-$before_data['post_decompress']))*100);
    }




    if(($max_data['pre_compress']-$before_data['pre_compress'])!=0){
        $compress =  ((($max_data['post_compress']-$before_data['post_compress'])/($max_data['pre_compress']-$before_data['pre_compress']))*100);

        //echo "max_post [".$max_data['post_compress']."] bef_post [".$before_data['post_compress']."] max_pre [".$max_data['pre_compress']."] bfr_pre [".$before_data['pre_compress']."]<br/>";
    }


    echo "decompress [".$decompress."] And compress [".$compress."] <br/>";

}

//end

/*
$before_compress ="";
$before_decompress = "";

while($beforeData = mysql_fetch_array($beforeResult)){

    $before_compress = ($beforeData['post_compress']  /  $beforeData ['pre_compress'])*100;
    $before_decompress = ($beforeData['pre_decompress']  / $beforeData ['post_decompress'])*100;

}

$max_compress = "";
$max_decompress = "";


while($maxData = mysql_fetch_array($resultsSet)){

    $max_compress = ($maxData['post_compress']  /  $maxData ['pre_compress'])*100;
    $max_decompress = ($maxData['pre_decompress']  / $maxData ['post_decompress'])*100;
}

$compress = $max_compress - $before_compress;
$decompress = round($max_decompress - $before_decompress);



echo "compress[".$compress."] and decompress [".$decompress."]";

*/



mysql_close($con);


?>
