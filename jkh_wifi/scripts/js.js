// js functions

function deletefunc(trid,action,id,msg){

 jConfirm(msg , 'Please Confirm', function(result){
if (result) {
		$.ajax({
   type: "POST",
   url: "../controllers/user-controller.php",
   data: "id="+id + "& action="+action,
   success: function(msg){
	   //alert(msg);
	   if(msg==1){	 
document.getElementById(trid).style.display='none';
	   }else{
		   
		   }
   }
   
 });
	
}else{
	
	
	}
  });
	
	
	}
	
	
	
	
function searchbycardusername(){
		
	var search_txt = $('#search_txt').val();
	
$('#search_results_by_username').html('<br/><br/><center><img src="../images/ajax-loader.gif"/></center>'); 
	
	$.ajax({
   type: "POST",
   url: "../controllers/package-controller.php",
   data: "search_txt="+search_txt+ "& action=act_searchbyusername",
   success: function(msg){
	  // alert(msg);
	$('#search_results_by_username').html(msg); 	   
	   
	   
	   
		 }
	 });
	
	
	
	
	
	
		
		}
	
// search function for the submit button	
 function managecardsvalidkey(e){
var keynum;
var keychar;
var numcheck;
if(window.event) // IE
{
keynum = e.keyCode;
}
else if(e.which) // Netscape/Firefox/Opera
{
keynum = e.which;
}
if(keynum==13)
{
searchbycardusername();
}
}
	
	
	
	
		
	
	
	
	
	
	
	
	
	
	
	
	
	function twin1(id){
		load_services(id);
		filtercards();
		
		}
	
	
	function getroom_info(){
		//alert(1);
		//$('#filtered_data').html('<br/><br/><center><img src="../images/ajax-loader.gif"/></center>'); 	
	var user_name = $('#user_name').val();	
	var htl_id = $('#htl_id').val();	
			$.ajax({
   type: "POST",
   url: "../controllers/package-controller.php",
   data: "user_name="+user_name+"& htl_id="+htl_id+"& action=act_roominfo",
   success: function(msg){
	// alert(msg);
	$('#msg_user_name').html(msg); //debugging	   
	   
	   
			   
		 }
	 });
		
		
		}
	
	
	
	function filtercards(){
		
	var custermer = $('#custermer').val();				
	var package = $('#package').val();
	var nas = $('#nas').val();
    var service = $('#service').val();
	var enable_disable = $('#enable_disable').val();
	
	
		
	$('#filtered_data').html('<br/><br/><center><img src="../images/ajax-loader.gif"/></center>'); 	

			$.ajax({
   type: "POST",
   url: "../controllers/package-controller.php",
   data: "custermer="+custermer+"& package="+package+"& nas="+nas+"& service="+service+"& enable_disable="+enable_disable+"& action=act_filtercards",
   success: function(msg){
	// alert(msg);
	$('#filtered_data').html(msg); //debugging	   
	   
	   
			   
		 }
	 });
		
		
		
		
		}
	
	
	
	function load_services(id){	
		//alert(id);	
		
			$.ajax({
   type: "POST",
   url: "../controllers/package-controller.php",
   data: "id="+id+ "& action=act_filterservices_by_nas",
   success: function(msg){
	// alert(msg);
	$('#service_ld').html(msg); //debugging	   
	   
	   
			   
		 }
	 });

		
		
		
		
		
		
		
		
		
		}
	
	
	
	function generatecards(){
		
	var package = $('#package').val();
	var no_f_cards = Number($('#no_f_cards').val());
	var custermer = $('#custermer').val();	
		
	if(package!='' &&  no_f_cards!=''  &&  custermer!=''  ){	
	if(isNaN(no_f_cards)){
		$('#msg_generate_cards').html('<span class="input-notification error png_bg">No of Cards should be a number.</span>');   
	
		
		}else{
		$('#msg_generate_cards').html('<span class="input-notification information png_bg">Processing...</span>');  
			 
//generating cards

		$.ajax({
   type: "POST",
   url: "../controllers/package-controller.php",
   data: "package="+package+"& no_f_cards="+no_f_cards+" & custermer="+custermer+ "& action=act_generatecards",
   success: function(msg){
	  // alert(msg);
	$('#msg_generate_cards').html(msg); //debugging	   
	   if(msg==1){
		        
//$('#msg_generate_cards').html('<span class="input-notification success png_bg">'+no_f_cards+' card(s) have been successfuly generated.</span>'); 
document.gencards.reset();		 
	 
	   }else{
//$('#msg_generate_cards').html('<span class="input-notification error png_bg">An error occured.Please contact administrator.</span>');   
		   }
	   
	   
		 }
	 });












		}

	
	}else{			
		$('#msg_generate_cards').html('<span class="input-notification error png_bg">All fields are mandetory..</span>');   
	}
		
		
		
		
		
		}
	
	
	
	

