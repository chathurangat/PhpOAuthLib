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
    echo "BitlyExample";


    $config = new OAuthClientConfig();

    $config->setApplicationId("d5a771ca4716ebbe4fb28dab4471cf482392df8b");
    $config->setApplicationSecret("4bb05f1b9b4bb989f574d0163bb0adf2862f12be");
    $config->setRedirectUrl("http://localhost/PhpOAuthLib/OAuthLib/examples/bitly/BitlyExample.php");
    $config->setOAuthProvider(OAuthProvider::BITLY);
    $config->setState();


    $providerInstance = OAuthProviderFactory::getOAuthProviderInstance($config);


    echo "Url [".$providerInstance->getAuthorizationUrl();

}
else{


    $providerInstance = OAuthProviderFactory::getOAuthProvider(OAuthProvider::BITLY);

    echo "Access Token Response <br/>";

    $requestTokenResponse =  $providerInstance->getRequestToken();

    //print_r($requestTokenResponse);

    $accessTokenResponse = $providerInstance->getAccessToken();

   // print_r($accessTokenResponse);

    $protectedResource = $providerInstance->getProtectedResource();


    print_r($protectedResource);

}

?>
