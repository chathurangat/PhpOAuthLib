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
    public $clientAppConfig;
    protected $authorizeUrl;
    protected $requestTokenUrl;
    protected $accessTokenUrl;
    protected $protectedResourceUrl;
    protected $accessTokenResponse = array();
    protected $protectedResourceResponse = array();
    protected $requestTokenResponse = array();

    public function getAuthorizationUrl()
    {
        return $this->authorizeUrl;
    }

    public function getAccessToken()
    {
        return  $this->accessTokenResponse;
    }

    public function getRequestToken()
    {
        $requestMethod =  $_SERVER['REQUEST_METHOD'];
        switch($requestMethod){
            case 'GET':
                if(isset($_GET['code'])){
                    $this->requestTokenResponse['request_token'] = $_GET["code"];

                    if(isset($_GET["state"])){
                        $this->requestTokenResponse['state'] = $_GET["state"];
                    }
                    $this->requestTokenResponse['response_status'] = 'success';
                }
                else if(isset($_GET['error'])){
                    $this->requestTokenResponse['error_code'] = $_GET["error"];
                    $this->requestTokenResponse['response_status'] = 'error';
                }
                break;

            case 'POST':
                if(isset($_POST['code'])){
                    $this->requestTokenResponse['request_token'] = $_POST["code"];
                    if(isset($_POST["state"])){
                        $this->requestTokenResponse['state'] = $_POST["state"];
                    }
                    $this->requestTokenResponse['response_status'] = 'success';
                }
                else if(isset($_POST['error'])){
                    $this->requestTokenResponse['error_code'] = $_POST["error"];
                    $this->requestTokenResponse['response_status'] = 'error';
                }
                break;

            default:
                $this->requestTokenResponse['request_token'] = NULL;
                $this->requestTokenResponse['state'] = NULL;
                $this->requestTokenResponse['response_status'] = 'error';
                $this->requestTokenResponse['error_code'] = 'invalid_request_method';
                break;
        }
        return $this->requestTokenResponse;
    }

    public function getProtectedResource()
    {
        return $this->protectedResourceResponse;
    }

    public function retrieveRequestedResourceData()
    {
        //do all above operations in a single method
        $this->getRequestToken();
        $this->getAccessToken();
        $this->getProtectedResource();
        return $this->protectedResourceResponse;
    }
}
?>
