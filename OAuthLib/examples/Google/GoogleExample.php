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

    //setting up the scope
    $config->setScope("https://www.googleapis.com/auth/userinfo.profile");

    //retrieving the Google OAuth Provider instance by giving the configuration object
    $providerInstance = OAuthProviderFactory::getOAuthProviderInstance($config);


    if($providerInstance!=NULL){

        echo "<a href=\"".$providerInstance->getAuthorizationUrl()."\"> Login with Google </a><br/><br/>";

        echo "Authorize URL [".$providerInstance->getAuthorizationUrl()."] <br/><br/>";
    }

}


if(isset($_GET["code"]) || isset($_GET["error"])){

    echo " Retrieving Data from Google <br/>";

    $providerInstance = new OAuth2Impl();
    $providerInstance = OAuthProviderFactory::getOAuthProvider(OAuthProvider::GOOGLE);

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
