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

echo " Retrieving Data from Google <br/>";

$providerInstance = new OAuth2Impl();
$providerInstance = OAuthProviderFactory::getOAuthProvider(OAuthProvider::GOOGLE);

$requestToken = $providerInstance->getRequestToken();

echo "Request Token [".$requestToken."]<br/>";

$accessTokenResponse  =  $providerInstance->getAccessToken();

echo "Access Token Response <br/>";

//print_r($accessTokenResponse);

if(($accessTokenResponse['response_status']=='success') && (array_key_exists('access_token',$accessTokenResponse))){

    echo "<br/>Access Token Retrieved [".$accessTokenResponse['access_token'];

    //retrieving the user profile from google
    echo "<br/>retrieiving user profile data</br>";
    $user_profile = $providerInstance->getProtectedResource();

    print_r($user_profile);

}
else if(($accessTokenResponse['response_status']=='error')){

    $errorCode = $accessTokenResponse['error_code'];

    $error = OAuthErrorHandler::getErrorDescription($errorCode);

    echo "<br/> error is [".$error."]";


}


?>