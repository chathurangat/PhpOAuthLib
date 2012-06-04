<?php
/**
 *  User      : Chathuranga Tennkoon
 *  Blog       : http://chathurangat.blogspot.com
 *  GitHub   : https://github.com/chathurangat
 *  Email     : chathuranga.t@gmail.com
 *  Location : Colombo, Sri Lanka
 *  IDE         :  JetBrains PhpStorm.
 */

/*
the intention of this  script is to describe how to generate Authorize URL for the google
*/
include "../../../OAuthLib/providers/OAuthProviderFactory.php";

//creating new OAuth Client configuration Object
$config = new OAuthClientConfig();

//client Id received when creating the google application
$config->setApplicationId("669970197155.apps.googleusercontent.com");

//client secret received when creating google application
$config->setApplicationSecret("jFnlsgVNBNkthpQ-gjOSnDiv");

//the redirect URL given during application registration
$config->setRedirectUrl("http://localhost/PhpOAuthLib/google.php");

//your desired OAuth Provider
$config->setOAuthProvider(OAuthProvider::GOOGLE);

//retrieving the Google OAuth Provider instance by giving the configuration object
$providerInstance = OAuthProviderFactory::getOAuthProviderInstance($config);


if($providerInstance!=NULL){

    echo "Authorize URL [".$providerInstance->getAuthorizationUrl()."]";
}

?>