function asigncardstocustermers(){
	
	var custermer = $('#custermer').val();
	var package = $('#package').val();
	var nas = $('#nas').val();
	var service = $('#service').val();
	var nofcards = Number($('#nofcards').val());
	
	//check for blank values
	if(custermer!='' &&  package!='' && nofcards!='' && nas!='' && service!='' ){
	
	//check for numeric values
	if(isNaN(nofcards)){
		$('#msg_manage_cards').html('<span class="input-notification error png_bg">No of Cards should be a number.</span>');   
	
		
		}else{
		$('#msg_manage_cards').html('<span class="input-notification information png_bg">Processing...</span>');  
			 				
		$.ajax({
   type: "POST",
   url: "../controllers/package-controller.php",
   data: "package="+package+"& action=act_getahavailablecardamount",
   success: function(msg){

//alert(msg);
	//check the available cards are less than the requested cards
	 if(msg >= nofcards){
		 
$('#msg_manage_cards').html('<span class="input-notification success png_bg">Activating Cards.....</span>');   
		
	//Activating cards for the selected custermer	
		$.ajax({
   type: "POST",
   url: "../controllers/package-controller.php",
   data: "custermer="+custermer+"& package="+package+"& nofcards="+nofcards+"& service="+service+ "& action=act_activatingcards",
   success: function(msg){
	   
	  // alert(msg);
	//$('#msg_manage_cards').html(msg); //debugging	   
	   if(msg==1){
		        
$('#msg_manage_cards').html('<span class="input-notification success png_bg">'+nofcards+' card(s) have been successfuly activated for the selected hotel.</span>'); 
document.managecards.reset();		 
	 
	   }else{
$('#msg_manage_cards').html('<span class="input-notification error png_bg">An error occured.Please contact administrator.</span>');   
		   }
	   
	   
		 }
	 });
		
		
		
		
		
		
		
		
		
			
		
			 
		 }else{			 
			 $('#msg_manage_cards').html('<span class="input-notification error png_bg">You only have <b>'+msg+'</b> cards. Please contact Internet Department to add another <b>'+(nofcards-msg)+'</b> cards.</span>');   
			 }

		 }
	 });				
			
			}
	
	}else{
		$('#msg_manage_cards').html('<span class="input-notification error png_bg">All fields are mandetory..</span>');   
	
		}
	
	}



function emptyvalidate(){
	var custermer = $('#custermer').val();
	var datepicker = $('#datepicker').val();
	var datepicker2 = $('#datepicker2').val();
	
	if(custermer=='' || datepicker=='' || datepicker2==''){
		alert('All the fields are mendatory.');
		return false;
		}else{
			
			return true;
			}
	
	
	
	
	}







function showcustermerbox(id){
			if(id==1 || id==2){				
				document.getElementById('custermer_select_box').style.display='';				
				}else{
				document.getElementById('custermer_select_box').style.display='none';
					
			}
		}
		
		
