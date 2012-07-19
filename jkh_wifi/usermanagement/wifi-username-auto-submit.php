<html>
<head>

</head>
<body onload="document.forms.username_form.submit();">

<form name="username_form" method="post" action="change-wifi-user-password.php">

    <input type="hidden" id="username" name="username" value="<?php echo $_POST['userid']; ?>"/>
    <input type="hidden" name="mac" id="mac" value="<?php echo $_POST['mac']; ?>">
    <input type="hidden" name="ip" id="ip" value="<?php echo $_POST['ip']; ?>">
    <input type="hidden" name="userid" id="userid" value="<?php echo $_POST['userid']; ?>">
    <input type="hidden" name="link-orig" id="link-orig" value="<?php echo $_POST['link-orig']; ?>">
    <input type="hidden" name="link-status" id="link-status" value="<?php echo $_POST['link-status']; ?>">
    <input type="hidden" name="host-ip" id="host-ip" value="<?php echo $_POST['host-ip']; ?>">
    <input type="hidden" name="hostname" id="hostname" value="<?php echo $_POST['hostname']; ?>">
    <input type="hidden" name="interface-name" i="interface-name" value="<?php echo $_POST['interface-name']; ?>">
    <input type="hidden" name="link-logout" id="link-logout" value="<?php echo $_POST['link-logout']; ?>">


</form>
</body>
</html>