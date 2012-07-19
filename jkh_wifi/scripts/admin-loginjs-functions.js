// js functions

function adminlogin(){

    var action  ="act_adminlogin";

    var username = $('#username').val();
    var password = $('#password').val();

    $('#login_msg').html('<span class="input-notification error png_bg">validating...</span>');
    $.ajax({
        type: "POST",
        url: "../controllers/login-controller.php",
        data: "username="+username +"& password="+password + "& action="+action,
        success: function(msg){
            if(msg==1){
                $('#login_msg').html('<span class="input-notification success png_bg">Login successfull...</span>');
                setTimeout("location.href = '../';",100);
            }else{

                $('#login_msg').html('<span class="input-notification error png_bg">Invalid login details...</span>');
            }

        }

    });




}




function validkey(e){
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
        adminlogin();
    }
}






