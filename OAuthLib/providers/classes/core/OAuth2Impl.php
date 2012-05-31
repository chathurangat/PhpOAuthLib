<?php
/**
 *  User      : Chathuranga Tennkoon
 *  Blog       : http://chathurangat.blogspot.com
 *  GitHub   : https://github.com/chathurangat
 *  Email     : chathuranga.t@gmail.com
 *  Location : Colombo, Sri Lanka
 *  IDE         :  JetBrains PhpStorm.
 */

if(session_id()==""){
    session_start();
}

require_once   "interfaces/OAuth2Interface.php";
require_once   "Util/OAuthUtil.php";

class OAuth2Impl implements OAuth2Interface
{

    protected  $authorizeUrl;
    protected  $accessToken;
    protected  $requestToken;
    protected  $requestedResource;


    public  function getAuthorizationUrl()
    {
        return $this->authorizeUrl;
    }

    public function getAccessToken()
    {
        return  $this->accessToken;
    }

    public function getRequestToken()
    {
        return $this->requestToken;
    }

    public function getProtectedResource()
    {
        return $this->requestedResource;
    }


    public function retrieveRequestedResourceData()
    {
        // TODO: Implement getRequestedResourceData() method.
    }

}


?>
