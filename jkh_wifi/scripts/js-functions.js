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

            document.getElementById('expire_date').value = msg;

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
    if(id!=3 && id!=4 ){
        document.getElementById('custermer_select_box').style.display='';
    }else{
        document.getElementById('custermer_select_box').style.display='none';

    }
}


function addnewuser(){
    //alert(1);
    var user_custermer=0;

    var user_name = $('#user_name').val();
    var username = $('#username').val();
    var user_password = $('#user_password').val();
    var user_confirm_password = $('#user_confirm_password').val();
    var user_email = $('#user_email').val();
    var user_group = $('#user_group').val();
    // if(user_group==1 || user_group==2 ){
    var user_custermer = $('#user_custermer').val();
    //  }

    if(user_name==''){
        $('#msg_user_name').html('<span class="input-notification error png_bg">Name cannot be blank</span>');
    }else{
        $('#msg_user_name').html('');
    }

    if(username==''){
        $('#msg_username').html('<span class="input-notification error png_bg">Username cannot be blank</span>');
    }else{
        $('#msg_username').html('');
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
            data: "action="+'act_emailavailabilitychecker' + "& user_email="+user_email+"&username="+username,
            success: function(msg){

                var message_type =  msg.split("####")[0];


                if(message_type=='success'){


                    //adding part

                    $.ajax({
                        type: "POST",
                        url: "../controllers/user-controller.php",
                        data: "action="+'act_addnewuser' + "& username="+username +"& user_name="+user_name + "& user_password="+user_password + "& user_email="+user_email + "& user_group="+user_group + "& user_custermer="+user_custermer,
                        success: function(msg){
                            //alert(msg);

                            if(msg!=''){

                                $('#msg_user_add').html("<span class='input-notification success png_bg'>Successfully added.</span>");

                                loadallusers();
                                document.addnewusersform.reset();
                                //alert('added user id'+msg);
                                //$('#msg_user_add').html("");
                                //$('#msg_user_add').html("").fadeOut(2000, function() { });
                                //redirecting user to relevant page

                                window.location = 'change-user-privileges.php?u_id='+msg;

                            }else{
                                $('#msg_user_add').html("<span class='input-notification error png_bg'>Error.</span>");

                            }

                        }
                    });

                    //end of adding part


                }else{


                    var message  = msg.split("####")[1];

                    $('#msg_user_add').html("<span class='input-notification error png_bg'>"+message+"</span>");

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





/*
 function addcardsbyhotelroom(user_type){
 //alert(1);


 var user_name = $('#user_name').val();
 var simultanious_users = $('#simultanious_users').val();
 var expire_date = $('#expire_date').val();
 var expire_date_value = $('#expire_date').val();
 var service = $('#service').val();
 var validity = true;
 var identity_no = $('#identity_no').val();
 var contact_name = $('#contact_name').val();

 var htl_id =  $('#htl_id').val();

 var hotel_code = $('#hotel_code').val();

 expire_date = expire_date+' 23:59:59';

 //alert(expire_date);
 //alert('2012-01-20 00:00:00');
 if(jQuery.trim(user_name)==''){

 validity = false;
 $('#msg_username').html('Please Enter a Username / Room No.');
 //$("#msg_added_cards").html('<div class="input-notification error png_bg">Please Enter a Username / Room No.</div>');

 }
 else{
 $('#msg_username').html('');
 }

 if(htl_id==""){

 validity = false;
 $("#msg_hotel").html('Please select the Hotel');

 }
 else{

 $("#msg_hotel").html('');

 }
 if(jQuery.trim(expire_date_value)==""){

 validity = false;
 $('#msg_expire_date').html('Please Select Expire Date');
 }
 else{

 $('#msg_expire_date').html('');

 if(expire_date==''){
 $("#msg_added_cards").html('<div class="input-notification error png_bg">Please Select a Expire Date.</div>');


 }else{

 if(validity==true){
 jConfirm('Are you Sure want to add this user?  <br/><br/><div  style="font-size:24px;color:#F00;"  id="pw_un_res"><b>Username : '+hotel_code+user_name+'</div><br/>&nbsp; &nbsp; &nbsp;  Simultanious Users : '+simultanious_users+'<br/><br/>  &nbsp; &nbsp; &nbsp; Expiry Date : '+expire_date+'</b> ' , 'Please Confirm', function(result){
 if (result) {


 $("#msg_added_cards").html('<div class="input-notification information png_bg">Processing....</div>');

 $.ajax({
 type: "POST",
 url: "../controllers/package-controller.php",
 // data: "user_name="+user_name+"& simultanious_users="+simultanious_users+"& expire_date="+expire_date+"& service="+service+"& htl_id="+htl_id+"& action="+'act_addcardsbyhtlroom'+'&identity_no='+identity_no+'&contact_name='+contact_name,
 data: "user_name="+user_name+"& simultanious_users="+simultanious_users+"& expire_date="+expire_date+"& service="+service+"& htl_id="+htl_id+"& action="+'act_addcardsbyhtlroom_'+user_type+'&identity_no='+identity_no+'&contact_name='+contact_name,
 success: function(msg){
 // alert(msg);

 var message_type = msg.split("#######----#######")[0];
 var message = msg.split("#######----#######")[1];

 if(message_type!='error'){
 window.location = "view_card_details.php?id="+msg;

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
 else{

 // alert('error')
 $('#msg_username').html(message);
 $("#msg_added_cards").html('');
 }
 }
 });



 }else{


 }
 });

 }//if validity

 }
 }

 }
 */




function addcardsbyhotelroom(user_type){
    //alert(1);


    var user_name = $('#user_name').val();
    var simultanious_users = $('#simultanious_users').val();
    var expire_date = $('#expire_date').val();
    var expire_date_value = $('#expire_date').val();
    var service = $('#service').val();
    var validity = true;
    var identity_no = $('#identity_no').val();
    var contact_name = $('#contact_name').val();

    var htl_id =  $('#htl_id').val();

    var hotel_code = $('#hotel_code').val();

    expire_date = expire_date+' 23:59:59';

    //alert(expire_date);
    //alert('2012-01-20 00:00:00');
    if(jQuery.trim(user_name)==''){

        validity = false;
        $('#msg_username').html('Please Enter a Username / Room No.');
        //$("#msg_added_cards").html('<div class="input-notification error png_bg">Please Enter a Username / Room No.</div>');

    }
    else{
        $('#msg_username').html('');
    }

    if(htl_id==""){

        validity = false;
        $("#msg_hotel").html('Please select the Hotel');

    }
    else{

        $("#msg_hotel").html('');

    }
    if(jQuery.trim(expire_date_value)==""){

        validity = false;
        $('#msg_expire_date').html('Please Select Expire Date');
    }
    else{

        $('#msg_expire_date').html('');

        if(expire_date==''){
            $("#msg_added_cards").html('<div class="input-notification error png_bg">Please Select a Expire Date.</div>');


        }else{

            if(validity==true){
                jConfirm('Are you Sure want to add this user?  <br/><br/><div  style="font-size:24px;color:#F00;"  id="pw_un_res"><b>Username : '+hotel_code+user_name+'</div><br/>&nbsp; &nbsp; &nbsp;  Simultanious Users : '+simultanious_users+'<br/><br/>  &nbsp; &nbsp; &nbsp; Expiry Date : '+expire_date+'</b> ' , 'Please Confirm', function(result){
                    if (result) {


                        $.ajax({
                            type: "POST",
                            url: "../controllers/package-controller.php",
                            // data: "user_name="+user_name+"& simultanious_users="+simultanious_users+"& expire_date="+expire_date+"& service="+service+"& htl_id="+htl_id+"& action="+'act_addcardsbyhtlroom'+'&identity_no='+identity_no+'&contact_name='+contact_name,
                            data: "user_name="+user_name+"& action="+'is_user_in_hotel_room'+'&htl_id='+htl_id,
                            success: function(msg){

                                var num_users = msg.split("####")[0];
                                var user_details = msg.split("####")[1];

                                if(num_users==0){

                                    $("#msg_added_cards").html('<div class="input-notification information png_bg">Processing....</div>');

                                    $.ajax({
                                        type: "POST",
                                        url: "../controllers/package-controller.php",
                                        // data: "user_name="+user_name+"& simultanious_users="+simultanious_users+"& expire_date="+expire_date+"& service="+service+"& htl_id="+htl_id+"& action="+'act_addcardsbyhtlroom'+'&identity_no='+identity_no+'&contact_name='+contact_name,
                                        data: "user_name="+user_name+"& simultanious_users="+simultanious_users+"& expire_date="+expire_date+"& service="+service+"& htl_id="+htl_id+"& action="+'act_addcardsbyhtlroom_'+user_type+'&identity_no='+identity_no+'&contact_name='+contact_name,
                                        success: function(msg){
                                            // alert(msg);

                                            var message_type = msg.split("#######----#######")[0];
                                            var message = msg.split("#######----#######")[1];

                                            if(message_type!='error'){
                                                window.location = "view_card_details.php?id="+msg;

                                                // $('#msg_added_cards').html('<span class="input-notification success png_bg">WiFi Card for '+user_name+' is successfully activated.<br/>  Password : '+msg+'</span>');
                                                $('#msg_added_cards').html('<span class="input-notification success png_bg">WiFi Card for '+user_name+' is successfully activated.&nbsp;&nbsp;&nbsp;&nbsp;<img  src="../images/print_icon.gif" width="20" title="Print" style="cursor:pointer;"  onclick="printsearchresults()" /><br/><div id="pw_un_res"><b>Username : '+user_name+'<br/>  Password : '+msg+'<br/>  Simultanious Users : '+simultanious_users+'<br/>  Expiry Date : '+expire_date+'</b></div></span>');

                                                document.getElementById('user_name').value='';
                                                document.getElementById('simultanious_users').value='';
                                                document.getElementById('expire_date').value='';
                                                document.getElementById('service').value='';
                                                document.getElementById('htl_id').value='';

                                                $("#excel_files").html('');
                                                // $('#msg_added_cards').html("<span class='notification success png_bg'>Successfully added.</span>");
                                            }
                                            else{

                                                // alert('error')
                                                $('#msg_username').html(message);
                                                $("#msg_added_cards").html('');
                                            }
                                        }
                                    });

                                    // alert('no user');

                                }//if msg==0
                                else{

                                    //alert('there are registered users');
//                                    jConfirm('User  already exists. Do you want to remove the existing User and add new User?  <br/><br/>Room : 401<br/>&nbsp; &nbsp; &nbsp;  Simultanious Users : '+simultanious_users+'<br/><br/>  &nbsp; &nbsp; &nbsp; Expiry Date : '+expire_date+'</b> ' , 'Please Confirm', function(result){
                                    jConfirm('<div  style="font-size:24px;color:#F00;"  id="pw_un_res"><b>User already exists. </b></div><br/>'+user_details+'<br/> Do you want to remove the existing User and add new User?  <br/>' , 'Please Confirm', function(result){

                                        if(result){

                                            $.ajax({
                                                type: "POST",
                                                url: "../controllers/package-controller.php",
                                                // data: "user_name="+user_name+"& simultanious_users="+simultanious_users+"& expire_date="+expire_date+"& service="+service+"& htl_id="+htl_id+"& action="+'act_addcardsbyhtlroom'+'&identity_no='+identity_no+'&contact_name='+contact_name,
                                                data: "user_name="+user_name+"& simultanious_users="+simultanious_users+"& expire_date="+expire_date+"& service="+service+"& htl_id="+htl_id+"& action="+'act_addcardsbyhtlroom_'+user_type+'&identity_no='+identity_no+'&contact_name='+contact_name,
                                                success: function(msg){
                                                    // alert(msg);

                                                    var message_type = msg.split("#######----#######")[0];
                                                    var message = msg.split("#######----#######")[1];

                                                    if(message_type!='error'){
                                                        window.location = "view_card_details.php?id="+msg;

                                                        // $('#msg_added_cards').html('<span class="input-notification success png_bg">WiFi Card for '+user_name+' is successfully activated.<br/>  Password : '+msg+'</span>');
                                                        $('#msg_added_cards').html('<span class="input-notification success png_bg">WiFi Card for '+user_name+' is successfully activated.&nbsp;&nbsp;&nbsp;&nbsp;<img  src="../images/print_icon.gif" width="20" title="Print" style="cursor:pointer;"  onclick="printsearchresults()" /><br/><div id="pw_un_res"><b>Username : '+user_name+'<br/>  Password : '+msg+'<br/>  Simultanious Users : '+simultanious_users+'<br/>  Expiry Date : '+expire_date+'</b></div></span>');

                                                        document.getElementById('user_name').value='';
                                                        document.getElementById('simultanious_users').value='';
                                                        document.getElementById('expire_date').value='';
                                                        document.getElementById('service').value='';
                                                        document.getElementById('htl_id').value='';


                                                        $("#excel_files").html('');
                                                        // $('#msg_added_cards').html("<span class='notification success png_bg'>Successfully added.</span>");
                                                    }
                                                    else{

                                                        // alert('error')
                                                        $('#msg_username').html(message);
                                                        $("#msg_added_cards").html('');
                                                    }
                                                }
                                            });

                                        }

                                    });

                                }
                            }//success

                        });


                    }else{


                    }
                });

            }//if validity

        }
    }

}




function set_hotel_code(hotel_code){


    $('#hotel_code').val(hotel_code);

}//set_hotel_code





function edit_cardsbyhotelroom(){
    //alert(1);

    var user_name = $('#user_name').val();
    var simultanious_users = $('#simultanious_users').val();
    var expire_date = $('#expire_date').val();
    var service = $('#service').val();

    var htl_id =  $('#htl_id').val();

    expire_date = expire_date+' 23:59:59';


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






function change_user_passwords(){

    // alert('change');

    var user_password = $('#user_new_password').val();
    var user_password_confirmation = $('#user_confirm_password').val();

    var username = $('#username').val();

    if(jQuery.trim(user_password)=="" && jQuery.trim(user_password_confirmation)==""){

        $('#user_pw_change_msg').html('<div class="input-notification error png_bg"> Password and Password Confirmation is required</div>');

    }
    else if(jQuery.trim(user_password)==""){

        $('#user_pw_change_msg').html('<div class="input-notification error png_bg"> Password is required</div>');

    }
    else if(jQuery.trim(user_password_confirmation)==""){

        $('#user_pw_change_msg').html('<div class="input-notification error png_bg">Password Confirmation is required</div>');

    }

    else  if((user_password != user_password_confirmation)){

        $('#user_pw_change_msg').html('<div class="input-notification error png_bg"> Password and Password Confirmation does not match</div>');
    }
    else{

        $.ajax({
            type: "POST",
            url: "../controllers/package-controller.php",
            data: "user_new_password="+user_password+"&action=change_WiFi_user_password&username="+username,
            success: function(msg){

                $('#user_pw_change_msg').html('<span class="input-notification success png_bg">Password was Succesfully Changed  </span>');

            }
        });//ajax

    }


}//change_user_passwords





/*
 function change_wifi_user_passwords(){

 // alert('change');

 var user_password = $('#user_new_password').val();
 var user_password_confirmation = $('#user_confirm_password').val();
 var user_old_password = $('#user_old_password').val();

 var username = $('#username').val();

 if(jQuery.trim(user_password)=="" && jQuery.trim(user_password_confirmation)==""){

 $('#user_pw_change_msg').html('<div style="color: #bb0000;font-weight: bold;"> Password and Password Confirmation is required</div>');

 }
 else if(jQuery.trim(user_password)==""){

 $('#user_pw_change_msg').html('<div style="color: #bb0000;font-weight: bold;"> Password is required</div>');

 }
 else if(jQuery.trim(user_password_confirmation)==""){

 $('#user_pw_change_msg').html('<div style="color: #bb0000;font-weight: bold;">PW Confirmation is required</div>');

 }

 else  if((user_password != user_password_confirmation)){

 $('#user_pw_change_msg').html('<div style="color: #bb0000;font-weight: bold;"> Password and Password Confirmation does not match</div>');
 $('#user_confirm_password').val('');
 $('#user_new_password').val('');

 }
 else{

 $.ajax({
 type: "POST",
 url: "../controllers/package-controller.php",
 data: "user_new_password="+user_password+"&action=change_hotel_WiFi_user_password&username="+username+"&user_old_password="+user_old_password,
 success: function(msg){

 if(msg=="pw_changed"){

 $('#user_pw_change_msg').html('<span style="color: #9adf8f;font-weight: bold;">Password was Succesfully Changed  </span>');
 }
 else if(msg=="no_user_found"){

 $('#user_pw_change_msg').html('<spanstyle="color: #bb0000;font-weight: bold;">Old Password is incorrect</span>');

 }

 $('#user_new_password').val('');
 $('#user_confirm_password').val('');
 $('#user_old_password').val('');


 }
 });//ajax

 }


 }//change_user_passwords
 */




function change_wifi_user_passwords(){

    /*

     var user_password = $('#user_new_password').val();
     var user_password_confirmation = $('#user_confirm_password').val();
     var user_old_password = $('#user_old_password').val();

     var username = $('#username').val();

     if(jQuery.trim(user_password)=="" && jQuery.trim(user_password_confirmation)==""){

     $('#user_pw_change_msg').html('<div style="color: #bb0000;font-weight: bold;"> Password and Password Confirmation is required</div>');

     }
     else if(jQuery.trim(user_password)==""){

     $('#user_pw_change_msg').html('<div style="color: #bb0000;font-weight: bold;"> Password is required</div>');

     }
     else if(jQuery.trim(user_password_confirmation)==""){

     $('#user_pw_change_msg').html('<div style="color: #bb0000;font-weight: bold;">PW Confirmation is required</div>');

     }

     else  if((user_password != user_password_confirmation)){

     $('#user_pw_change_msg').html('<div style="color: #bb0000;font-weight: bold;"> Password and Password Confirmation does not match</div>');
     $('#user_confirm_password').val('');
     $('#user_new_password').val('');

     }
     else{

     $.ajax({
     type: "POST",
     url: "../controllers/package-controller.php",
     data: "user_new_password="+user_password+"&action=change_hotel_WiFi_user_password&username="+username+"&user_old_password="+user_old_password,
     success: function(msg){

     if(msg=="pw_changed"){

     $('#user_pw_change_msg').html('<span style="color: #9adf8f;font-weight: bold;">Password was Succesfully Changed  </span>');
     }
     else if(msg=="no_user_found"){

     $('#user_pw_change_msg').html('<spanstyle="color: #bb0000;font-weight: bold;">Old Password is incorrect</span>');

     }

     $('#user_new_password').val('');
     $('#user_confirm_password').val('');
     $('#user_old_password').val('');


     }
     });//ajax

     }
     */


    var user_old_pw = document.getElementById('user_old_password').value;
    var user_new_pw = document.getElementById('user_new_password').value;
    var user_confirm_password = document.getElementById('user_confirm_password').value;


    //alert('user old'+user_old_pw+'user new'+user_new_pw+'user confirm '+user_confirm_password);

//    if(trim(user_old_pw)==""){
//
//        alert("user old password is required");
//
//    }
//    else if(trim(user_new_pw)=="" && trim(user_confirm_password)==""){
//
//        alert("password and password confirmation is required");
//
//    }

    if(trim(user_new_pw)=="" || trim(user_confirm_password)=="" || (trim(user_old_pw)=="")){

        alert("required field is missing");
        return false;
    }
    else if(trim(user_new_pw)!=trim(user_confirm_password)){

        alert("password and password confirmation does not match");
        return false;

    }


    return true;


}//change_user_passwords


function trim(str) {
    return str.replace(/^\s+|\s+$/g,"");
}



//function filterAndLoadUsageDetails(){
//
//    hotelId = 123;
//
//    var start_date = $('#start_date').val();
//    var stop_date = $('#stop_date').val();
//
//
//    if(jQuery.trim(start_date)!="" && jQuery.trim(stop_date)!=""){
//
//        //alert('load page');
//        //window.location.href = "view_user_history.php?id="+hotelId+"&filter=true";
//        return true;
//
//    }
//    else{
//
//        return false;
//    }
//
//
//
//}



function loadRoomsBasedOnHotel(hotelId){

    //  $('#hotel').val(hotelId);
    //  var value = $('#hotel').val();


    $.ajax({
        type: "POST",
        url: "../controllers/package-controller.php",
        data: "hotel_id="+hotelId+"&action=load_rooms_for_hotel",
        success: function(msg){

            $('#room_no_selection').html(msg);
        }
    });//ajax


}



function validateWiFiUsageReportRequest(){


    var hotel_id = jQuery.trim($('#hotel_list').val());
    var room_no =  jQuery.trim($('#room_no').val());
    var date_from = jQuery.trim($('#datepicker_from').val());
    var date_to =  jQuery.trim($('#datepicker_to').val());


    if(hotel_id!="" && room_no != "" && date_from!="" && date_to!=""){

        return true;
    }
    else{

        alert('All the fields are mandatory');
        return false;
    }


}//validateWiFiUsageReportRequest








function validateWiFiHotelUsageReportRequest(){

    var hotel_id = jQuery.trim($('#hotel').val());
    var date_from = jQuery.trim($('#datepicker_from').val());
    var date_to =  jQuery.trim($('#datepicker_to').val());


    if(hotel_id!="" && date_from!="" && date_to!=""){

        return true;
    }
    else{

        alert('All the fields are mandatory');
        return false;
    }

}







function displayDailyGraphForGivenHotel(hotelId){

    if(hotelId!=""){
        //alert("hotel id"+hotelId);


        //ajax
        $.ajax({
            type: "POST",
            url: "../controllers/package-controller.php",

            data: "hotel_id="+hotelId+"&action=get_hotel_graph_code",
            success: function(msg){

                if(jQuery.trim(msg)!=""){

                    var  src = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg.split("######")[0]+"&bars=Cami&xgtype=d&page=graph&xgstyle=y3&xmtype=options&if=_summary_";

                    //$('#graph_frame_div').html('src is'+src);
                    $('#graph_frame_div').html('<iframe id="graph_frame" name="graph_frame" width="900px;" height="1500px;" src="'+src+'"></iframe>');

                }
                else{

                    $('#graph_frame_div').html('<h3>No Graphs is available for the selected hotel</h3>');
                }
            }

        });


    }
    else{
        alert("please select a hotel");
    }
}




function displayWeeklyGraphForGivenHotel(hotelId){

    if(hotelId!=""){
        //alert("hotel id"+hotelId);


        //ajax
        $.ajax({
            type: "POST",
            url: "../controllers/package-controller.php",

            data: "hotel_id="+hotelId+"&action=get_hotel_graph_code",
            success: function(msg){

                if(jQuery.trim(msg)!=""){

                    // var  src = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&xgtype=d&page=graph&xgstyle=y3&xmtype=options&if=_summary_";
                    var  src = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg.split("######")[0]+"&bars=Cami&xgtype=w&page=graph&xgstyle=y3&xmtype=options&if=_summary_";
                    //$('#graph_frame_div').html('src is'+src);
                    $('#graph_frame_div').html('<iframe id="graph_frame" name="graph_frame" width="900px;" height="1500px;" src="'+src+'"></iframe>');

                }
                else{

                    $('#graph_frame_div').html('<h3>No Graphs is available for the selected hotel</h3>');
                }
            }

        });


    }
    else{
        alert("please select a hotel");
    }
}





function displayMonthlyGraphForGivenHotel(hotelId){

    if(hotelId!=""){
        //alert("hotel id"+hotelId);


        //ajax
        $.ajax({
            type: "POST",
            url: "../controllers/package-controller.php",

            data: "hotel_id="+hotelId+"&action=get_hotel_graph_code",
            success: function(msg){

                if(jQuery.trim(msg)!=""){

                    // var  src = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&xgtype=d&page=graph&xgstyle=y3&xmtype=options&if=_summary_";
                    var  src = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg.split("######")[0]+"&bars=Cami&page=graph&xgtype=m&xgstyle=y3&if=_summary_&xmtype=options";

                    //$('#graph_frame_div').html('src is'+src);
                    $('#graph_frame_div').html('<iframe id="graph_frame" name="graph_frame" width="900px;" height="1500px;" src="'+src+'"></iframe>');

                }
                else{

                    $('#graph_frame_div').html('<h3>No Graphs is available for the selected hotel</h3>');
                }
            }

        });


    }
    else{
        alert("please select a hotel");
    }
}








/*
 function displayWiFiUsageGraphForGivenHotel(hotelId){

 if(hotelId!=""){
 //alert("hotel id"+hotelId);


 //ajax
 $.ajax({
 type: "POST",
 url: "../controllers/package-controller.php",

 data: "hotel_id="+hotelId+"&action=get_hotel_graph_interface_code",
 success: function(msg){

 if(jQuery.trim(msg)!=""){

 var graph_code= msg.split("####")[0];
 var interface_code = msg.split("####")[1];

 // var  src = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&xgtype=d&page=graph&xgstyle=y3&xmtype=options&if=_summary_";
 var  src = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+graph_code+"&bars=Cami&xgtype=6&page=graph&xgstyle=x3&xmtype=options&if="+interface_code;

 //$('#graph_frame_div').html('src is'+src);
 $('#graph_frame_div').html('<iframe id="graph_frame" name="graph_frame" width="900px;" height="800px;" src="'+src+'"></iframe>');

 }
 else{

 $('#graph_frame_div').html('<h3>No Graphs is available for the selected hotel</h3>');
 }
 }

 });


 }
 else{
 alert("please select a hotel");
 }
 }
 */



function displayWiFiUsageGraphForGivenHotel(hotelId){

    if(hotelId!=""){
        //alert("hotel id"+hotelId);


        //ajax
        $.ajax({
            type: "POST",
            url: "../controllers/package-controller.php",

            data: "hotel_id="+hotelId+"&action=get_hotel_graph_interface_code",
            success: function(msg){

                if(jQuery.trim(msg)!=""){

                    var graph_code= msg.split("####")[0];
                    var interface_codes = msg.split("####")[1];

                    var interface1 = interface_codes.split("***")[0];
                    var interface2 = interface_codes.split("***")[1];

                    if(interface2===undefined){

                        // var  src = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&xgtype=d&page=graph&xgstyle=y3&xmtype=options&if=_summary_";
                        var  src = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+graph_code+"&bars=Cami&xgtype=6&page=graph&xgstyle=x3&xmtype=options&if="+interface1;

                        //$('#graph_frame_div').html('src is'+src);
                        $('#graph_frame_div').html('<iframe id="graph_frame" name="graph_frame" width="900px;" height="800px;" src="'+src+'"></iframe>');
                        $('#graph_frame_div2').html('');
                    }
                    else{

                        var  src1 = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+graph_code+"&bars=Cami&xgtype=6&page=graph&xgstyle=x3&xmtype=options&if="+interface1;
                        var  src2 = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+graph_code+"&bars=Cami&xgtype=6&page=graph&xgstyle=x3&xmtype=options&if="+interface2;

                        $('#graph_frame_div').html('<iframe id="graph_frame" name="graph_frame" width="900px;" height="800px;" src="'+src1+'"></iframe>');
                        $('#graph_frame_div2').html('<iframe id="graph_frame2" name="graph_frame2" width="900px;" height="800px;" src="'+src2+'"></iframe>');


                    }
                }
                else{

                    $('#graph_frame_div').html('<h3>No Graphs is available for the selected hotel</h3>');
                }
            }

        });


    }
    else{
        alert("please select a hotel");
    }
}







function displayHourlyGraphForGivenHotel(hotelId){

    if(hotelId!=""){
        //alert("hotel id"+hotelId);


        //ajax
        $.ajax({
            type: "POST",
            url: "../controllers/package-controller.php",

            data: "hotel_id="+hotelId+"&action=get_hotel_graph_code",
            success: function(msg){

                if(jQuery.trim(msg)!=""){

                    var  src = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg.split("######")[0]+"&bars=Cami&xgtype=6&page=graph&xgstyle=y3&xmtype=options&if=_summary_";
                    //$('#graph_frame_div').html('src is'+src);
                    $('#graph_frame_div').html('<iframe id="graph_frame" name="graph_frame" width="900px;" height="1500px;" src="'+src+'"></iframe>');

                }
                else{

                    $('#graph_frame_div').html('<h3>No Graphs is available for the selected hotel</h3>');
                }
            }

        });


    }
    else{
        alert("please select a hotel");
    }
}







//function displayAllWifiUsageForGivenHotel(hotelId){
//
//    if(hotelId!=""){
//        //alert("hotel id"+hotelId);
//
//
//        //ajax
//        $.ajax({
//            type: "POST",
//            url: "../controllers/package-controller.php",
//
//            data: "hotel_id="+hotelId+"&action=get_hotel_graph_code",
//            success: function(msg){
//
//                if(jQuery.trim(msg)!=""){
//
//                    var hourly = "";
//                    var daily = "";
//                    var weekly = "";
//                    var monthly = "";
//
//                    if(msg=='chaayaVillage.cfg'){
//
//                        var hourlyEther2 = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&page=graph&xgtype=6&xgstyle=x3&if=116.12.87.2_ether2&xmtype=options";
//                        var hourlyEther3 = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&page=graph&xgtype=6&xgstyle=x3&if=116.12.87.2_ether3&xmtype=options";
//                        var dailyEther2 = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&page=graph&xgtype=d&xgstyle=x3&if=116.12.87.2_ether2&xmtype=options";
//                        var dailyEther3 = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&page=graph&xgtype=d&xgstyle=x3&if=116.12.87.2_ether3&xmtype=options";
//                        var weeklyEther2 = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&page=graph&xgtype=w&xgstyle=x3&if=116.12.87.2_ether2&xmtype=options";
//                        var weeklyEther3 = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&page=graph&xgtype=w&xgstyle=x3&if=116.12.87.2_ether3&xmtype=options";
//                        var monthlyEther2 = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&page=graph&xgtype=m&xgstyle=x3&if=116.12.87.2_ether2&xmtype=options";
//                        var monthlyEther3 = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&page=graph&xgtype=m&xgstyle=x3&if=116.12.87.2_ether3&xmtype=options";
//
//
//                        $('#graph_frame_div').html('<h3>Hourly Graph</h3><iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="'+hourlyEther2+'"></iframe>' +
//                            '<iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="'+hourlyEther3+'"></iframe>' +
//                            '<h3>Daily Graph</h3><iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="'+dailyEther2+'"></iframe>' +
//                            '<iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="'+dailyEther3+'"></iframe>' +
//                            '<h3>Weekly Graph</h3><iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="'+weeklyEther2+'"></iframe>' +
//                            '<iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="'+weeklyEther3+'"></iframe>' +
//                            '<h3>Monthly Graph</h3><iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="'+monthlyEther2+'"></iframe>'+
//                            '<iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="'+monthlyEther3+'"></iframe>');
//                    }
//
//                    else if(msg=='chaayaTranz.cfg'){
//
//                         hourly = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&page=graph&xgtype=6&xgstyle=x3&if=198.18.1.180_ether2&xmtype=options";
//                         daily =  "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&page=graph&xgtype=d&xgstyle=x3&if=198.18.1.180_ether2&xmtype=options";
//                         weekly = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&page=graph&xgtype=w&xgstyle=x3&if=198.18.1.180_ether2&xmtype=options";
//                         monthly = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&page=graph&xgtype=m&xgstyle=x3&if=198.18.1.180_ether2&xmtype=options";
//
//
//                        $('#graph_frame_div').html('<h3>Hourly Graph</h3><iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="'+hourly+'"></iframe>' +
//                            '<h3>Daily Graph</h3><iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="'+daily+'"></iframe>' +
//                            '<h3>Weekly Graph</h3><iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="'+weekly+'"></iframe>' +
//                            '<h3>Monthly Graph</h3><iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="'+monthly+'"></iframe>');
//                    }
//                    else{
//
//                         hourly = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&page=graph&xgtype=6&xgstyle=x2&if=203.143.6.137_ether3&xmtype=options";
//                         daily = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&page=graph&xgtype=d&xgstyle=x2&if=203.143.6.137_ether3&xmtype=options";
//                         weekly = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&page=graph&xgtype=w&xgstyle=x2&if=203.143.6.137_ether3&xmtype=options";
//                         monthly = "http://203.143.20.173/cgi-bin/routers2.cgi?rtr="+msg+"&bars=Cami&page=graph&xgtype=m&xgstyle=x2&if=203.143.6.137_ether3&xmtype=options";
//
//                        $('#graph_frame_div').html('<h3>Hourly Graph</h3><iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="'+hourly+'"></iframe>' +
//                            '<h3>Daily Graph</h3><iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="'+daily+'"></iframe>' +
//                            '<h3>Weekly Graph</h3><iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="'+weekly+'"></iframe>' +
//                            '<h3>Monthly Graph</h3><iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="'+monthly+'"></iframe>');
//                    }
//
//                }
//                else{
//
//                    $('#graph_frame_div').html('<h3>No Graphs is available for the selected hotel</h3>');
//                }
//            }
//
//        });
//
//
//    }
//    else{
//        alert("please select a hotel");
//    }
//}





function displayAllWifiUsageForGivenHotel(hotelId){

    if(hotelId!=""){


        $.ajax({
            type: "POST",
            url: "../controllers/package-controller.php",

            data: "hotel_id="+hotelId+"&action=get_hotel_graph_code",
            success: function(msg){

                if(jQuery.trim(msg)!=""){

                    var hourly = "";
                    var daily = "";
                    var weekly = "";
                    var monthly = "";


                    var hotel_data_arr =   msg.split("######");

                    var hotel_graph_code = hotel_data_arr[0];

                    //alert("interface Length ["+(hotel_data_arr[1].split("***")).length);

                    var FrameText = '';
                    var graphName = "";
                    var graphTypeCode = "";

                    for(var numOfGraphs=0;numOfGraphs<4;numOfGraphs++){

                        if(numOfGraphs == 0){
                            graphName = "Hourly Graph";
                            graphTypeCode="6";
                        }
                        else if(numOfGraphs == 1){
                            graphName = "Daily Graph";
                            graphTypeCode = "d";
                        }
                        else if(numOfGraphs == 2){
                            graphName = "Weekly Graph";
                            graphTypeCode = "w";
                        }
                        else if(numOfGraphs == 3){
                            graphName = "Monthly Graph";
                            graphTypeCode = "m"
                        }

                        var Arr = hotel_data_arr[1].split("***");

                        FrameText = FrameText +'<h3>'+graphName+'</h3>';

                        for(var index=0; index<Arr.length; index++){

                            FrameText = FrameText+'<iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="http://203.143.20.173/cgi-bin/routers2.cgi?rtr='+hotel_graph_code+'&bars=Cami&page=graph&xgtype='+graphTypeCode+'&xgstyle=x3&if='+Arr[index]+'&xmtype=options"></iframe>';
//                     FrameText = FrameText+'<iframe id="graph_frame" name="graph_frame" width="900px;" height="500px;" src="http://203.143.20.173/cgi-bin/routers2.cgi?rtr=chaayaTranz.cfg&bars=Cami&page=graph&xgtype=m&xgstyle=x3&if=198.18.1.180_ether2&xmtype=options"></iframe>';

                        }
                    }

                    $('#graph_frame_div').html(FrameText);


                }
                else{

                    $('#graph_frame_div').html('<h3>No Graphs is available for the selected hotel</h3>');
                }
            }

        });


    }
    else{
        alert("please select a hotel");
    }
}





function hideDiv(){

    //alert('alert');

//    $('#main_context_box').hide();
    // $('#main_frame').hide();
    document.getElementById('main_frame').style.display = 'none';

}



function visibleDiv(){


    // $('#main_frame').show();
    document.getElementById('main_frame').style.display = 'block';

}






function loadSelectedUserPrivileges(userID){


    // alert(userID);

    $.ajax({
        type: "POST",
        url: "../controllers/privilege-controller.php",

        data: "user_id="+userID+"&action=load_user_privileges",
        success: function(msg){

            $('#assigned_user_privileges').html(msg);
        }

    });


}//loadSelectedUserPrivileges




function changePrivileges(privilege_id){

    var user_id = $('#users_lst').val();


    $.ajax({
        type: "POST",
        url: "../controllers/privilege-controller.php",
        data: "user_id="+user_id+"&privilege_id="+privilege_id+"&action=change_user_privileges",
        success: function(msg){

            if(msg=='success_assigned'){
                $('#user_msg').html('<span class="input-notification success png_bg">Privilege was Successfully Assigned</span>');
            }
            else if(msg=='success_removed'){
                $('#user_msg').html('<span class="input-notification success png_bg">Privilege was Successfully Removed</span>');
            }

        }

    });

}







function change_admin_user_passwords(){

    var password  = $('#user_new_password').val();
    var password_confirmation  = $('#user_confirm_password').val();

    if(jQuery.trim(password_confirmation)=="" && jQuery.trim(password)==""){

        $('#user_pw_change_msg').html('<div class="input-notification error png_bg"> Password and  Confirmation is required</div>');

    }
    else if(jQuery.trim(password)==""){

        $('#user_pw_change_msg').html('<div class="input-notification error png_bg"> Password is required</div>');

    }
    else if(jQuery.trim(password_confirmation)==""){

        $('#user_pw_change_msg').html('<div class="input-notification error png_bg"> Password Confirmation is required</div>');

    }
    else if(password!=password_confirmation){

        $('#user_pw_change_msg').html('<div class="input-notification error png_bg"> Password does not match with the confirmation</div>');
    }
    else{

        var user_id  = $('#user_id').val();

        $.ajax({
            type: "POST",
            url: "../controllers/user-controller.php",
            data: "user_id="+user_id+"&password="+password+"&action=change_admin_user_password",
            success: function(msg){

                if(msg=='success'){
                    $('#user_pw_change_msg').html('<span class="input-notification success png_bg">Password was successfully changed</span>');
                }
                else if(msg=='error'){
                    $('#user_pw_change_msg').html('<span class="input-notification error png_bg">Please try again later</span>');
                }

            }

        });

    }

}





