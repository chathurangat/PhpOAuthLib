<?php
/**
 *  User      : Chathuranga Tennkoon
 *  Blog       : http://chathurangat.blogspot.com
 *  GitHub   : https://github.com/chathurangat
 *  Email     : chathuranga.t@gmail.com
 *  Location : Colombo, Sri Lanka
 *  IDE         :  JetBrains PhpStorm.
 */


require_once "../../../OAuthLib/providers/OAuthProviderFactory.php";

if(!isset($_GET['state'])){

//creating new OAuth Client configuration Object
$config = new OAuthClientConfig();

//client Id received when creating the google application
$config->setApplicationId("669970197155.apps.googleusercontent.com");

//client secret received when creating google application
$config->setApplicationSecret("jFnlsgVNBNkthpQ-gjOSnDiv");

//the redirect URL given during application registration
$config->setRedirectUrl("http://localhost/PhpOAuthLib/OAuthLib/examples/Google/GoogleExample.php");

//your desired OAuth Provider
$config->setOAuthProvider(OAuthProvider::GOOGLE);

//setting up the state
$config->setState();

//retrieving the Google OAuth Provider instance by giving the configuration object
$providerInstance = OAuthProviderFactory::getOAuthProviderInstance($config);


if($providerInstance!=NULL){

    echo "<a href=\"".$providerInstance->getAuthorizationUrl()."\"> Login with Google </a><br/><br/>";

    echo "Authorize URL [".$providerInstance->getAuthorizationUrl()."] <br/><br/>";
}

}


if(isset($_GET["state"])){

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

}

?>