function addnewuser(){
	//alert(1);
	var user_custermer=0;
	
	var user_name = $('#user_name').val();
	var user_password = $('#user_password').val();
	var user_confirm_password = $('#user_confirm_password').val();
	var user_email = $('#user_email').val();
	var user_group = $('#user_group').val();	
	if(user_group==1 || user_group==2 ){
	var user_custermer = $('#user_custermer').val();
	}
	
	if(user_name==''){
		$('#msg_user_name').html('<span class="input-notification error png_bg">Name cannot be blank</span>');
		}else{
		$('#msg_user_name').html('');			
	}
	
	if(user_email==''){
		$('#msg_user_email').html('<span class="input-notification error png_bg">Email cannot be blank</span>');
		}else{
		$('#msg_user_email').html('');			
	}
	
	if(user_group==''){
		$('#msg_user_group').html('<span class="input-notification error png_bg">Please select a User Group</span>');
		}else{
		$('#msg_user_group').html('');			
	}
	
	if(user_password==''){
		$('#msg_user_password').html('<span class="input-notification error png_bg">Please type a password</span>');
		}else{
if(user_password!=user_confirm_password){
		$('#msg_user_password').html('<span class="input-notification error png_bg">Both passwords should be same</span>');
		}else{
		$('#msg_user_password').html('');			
	}
				
	}
	
   if(user_confirm_password==''){
		$('#msg_user_confirm_password').html('<span class="input-notification error png_bg">Please type a confirm password</span>');
		}else{
		$('#msg_user_confirm_password').html('');			
	}
	
	
	
	
	if(user_group==3 && user_custermer=='' ){
		$('#msg_user_custermer').html('<span class="input-notification error png_bg">Please select a custermer</span>');
		}else{
		$('#msg_user_custermer').html('');			
	}
	
	
	
	
if(user_password!='' && user_confirm_password!='' && user_name!='' && user_email!='' && user_group!='' && user_confirm_password==user_password){
	
	  $('#msg_user_add').html("<span class='input-notification information png_bg'>Validating...</span>"); 
	  
	  
	  //email checking part
	  
	  
	  	$.ajax({
   type: "POST",
   url: "../controllers/user-controller.php",
   data: "action="+'act_emailavailabilitychecker' + "& user_email="+user_email,
   success: function(msg){
	// alert(msg);
	  
	  if(msg==0){	  
	  
	  
	  //adding part
	  
		$.ajax({
   type: "POST",
   url: "../controllers/user-controller.php",
   data: "action="+'act_addnewuser' + "& user_name="+user_name + "& user_password="+user_password + "& user_email="+user_email + "& user_group="+user_group + "& user_custermer="+user_custermer,
   success: function(msg){
	 //alert(msg);
	  
	  if(msg==1){
		  
	  $('#msg_user_add').html("<span class='input-notification success png_bg'>Successfully added.</span>"); 
	 	  
	  loadallusers();	  
     document.addnewusersform.reset();	
	//$('#msg_user_add').html("");  
	//$('#msg_user_add').html("").fadeOut(2000, function() { });	   
	  }else{
		  $('#msg_user_add').html("<span class='input-notification error png_bg'>Error.</span>");   
		  
		  }
	   




   }
	 });
	 
		 //end of adding part 
	 
	 
	 }else{
		 $('#msg_user_add').html("<span class='input-notification error png_bg'>Email address is already taken</span>");    
		 
		 }
		 
		 
		   }
	 });
	 

	 
	 
	 
	 
	
}else{
	//alert('no');
	}
	
	
	
	
	
	
	
	//alert(user_custermer);
	

	}	
	
	
	
	
	function loadallusers(){
		
		var id=1;
		
		$.ajax({
   type: "POST",
   url: "ajax/loadusers-ajax.php",
   data: "id="+id,
   success: function(msg){
	  $('#ajax-load-user').html(msg);   
		
		 }
	 });
	
		
		
		}
	
	function loadallmarketiers(){
		
		var id=1;
		
		$.ajax({
   type: "POST",
   url: "ajax/marketiers-ajax.php",
   data: "id="+id,
   success: function(msg){
	  $('#ajax-load-marketiers').html(msg);   
		
		 }
	 });
	
		
		
		}
	
	
