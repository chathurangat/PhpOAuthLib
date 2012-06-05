<?php
/**
 * Created by
 * Author : Chathuranga Tennakoon
 * Email  : chathuranga.t@gmail.com
 * Blog   : http://chathurangat.blogspot.com
 * Date   : 6/5/12
 * Time   : 3:22 PM
 * IDE    : JetBrains PhpStorm
 *
 */

require_once  "core/OAuth2Impl.php";

class GitHubProvider extends OAuth2Impl
{


    protected  $requestTokenUrl = "https://github.com/login/oauth/authorize";
    protected  $accessTokenUrl  = "https://github.com/login/oauth/access_token";
    protected  $protectedResourceUrl =  "https://api.github.com/user?access_token";


    function __construct(OAuthClientConfig $config)
    {
        $this->clientAppConfig = $config;
    }


    public function getAuthorizationUrl()
    {
        $parameter_array = array('response_type'=>'code',
            'client_id'=>$this->clientAppConfig->getApplicationId(),
            'redirect_uri'=>$this->clientAppConfig->getRedirectUrl(),
            'state'=> $this->clientAppConfig->getState()
        );

        $http_query_string =http_build_query($parameter_array);

        $this->authorizeUrl = $this->requestTokenUrl."?" .$http_query_string;

        $_SESSION["GitHubProvider"] = OAuthUtil::setUpInstance($this);

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
        parent::retrieveRequestedResourceData();
    }


}
