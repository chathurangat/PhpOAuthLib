<?php
/**
 *  User      : Chathuranga Tennkoon
 *  Blog       : http://chathurangat.blogspot.com
 *  GitHub   : https://github.com/chathurangat
 *  Email     : chathuranga.t@gmail.com
 *  Location : Colombo, Sri Lanka
 *  IDE         :  JetBrains PhpStorm.
 */

echo "index page<br/>";


include "OAuthLib/providers/OAuthProviderFactory.php";


//google example
$config = new OAuthClientConfig();

$config->setApplicationId("669970197155.apps.googleusercontent.com");
$config->setApplicationSecret("jFnlsgVNBNkthpQ-gjOSnDiv");
$config->setRedirectUrl("http://localhost/PhpOAuthLib/google.php");
$config->setState("chathuranga");
$config->setOAuthProvider(OAuthProvider::GOOGLE);


$providerInstance = OAuthProviderFactory::getOAuthProviderInstance($config);


if($providerInstance!=NULL){

    echo "Authorize URL [".$providerInstance->getAuthorizationUrl()."]";
}


?>
