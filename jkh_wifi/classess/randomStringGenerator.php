<?php   
 class RANDOMSTRING {
  
		function random_generator($digits){
          srand ((double) microtime() * 10000000);
         
         $input = array ("a", "b", "c", "d", "e","f","g","h","j","k","m","n","p","q",
"r","s","t","u","v","w","x","y","z","3","4","6","7","8");

         $random_generator="";
         for($i=1;$i<$digits+1;$i++){

         if(rand(1,2) == 1){
  
        $rand_index = array_rand($input);
         $random_generator .=$input[$rand_index]; 

        }else{

        
        $random_generator .=rand(1,9); 
         } 
         } 
        return $random_generator;
     } 
		
}
?>