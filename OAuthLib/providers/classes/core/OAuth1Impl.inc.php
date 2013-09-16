<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chathuranga
 * Date: 9/11/13
 * Time: 11:54 AM
 * To change this template use File | Settings | File Templates.
 */

if(session_id()==""){
    session_start();
}

require_once   "interfaces/OAuth1Interface.inc.php";
require_once   "Util/OAuthUtil.php";
require_once "OAuth1RequestTokenResponse.inc.php";
require_once "OAuth1AccessTokenResponse.inc.php";

class OAuth1Impl implements OAuth1Interface{

    protected $authorizeUrl;
    protected $requestTokenResponse;
    protected $accessTokenResponse;

    public function getAuthorizationUrl(OAuth1RequestTokenResponse $requestTokenResponse)
    {
        // TODO: Implement getAuthorizationUrl() method.
    }

    public function getAccessToken()
    {
        // TODO: Implement getAccessToken() method.
    }

    public function getRequestTokenResponse()
    {
        // TODO: Implement getRequestTokenResponse() method.
    }

    public function getProtectedResource()
    {
        // TODO: Implement getProtectedResource() method.
    }

    public function retrieveRequestedResourceData()
    {
        // TODO: Implement retrieveRequestedResourceData() method.
    }
}

?>
