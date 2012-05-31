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
    private  $requestTokenUrl = "https://accounts.google.com/o/oauth2/auth";
    private  $accessTokenUrl = "https://accounts.google.com/o/oauth2/token";

    function __construct(OAuthClientConfig $config)
    {
        $this->clientAppConfig = $config;
    }


    public function getAuthorizationUrl()
    {

        $parameter_array = array('response_type'=>'code',
            'client_id'=>$this->clientAppConfig->getApplicationId(),
            'redirect_uri'=>$this->clientAppConfig->getRedirectUrl(),
            'scope'=>'https://www.googleapis.com/auth/userinfo.profile'
        );

        $http_query_string =http_build_query($parameter_array);

        $this->authorizeUrl = $this->requestTokenUrl."?" .$http_query_string;

        $_SESSION["GoogleProvider"] = OAuthUtil::setUpInstance($this);

        return $this->authorizeUrl;
    }


    public function getRequestToken()
    {
        $requestMethod =  $_SERVER['REQUEST_METHOD'];

        switch($requestMethod){

            case 'GET':

                if(isset($_GET['code'])){
                    $this->requestToken  = $_GET['code'];
                }
                break;

            case 'POST':

                if(isset($_POST['code'])){
                    $this->requestToken  = $_POST['code'];
                }
                break;

            default:
                $this->requestToken = NULL;
                break;

        }

        return $this->requestToken;
    }



    public function getAccessToken()
    {

        //implementation should goes here

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
