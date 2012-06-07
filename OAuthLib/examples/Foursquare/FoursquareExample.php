<?php
/**
 * Created by
 * Author : Chathuranga Tennakoon
 * Email  : chathuranga.t@gmail.com
 * Blog   : http://chathurangat.blogspot.com
 * Date   : 6/6/12
 * Time   : 4:02 PM
 * IDE    : JetBrains PhpStorm
 *
 */


echo "Foursquare Example";


require_once "../../../OAuthLib/providers/OAuthProviderFactory.php";

if(!isset($_GET['code'])){

    //creating new OAuth Client configuration Object
    $config = new OAuthClientConfig();

    //client Id received when creating the Foursquare application
    $config->setApplicationId("AFYFC1JGQCYNGHQYJ5TNIP3UZXVHH3TS14YYSIQ1X1JELTD3");

    //client secret received when creating Foursquare application
    $config->setApplicationSecret("GTO1GIVGIQ1WSUJSXHSS45DIKVZEV25514LE550EE2RC1KIC");

    //the redirect URL given during application registration
    $config->setRedirectUrl("http://localhost/PhpOAuthLib/OAuthLib/examples/Foursquare/FoursquareExample.php");

    //your desired OAuth Provider
    $config->setOAuthProvider(OAuthProvider::Foursquare);


    //retrieving the Foursquare OAuth Provider instance by giving the configuration object
    $providerInstance = OAuthProviderFactory::getOAuthProviderInstance($config);


    if($providerInstance!=NULL){

        echo "<a href=\"".$providerInstance->getAuthorizationUrl()."\"> Login with Foursquare </a><br/><br/>";

        echo "Authorize URL [".$providerInstance->getAuthorizationUrl()."] <br/><br/>";
    }

}


if(isset($_GET["code"]) || isset($_GET["error"])){

    echo " Retrieving Data from Foursquare <br/>";

    $providerInstance = new OAuth2Impl();
    $providerInstance = OAuthProviderFactory::getOAuthProvider(OAuthProvider::Foursquare);

    $protectedResourceResponse  =  $providerInstance->retrieveRequestedResourceData();

    if($protectedResourceResponse!=NULL){

        if(($protectedResourceResponse['response_status']=='success')){

            //retrieving the user profile from Foursquare
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
