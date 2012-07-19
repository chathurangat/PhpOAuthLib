<?php
//include('img-upload-watermark.php');
$uploaddir = './card_excelfiles/';


//$filename = time().'-'. basename($_FILES['uploadfile']['name']);//this is the file name
//$file = $uploaddir . $filename;// this is the full path of the uploaded file

//createThumb($_FILES['uploadfile']['tmp_name'],$uploaddir.'thumbs/'.$filename,150,100);
//createThumb($_FILES['uploadfile']['tmp_name'],$uploaddir.'re/'.$filename,244,162);
 
if (isset($_FILES['uploadfile']) && is_uploaded_file($_FILES['uploadfile']['tmp_name'])) { 
    
    $filename =  time().$_FILES['uploadfile']['name'];
     $file_path = $uploaddir.$filename;    
    
     if (!move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file_path)) {

        //error moving upload file
        echo "Error moving file upload";

    }
    
    
       echo $filename;
    
    
    
    
  //echo "success"; 
  //echo $filename;//return the file name
} else {
	echo "error";
}

?>