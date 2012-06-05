<?php
/**
 * Created by
 * Author : Chathuranga Tennakoon
 * Email  : chathuranga.t@gmail.com
 * Blog   : http://chathurangat.blogspot.com
 * Date   : 6/5/12
 * Time   : 11:00 AM
 * IDE    : JetBrains PhpStorm
 *
 */


echo "GitHub example <br/>";

include "../../../OAuthLib/providers/OAuthProviderFactory.php";

if(!isset($_GET['code'])){

    //creating new OAuth Client configuration Object
    $config = new OAuthClientConfig();

    //client Id received when creating the GitHub  application
    $config->setApplicationId("a8630b625eac176e4303");

    //client secret received when creating GitHub  application
    $config->setApplicationSecret("fae9aa90c1ca9736e447b2707fe29ecc872710bd");

    //the redirect URL given during application registration
    $config->setRedirectUrl("http://localhost/PhpOAuthLib/OAuthLib/examples/GitHub/GitHubExample.php");

    //your desired OAuth Provider
    $config->setOAuthProvider(OAuthProvider::GitHub);

    //setup state
    $config->setState();

    //retrieving the GitHub OAuth Provider instance by giving the configuration object
    $providerInstance = OAuthProviderFactory::getOAuthProviderInstance($config);


    if($providerInstance!=NULL){

        echo "<a href=\"".$providerInstance->getAuthorizationUrl()."\"> Login with GitHub </a><br/><br/>";
        echo "Authorize URL [".$providerInstance->getAuthorizationUrl()."]<br/><br/>";
    }

}

//receiving the response from the GitHub server
if(isset($_GET["code"])){


    $providerInstance = OAuthProviderFactory::getOAuthProvider(OAuthProvider::GitHub);

    $requestTokenResponse  = $providerInstance->getRequestToken();

    echo "Request token is [".$requestTokenResponse['request_token']."]<br/><br/>";

    $accessTokenResponse = $providerInstance->getAccessToken();

    echo "Acess Token Response <br/><br/>";

    print_r($accessTokenResponse);


    echo "Requested GitHub data <br/><br/>";

    $protectedResource = $providerInstance->getProtectedResource();

print_r($protectedResource);

}



?>
