<?php
/**
 * Created by
 * Author : Chathuranga Tennakoon
 * Email  : chathuranga.t@gmail.com
 * Blog   : http://chathurangat.blogspot.com
 * Date   : 5/30/12
 * Time   : 11:34 AM
 * IDE    : JetBrains PhpStorm
 *
 */
require_once   "core/OAuth2Impl.php";

class GoogleProvider extends OAuth2Impl
{


    public  $clientAppConfig;

    function __construct(OAuthClientConfig $config)
    {
        $this->clientAppConfig = $config;
    }


    public function getAuthorizationUrl()
    {
        $requestUrl="https://accounts.google.com/o/oauth2/auth";

        $parameter_array = array('response_type'=>'code',
            'client_id'=>$this->clientAppConfig->getApplicationId(),
            'redirect_uri'=>$this->clientAppConfig->getRedirectUrl(),
            'scope'=>'https://www.googleapis.com/auth/userinfo.profile'
        );

        $http_query_string =http_build_query($parameter_array);

        $this->authorizeUrl = $requestUrl."?" .$http_query_string;

        $_SESSION["GoogleProvider"] = OAuthUtil::setUpInstance($this);

        return $this->authorizeUrl;
    }


    public function getAccessToken()
    {

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
        //do all above operations in a single method

        // TODO: Implement getRequestedResourceData() method.
    }

}
