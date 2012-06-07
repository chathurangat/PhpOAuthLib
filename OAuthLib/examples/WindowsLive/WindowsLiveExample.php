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

/*
 *
 * redirect URL http://chathuranga.000space.com/PhpOAuthLib/OAuthLib/examples/WindowsLive/WindowsLiveExample.php
 * client id 00000000440C613B
 * client secret qW0wxzA355gSLPIY0KaZ-2DJPbEt05Fe
 */


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


if(isset($_GET['code']) || isset($_GET['error'])){

    echo "----Request Token Response-------------<br/><br/>";

    $oauthProvider = OAuthProviderFactory::getOAuthProvider(OAuthProvider::WindowsLive);

    $requestTokenResponse = $oauthProvider->getRequestToken();

    print_r($requestTokenResponse);



    echo "-------------Access Token Response <br/><br/>";

    $accessTokenResponse = $oauthProvider->getAccessToken();

    echo "Access Token".$accessTokenResponse['access_token']."<br/>";


}


?>
