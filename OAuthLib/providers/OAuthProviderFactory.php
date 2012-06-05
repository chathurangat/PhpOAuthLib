<?php
/**
 *  User      : Chathuranga Tennkoon
 *  Blog       : http://chathurangat.blogspot.com
 *  GitHub   : https://github.com/chathurangat
 *  Email     : chathuranga.t@gmail.com
 *  Location : Colombo, Sri Lanka
 *  IDE         :  JetBrains PhpStorm.
 */
require_once  "classes/config/OAuthClientConfig.php";
require_once  "classes/config/OAuthProvider.php";
require_once  "classes/error/OAuthErrorHandler.php";
require_once  "classes/FacebookProvider.php";
require_once  "classes/GoogleProvider.php";
require_once  "classes/GitHubProvider.php";

if(session_id()==""){
    session_start();
}

class OAuthProviderFactory
{

    static function getOAuthProviderInstance(OAuthClientConfig $config){

        //getting the OAuth Provider
        $provider = $config->getOAuthProvider();

        switch($provider){

            case OAuthProvider::FACEBOOK :
                return new FacebookProvider($config);
                break;

            case OAuthProvider::GOOGLE :
                return new GoogleProvider($config);
                break;

            case OAuthProvider::GitHub :
                return new GitHubProvider($config);
                break;

            default:
                echo "Invalid OAuth Provider";
                return NULL;
                break;
        }

    }



    static function getOAuthProvider($provider){

        //getting the stored provider instance from the session

        $alteredProviderInstance = NULL;
        $alteredProviderInstance = $_SESSION["GoogleProvider"];


        switch($provider){

            case OAuthProvider::FACEBOOK :
                $alteredProviderInstance = $_SESSION["FacebookProvider"];
                break;

            case OAuthProvider::GOOGLE :
                $alteredProviderInstance = $_SESSION["GoogleProvider"];
                break;

            case OAuthProvider::GitHub :
                $alteredProviderInstance = $_SESSION["GitHubProvider"];
                break;

            default:
                echo "Invalid OAuth Provider";
                break;
        }

        return OAuthUtil::getOriginalInstance($alteredProviderInstance);

    }

}
?>