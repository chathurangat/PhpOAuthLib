<?php
/**
 * Created by
 * Author : Chathuranga Tennakoon
 * Email  : chathuranga.t@gmail.com
 * Blog   : http://chathurangat.blogspot.com
 * Date   : 6/7/12
 * Time   : 2:19 PM
 * IDE    : JetBrains PhpStorm
 *
 */

require_once "../../providers/OAuthProviderFactory.php";

echo "Windows Live Example <br/>";


if(!isset($_GET['code'])){

    $config  = new OAuthClientConfig();

    $config->setApplicationId("00000000440C613B");
    $config->setApplicationSecret("qW0wxzA355gSLPIY0KaZ-2DJPbEt05Fe");
    $config->setRedirectUrl("http://chathuranga.netai.net/PhpOAuthLib/OAuthLib/examples/WindowsLive/WindowsLiveExample.php");
    $config->setState();
    $config->setScope("wl.signin");//wl.basic , wl.photos
    $config->setOAuthProvider(OAuthProvider::WindowsLive);

    $oauthProvider =   $providerInstance = OAuthProviderFactory::getOAuthProviderInstance($config);

    $url = $oauthProvider->getAuthorizationUrl();


    echo "<a href=\"".$url."\"> Login with WindowsLive </a><br/><br/>";

}

/*
if(isset($_GET['code']) || isset($_GET['error'])){

    echo "----Request Token Response-------------<br/><br/>";

    $oauthProvider = OAuthProviderFactory::getOAuthProvider(OAuthProvider::WindowsLive);

    $requestTokenResponse = $oauthProvider->getRequestToken();

    print_r($requestTokenResponse);

    echo "-------------Access Token Response <br/><br/>";

    $accessTokenResponse = $oauthProvider->getAccessToken();

    echo "<br/><br/>Access Token ----[".$accessTokenResponse['access_token']."]<br/><br/><br/>";

    echo "Protected Resource <br/><br/>";

    $protectedResourceResponse = $oauthProvider->getProtectedResource();

    print_r($protectedResourceResponse);

}
*/




if(isset($_GET["code"]) || isset($_GET["error"])){

    echo " Retrieving Data from WindowsLive <br/>";

    $providerInstance = new OAuth2Impl();

    $providerInstance = OAuthProviderFactory::getOAuthProvider(OAuthProvider::WindowsLive);

    $protectedResourceResponse  =  $providerInstance->retrieveRequestedResourceData();

    if($protectedResourceResponse!=NULL){

        if(($protectedResourceResponse['response_status']=='success')){

            //retrieving the user profile from WindowsLive
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
