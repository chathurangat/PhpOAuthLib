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
            'scope'=>'user'
        );

        $http_query_string =http_build_query($parameter_array);

        $this->authorizeUrl = $this->requestTokenUrl."?" .$http_query_string;

        $_SESSION["GitHubProvider"] = OAuthUtil::setUpInstance($this);

        return $this->authorizeUrl;
    }


    public function getRequestToken()
    {
        $requestMethod =  $_SERVER['REQUEST_METHOD'];

        switch($requestMethod){

            case 'GET':

                if(isset($_GET['code'])){
                    $this->requestTokenResponse['request_token'] = $_GET["code"];
                }
                break;

            case 'POST':

                if(isset($_POST['code'])){
                    $this->requestTokenResponse['request_token'] = $_POST["code"];
                }
                break;

            default:
                $this->requestTokenResponse['request_token'] = NULL;
                break;

        }

        return $this->requestTokenResponse;
    }


    public function getAccessToken()
    {
       //if request token is available
        if(array_key_exists("request_token", $this->requestTokenResponse)){

        $requestParameterArray = array('code'=> $this->requestTokenResponse["request_token"],
            'client_id'=> $this->clientAppConfig->getApplicationId(),
            'client_secret'=> $this->clientAppConfig->getApplicationSecret(),
            'redirect_uri'=>$this->clientAppConfig->getRedirectUrl(),
            'grant_type'=> 'authorization_code'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->accessTokenUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST ,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$requestParameterArray);

        $response = curl_exec($ch);
        curl_close($ch);

        echo "Response [".$response;

            if(!empty($response)){
                //if response is not empty
                parse_str($response,$responseParameterArray);

                //extracting the access token if it is available
                if(array_key_exists("access_token",$responseParameterArray)){

                    $this->accessTokenResponse['response_status'] = "success";
                    $this->accessTokenResponse['access_token'] = $responseParameterArray['access_token'];

                }
                else if(array_key_exists("error",$responseParameterArray) ){

                    $this->accessTokenResponse['response_status'] = "error";
                    $this->accessTokenResponse['error_code'] = $responseParameterArray['error'];
                }

            }
            else{
                //if response is empty
                $this->accessTokenResponse['response_status'] = "error";
                $this->accessTokenResponse['error_code'] = 'no_response';
            }

        }
        else{
            //if request token does not exists
            $this->accessTokenResponse['response_status'] = "error";
            $this->accessTokenResponse['error_code'] = 'access_token_missing';

        }

        return $this->accessTokenResponse;

    }



    public function getProtectedResource()
    {
        if(array_key_exists('access_token',$this->accessTokenResponse)){

            $requestHeaderData  = array('access_token'=>$this->accessTokenResponse['access_token']);

            $buildUrl  = $this->protectedResourceUrl."?" .http_build_query($requestHeaderData);

            $ch2 = curl_init();

            curl_setopt($ch2, CURLOPT_URL, $buildUrl);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

            $responseJson = curl_exec($ch2);
            curl_close($ch2);

            echo "-----------------".$responseJson;

            $this->protectedResourceResponse = (array)json_decode($responseJson);
            $this->protectedResourceResponse ['response_status'] = 'success';

        }
        else{
            //if access token is not available
            $this->protectedResourceResponse = $this->accessTokenResponse;

        }
        return $this->protectedResourceResponse;
    }


    public function retrieveRequestedResourceData()
    {
        parent::retrieveRequestedResourceData();
    }


}
