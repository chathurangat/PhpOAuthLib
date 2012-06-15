<?php
/**
 * Created by
 * Author : Chathuranga Tennakoon
 * Email  : chathuranga.t@gmail.com
 * Blog   : http://chathurangat.blogspot.com
 * Date   : 6/12/12
 * Time   : 2:52 PM
 * IDE    : JetBrains PhpStorm
 *
 */

require_once "core/OAuth2Impl.php";

class BitlyProvider extends OAuth2Impl
{

    protected  $requestTokenUrl = "https://bitly.com/oauth/authorize";
    protected  $accessTokenUrl  = "https://bitly.com/oauth/access_token";
    protected  $protectedResourceUrl =  "";


    function __construct(OAuthClientConfig $config)
    {
        $this->clientAppConfig = $config;
    }


    public function getAuthorizationUrl()
    {

        $parameter_array = array('response_type'=>'code',
            'client_id'=>$this->clientAppConfig->getApplicationId(),
            'redirect_uri'=>$this->clientAppConfig->getRedirectUrl(),
            'state'=>$this->clientAppConfig->getState()
        );

        $http_query_string =http_build_query($parameter_array);

        $this->authorizeUrl = $this->requestTokenUrl."?" .$http_query_string;

        $_SESSION["BitlyProvider"] = OAuthUtil::setUpInstance($this);

        return $this->authorizeUrl;
    }




    public function getAccessToken()
    {
        //TODO:Implementation should goes here
    }





}