function managemarketiers(){
	//alert(1);
	
	var marketiers = $('#marketiers').val();
	var marketier_custermer = $('#marketier_custermer').val();

	
	if(marketiers==''){
		$('#msg_marketiers').html('<span class="input-notification error png_bg">Please select a Marketier</span>');
		}else{
		$('#msg_marketiers').html('');			
	}
	
	if(marketier_custermer==''){
		$('#msg_marketier_custermer').html('<span class="input-notification error png_bg">Please select a client</span>');
		}else{
		$('#msg_marketier_custermer').html('');			
	}
	

	
if(marketiers!='' && marketier_custermer!=''){
	
	  $('#msg_marketier_manage').html("<span class='input-notification success png_bg'>Adding...</span>"); 
	  
	  
	  $.ajax({
   type: "POST",
   url: "../controllers/user-controller.php",
   data: "action="+'act_checkmarketierscustermers' + "& marketiers="+marketiers + "& marketier_custermer="+marketier_custermer,
   success: function(msg){
	 // alert(msg);
	  
	  if(msg==0){
	  
	  
	  
	  	  //adding
		$.ajax({
   type: "POST",
   url: "../controllers/user-controller.php",
   data: "action="+'act_managemarketier' + "& marketiers="+marketiers + "& marketier_custermer="+marketier_custermer,
   success: function(msg){
	 // alert(msg);
	  
	  if(msg==1){
	  $('#msg_marketier_manage').html("<span class='input-notification success png_bg'>Successfully added.</span>"); 
	 //$('#msg_marketier_manage').fadeOut(2000, function() { });	  	  
	  loadallmarketiers();  
      document.managemarkeriers.reset();	
	  
	  }else{
		  $('#msg_marketier_manage').html("<span class='input-notification error png_bg'>Error.</span>");   
		  
		  }
	   

   }
	 });
	 // end of adding
	 
	  }else{
		
		$('#msg_marketier_manage').html("<span class='input-notification error png_bg'>You have already added this Custermer to this marketier.</span>");   
		
		  
		  }
	
	  }
	 });
	
	
	
	
	 
	 
	
}else{
	//alert('no');
	}
	
	//alert(user_custermer);
	

	}		
		
		
	function changeadminpassword(id){
	//alert(id);
	
var old_pw = document.getElementById('old_password').value;
var new_pw = document.getElementById('new_password').value;
var c_new_pw = document.getElementById('c_new_password').value;

if(new_pw!='' && c_new_pw!='' &&  new_pw==c_new_pw ){
	//alert(2);

	
			$.ajax({
   type: "POST",
   url: "../controllers/user-controller.php",
   data: "action="+'act_oldpasswordcheck' + "& id="+id + "& old_pw="+old_pw,
  
   success: function(msg){
//alert(msg);
if(msg==1){
	
			$.ajax({
   type: "POST",
  url: "../controllers/user-controller.php",  
  data: "action="+'act_changepassword' + "& id="+id + "& c_new_pw="+c_new_pw,
  
   success: function(msg){
	//alert(msg);   
	   if(msg==1){
//$("#msger").html("successfully changed!!!!!");
$("#chpw_msg").html('<div class="input-notification success png_bg">Successfully Changed Your Password!!</div>');
$('#chpw_msg').fadeOut(2000, function() { }); 
document.addprofrm.reset();


document.getElementById('old_pw').value='';
document.getElementById('new_pw').value='';
document.getElementById('c_new_pw').value='';

	   }
   }
   
});





}else{
	//alert(msg);
	$("#chpw_msg").html('<div class="input-notification error png_bg">You haven\'t type the old password correctly<div>');
	}



//document.getElementById('save_but'+id2).style.display='none';
//document.getElementById('saved'+id).style.display='none';

 
//$("#saved"+id2).html(title);
//saved

   }
   
});
}else{
	
	if(new_pw=='' || c_new_pw=='' || old_pw==''){
			//alert("cannot be blank");
			//$("#chpw_msg").html("All fields are mandetory");
				$("#chpw_msg").html('<div class="input-notification error png_bg">All fields are mandetory</div>');
			//chpw_msg
		}else{
			
			if(new_pw!=c_new_pw){
				//alert("both passwords should be same");
				//$("#chpw_msg").html("All fields are mandetory");
				$("#chpw_msg").html('<div  class="input-notification error png_bg">Both Password and Confirm password should be match!</div>');
				}
			
			
			}
	
	//alert("chaa");
	}
	
	}	
		
	
    
    
    
    function addcardsviaexcel(){
		//alert(1);
        
            var card_package = $('#package').val();                    
            var file_name = $('#file_name').val();  
			
			
			if(card_package==''){
			
				$("#msg_added_cards").html('<div class="input-notification error png_bg">Please select a package.</div>');
				}else{
					
					
					if(file_name==''){
						$("#msg_added_cards").html('<div class="input-notification error png_bg">Please Upload the excel file.</div>');
						
						
						}else{
						
						
						
					     
        $.ajax({
   type: "POST",
   url: "../controllers/package-controller.php",
   data: "card_package="+card_package+"& file_name="+file_name+"& action="+'act_addcardsviaexcel',
   success: function(msg){
     
      // alert(msg);
      $('#msg_added_cards').html('<span class="input-notification success png_bg"> '+msg.length+' card(s) have been added.</span>');  
	  
	  
document.getElementById('package').value='';
document.getElementById('file_name').value=''; 

  $("#excel_files").html('');
        // $('#msg_added_cards').html("<span class='notification success png_bg'>Successfully added.</span>"); 
         }
     });       					
							
	}
		}
			}
	
	
	
	
	
	 
    function addcardsbyhotelroom(){
		//alert(1);
        
            var user_name = $('#user_name').val();                    
            var simultanious_users = $('#simultanious_users').val();  
			   var expire_date = $('#expire_date').val();                    
            var service = $('#service').val();  
			
			var htl_id =  $('#htl_id').val();  
			
			
			if(user_name==''){
			
				$("#msg_added_cards").html('<div class="input-notification error png_bg">Please Enter a Username / Room No.</div>');
				}else{
					
					
					if(expire_date==''){
						$("#msg_added_cards").html('<div class="input-notification error png_bg">Please Select a Expire Date.</div>');
						
						
						}else{				
						
				$("#msg_added_cards").html('<div class="input-notification information png_bg">Processing....</div>');			
					     
        $.ajax({
   type: "POST",
   url: "../controllers/package-controller.php",
   data: "user_name="+user_name+"& simultanious_users="+simultanious_users+"& expire_date="+expire_date+"& service="+service+"& htl_id="+htl_id+"& action="+'act_addcardsbyhtlroom',
   success: function(msg){
     	//window.location = "view_card_details.php?id="+user_name;
      // alert(msg);
     // $('#msg_added_cards').html('<span class="input-notification success png_bg">WiFi Card for '+user_name+' is successfully activated.<br/>  Password : '+msg+'</span>');  
	 $('#msg_added_cards').html('<span class="input-notification success png_bg">WiFi Card for '+user_name+' is successfully activated.&nbsp;&nbsp;&nbsp;&nbsp;<img  src="../images/print_icon.gif" width="20" title="Print" style="cursor:pointer;"  onclick="printsearchresults()" /><br/><div id="pw_un_res"><b>Username : '+user_name+'<br/>  Password : '+msg+'<br/>  Simultanious Users : '+simultanious_users+'<br/>  Expiry Date : '+expire_date+'</b></div></span>');   
	 
	//onclick=\"printsearchresults('thisss')\" 
	 
	 
	  
document.getElementById('user_name').value='';
document.getElementById('simultanious_users').value=''; 
document.getElementById('expire_date').value='';
document.getElementById('service').value=''; 
document.getElementById('htl_id').value=''; 


  $("#excel_files").html('');
        // $('#msg_added_cards').html("<span class='notification success png_bg'>Successfully added.</span>"); 
         }
     });    
	 		}
					
		}
        
    }
	
	
	
	
	
	
	
	 function edit_cardsbyhotelroom(){
		//alert(1);
        
            var user_name = $('#user_name').val();                    
            var simultanious_users = $('#simultanious_users').val();  
			var expire_date = $('#expire_date').val();                    
            var service = $('#service').val();  
			
			var htl_id =  $('#htl_id').val();  
			
			 var id = $('#user_name_original').val();  
			
			if(user_name==''){
			
				$("#msg_added_cards").html('<div class="input-notification error png_bg">Please Enter a Username / Room No.</div>');
				}else{
					
					
					if(expire_date==''){
						$("#msg_added_cards").html('<div class="input-notification error png_bg">Please Select a Expire Date.</div>');
						
						
						}else{			
						
						
					     
        $.ajax({
   type: "POST",
   url: "../controllers/package-controller.php",
   data: "user_name="+user_name+"& simultanious_users="+simultanious_users+"& expire_date="+expire_date+"& service="+service+"& htl_id="+htl_id+"& action="+'act_editcardsbyhtlroom'+"& id="+id,
   success: function(msg){
      setTimeout("location.href = 'manage_cards.php';",100); 
      // alert(msg);
      //$('#msg_added_cards').html('<span class="input-notification success png_bg"> '+user_name+'Successfully added.</span>');  
	  
	  
document.getElementById('user_name').value='';
document.getElementById('simultanious_users').value=''; 
document.getElementById('expire_date').value='';
document.getElementById('service').value=''; 
document.getElementById('htl_id').value=''; 


  $("#excel_files").html('');
        // $('#msg_added_cards').html("<span class='notification success png_bg'>Successfully added.</span>"); 
         }
     });       
        					
			}
		}
			     
    }

   
    function printsearchresults() {
		//alert(1);
		
    var printThis =  document.getElementById('pw_un_res').innerHTML;
  var win = window.open();
  self.focus();
  win.document.open();
  win.document.write('<'+'html'+'><'+'body'+'>');
  win.document.write(printThis);
  win.document.write('<'+'/body'+'><'+'/html'+'>');
  win.document.close();
 
  //alert(printThis);
  win.print();
  win.close();
}


	
	
	
	
	