<?php
/**
 * Created by
 * Author : Chathuranga Tennakoon
 * Email  : chathuranga.t@gmail.com
 * Blog   : http://chathurangat.blogspot.com
 * Date   : 6/12/12
 * Time   : 2:31 PM
 * IDE    : JetBrains PhpStorm
 *
 */

require_once "../../../OAuthLib/providers/OAuthProviderFactory.php";



if(!isset($_GET['code'])){

    echo "BitlyExample <br/>";


    $config = new OAuthClientConfig();

    $config->setApplicationId("d5a771ca4716ebbe4fb28dab4471cf482392df8b");

    $config->setApplicationSecret("4bb05f1b9b4bb989f574d0163bb0adf2862f12be");

    $config->setRedirectUrl("http://localhost/PhpOAuthLib/OAuthLib/examples/Bitly/BitlyExample.php");

    $config->setOAuthProvider(OAuthProvider::BITLY);

    $config->setState();


    $providerInstance = OAuthProviderFactory::getOAuthProviderInstance($config);


    if($providerInstance!=NULL){

        echo "<a href=\"".$providerInstance->getAuthorizationUrl()."\"> Login with Bitly </a><br/><br/>";

        echo "Authorize URL [".$providerInstance->getAuthorizationUrl()."] <br/><br/>";
    }

}


if(isset($_GET['code'])){

    echo "Retrieving data from Bitly<br/>";

    $providerInstance = new OAuth2Impl();
    $providerInstance = OAuthProviderFactory::getOAuthProvider(OAuthProvider::BITLY);

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
