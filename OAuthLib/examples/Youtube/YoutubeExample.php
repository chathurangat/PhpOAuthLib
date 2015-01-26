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
    $config->setApplicationId("815947701601-n3n976gs739chgsov8g88aipvge68u1e.apps.googleusercontent.com");

    //client secret received when creating google application
    $config->setApplicationSecret("qu99bIbulkUzdEK08shzNYvq");

    //the redirect URL given during application registration
    $config->setRedirectUrl("http://localhost/PhpOAuthLib/OAuthLib/examples/Youtube/YoutubeExample.php");

    //your desired OAuth Provider
    $config->setOAuthProvider(OAuthProvider::Youtube);

    //setting up the state
    $config->setState();

    //setting up the scope
    $config->setScope("https://www.googleapis.com/auth/youtube");
//    $config->setScope("https://gdata.youtube.com/feeds/api/users/default");
//    $config->setScope("https://gdata.youtube.com");


    //retrieving the Google OAuth Provider instance by giving the configuration object
    $providerInstance = OAuthProviderFactory::getOAuthProviderInstance($config);

    if($providerInstance!=NULL){

        echo "<a href=\"".$providerInstance->getAuthorizationUrl()."\"> Login with Youtube </a><br/><br/>";

        echo "Authorize URL [".$providerInstance->getAuthorizationUrl()."] <br/><br/>";
    }

}


if(isset($_GET["code"]) || isset($_GET["error"])){

    echo " Retrieving Data from Google <br/>";

    $providerInstance = new OAuth2Impl();
    $providerInstance = OAuthProviderFactory::getOAuthProvider(OAuthProvider::Youtube);

    $protectedResourceResponse  =  $providerInstance->retrieveRequestedResourceData();

    if($protectedResourceResponse!=NULL){

        if(($protectedResourceResponse['response_status']=='success')){

            //retrieving the user profile from google
            echo "<br/>displaying  requested user data</br>";
            print_r($protectedResourceResponse);

        }
        else if($protectedResourceResponse['response_status']=='error'){

            $errorCode = $protectedResourceResponse['error_code'];

            $errorMessage = OAuthErrorHandler::getErrorDescription($errorCode);

            echo "<br/> error is [".$errorMessage."]";

        }
    }
    else{
        //if it is null
        echo "OAuth Provider Can't be retrieved at the moment";

    }

}

?>
