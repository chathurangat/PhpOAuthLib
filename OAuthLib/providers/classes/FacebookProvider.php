<?php
/**
 *  User      : Chathuranga Tennkoon
 *  Blog       : http://chathurangat.blogspot.com
 *  GitHub   : https://github.com/chathurangat
 *  Email     : chathuranga.t@gmail.com
 *  Location : Colombo, Sri Lanka
 *  IDE         :  JetBrains PhpStorm.
 */

include "core/OAuth2Impl.php";

class FacebookProvider extends OAuth2Impl
{
    public  $clientAppConfig;

    function __construct(OAuthClientConfig $config)
    {
        $this->clientAppConfig = $config;
    }

    public function getAuthorizationUrl()
    {
        $this->authorizeUrl  = "https://www.facebook.com/dialog/oauth_backup?client_id="
            . $this->clientAppConfig->getApplicationId(). "&redirect_uri=" . urlencode($this->clientAppConfig->getRedirectUrl()) . "&state=".$this->clientAppConfig->getState()."";

        return $this->authorizeUrl;
    }

    public function getAccessToken()
    {
        return parent::getAccessToken();
    }

    public function getRequestToken()
    {
        return parent::getRequestToken();
    }

    public function getProtectedResource()
    {
        return parent::getProtectedResource();
    }


    public function retrieveRequestedResourceData()
    {
        // TODO: Implement getRequestedResourceData() method.
    }


}
