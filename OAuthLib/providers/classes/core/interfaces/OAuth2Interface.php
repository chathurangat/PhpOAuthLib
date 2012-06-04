<?php
/**
 *  User      : Chathuranga Tennkoon
 *  Blog       : http://chathurangat.blogspot.com
 *  GitHub   : https://github.com/chathurangat
 *  Email     : chathuranga.t@gmail.com
 *  Location : Colombo, Sri Lanka
 *  IDE         :  JetBrains PhpStorm
 */
interface  OAuth2Interface
{

    public  function getAuthorizationUrl();

    public  function getAccessToken();

    public  function getRequestToken();

    public function getProtectedResource();

    public function retrieveRequestedResourceData();

}

?>

