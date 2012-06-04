<?php
/**
 *  User      : Chathuranga Tennkoon
 *  Blog       : http://chathurangat.blogspot.com
 *  GitHub   : https://github.com/chathurangat
 *  Email     : chathuranga.t@gmail.com
 *  Location : Colombo, Sri Lanka
 *  IDE         :  JetBrains PhpStorm.
 */

include "../../../OAuthLib/providers/OAuthProviderFactory.php";

$providerInstance = new OAuth2Impl();
$providerInstance = OAuthProviderFactory::getOAuthProvider(OAuthProvider::GOOGLE);

$responseData  = $providerInstance->retrieveRequestedResourceData();

if($responseData['response_status']=='success'){

    echo "Google User Profile successfully retrieved <br/>";

    print_r($responseData);

}
if($responseData['response_status']=='error'){

    echo "Error occured while retrieivng Google User Profile <br/>";

    $errorCode = $responseData['error_code'];

    $error = OAuthErrorHandler::getErrorDescription($errorCode);

    echo "<br/> error is [".$error."]";

}


?>
