
<?php
/**
 *  User      : Chathuranga Tennkoon
 *  Blog       : http://chathurangat.blogspot.com
 *  GitHub   : https://github.com/chathurangat
 *  Email     : chathuranga.t@gmail.com
 *  Location : Colombo, Sri Lanka
 *  IDE         :  JetBrains PhpStorm.
 */

include "OAuthLib/providers/OAuthProviderFactory.php";


$config = new OAuthClientConfig();

$config->setApplicationId("118109904961659");
$config->setApplicationSecret("89fb5d6641d5789526e1d2b50cf6c496");
$config->setRedirectUrl("http://localhost/OAuth/facebook.php");
$config->setState("chathuranga");
$config->setOAuthProvider(OAuthProvider::FACEBOOK);


$providerInstance = OAuthProviderFactory::getOAuthProviderInstance($config);


print_r($providerInstance);


?>