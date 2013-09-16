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

session_start();

    //creating new OAuth Client configuration Object
    $config = new OAuthClientConfig();

    //client Id received when creating the twitter application
    $config->setApplicationId("6ey7OCAzuw6azoc3ZArw");

    //client secret received when creating twitter application
    $config->setApplicationSecret("agg0Ql6EqcD5rX2a7pz4PFHJJTiscCftwatxfUb30");

    //the redirect URL given during application registration
    $config->setRedirectUrl("http://fosshub.org/PhpOAuthLib/OAuthLib/examples/Twitter/TwitterExample.php");

    //your desired OAuth Provider
    $config->setOAuthProvider(OAuthProvider::Twitter);


    //retrieving the Twitter OAuth Provider instance by giving the configuration object
    $providerInstance = OAuthProviderFactory::getOAuthProviderInstance($config);


    if($providerInstance!=NULL & !(isset($_GET['oauth_token']) && isset($_GET['oauth_verifier']))){

        $requestTokenResponse = $providerInstance->getRequestTokenResponse();

        $_SESSION["twitter_request_token_response"] = $requestTokenResponse;

        echo "<a href=\"".$providerInstance->getAuthorizationUrl($requestTokenResponse)."\"> Login with Twitter </a><br/><br/>";
    }


   if(isset($_GET['oauth_token']) && isset($_GET['oauth_verifier'])){
       echo "Requesting Access Token for the Twitter network <br/>";
       $providerInstance->getAccessToken();
   }

?>
