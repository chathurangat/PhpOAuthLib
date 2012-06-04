<?php
/**
 *  User      : Chathuranga Tennkoon
 *  Blog       : http://chathurangat.blogspot.com
 *  GitHub   : https://github.com/chathurangat
 *  Email     : chathuranga.t@gmail.com
 *  Location : Colombo, Sri Lanka
 *  IDE         :  JetBrains PhpStorm.
 */


echo "Facebook example <br/>";

include "../../../OAuthLib/providers/OAuthProviderFactory.php";

if(!isset($_GET['state'])){

//creating new OAuth Client configuration Object
    $config = new OAuthClientConfig();

//client Id received when creating the facebook  application
    $config->setApplicationId("429200197112086");

//client secret received when creating facebook  application
    $config->setApplicationSecret("9c27359552c74fa273e9085d47a72881");

//the redirect URL given during application registration
    $config->setRedirectUrl("http://localhost/PhpOAuthLib/OAuthLib/examples/Facebook/FacebookExample.php");

//your desired OAuth Provider
    $config->setOAuthProvider(OAuthProvider::FACEBOOK);

    //setup state
    $config->setState();

//retrieving the Facebook OAuth Provider instance by giving the configuration object
    $providerInstance = OAuthProviderFactory::getOAuthProviderInstance($config);


    if($providerInstance!=NULL){

        echo "<a href=\"".$providerInstance->getAuthorizationUrl()."\"> Login with Facebook </a><br/><br/>";
        echo "Authorize URL [".$providerInstance->getAuthorizationUrl()."]<br/><br/>";
    }

}


if(isset($_GET["state"])){

    echo " Retrieving Data from Facebook <br/>";

    $providerInstance = new OAuth2Impl();
    $providerInstance = OAuthProviderFactory::getOAuthProvider(OAuthProvider::FACEBOOK);

    $requestTokenResponse = $providerInstance->getRequestToken();

print_r($requestTokenResponse);

    $accessTokenResponse  =  $providerInstance->getAccessToken();

    echo "<br/><br/>";

    print_r($accessTokenResponse);

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

        print_r($accessTokenResponse);

        $errorCode = $accessTokenResponse['error_code'];

        $error = OAuthErrorHandler::getErrorDescription($errorCode);

        echo "<br/> error is [".$error."]";

    }


}// if isset $_GET["state"]s

?>
