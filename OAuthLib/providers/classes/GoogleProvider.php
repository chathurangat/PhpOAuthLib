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

    protected  $requestTokenUrl = "https://accounts.google.com/o/oauth2/auth";
    protected  $accessTokenUrl  = "https://accounts.google.com/o/oauth2/token";
    protected  $scopeUrl = "https://www.googleapis.com/auth/userinfo.profile";
    protected  $protectedResourceUrl =  "https://www.googleapis.com/oauth2/v1/userinfo";


    function __construct(OAuthClientConfig $config)
    {
        $this->clientAppConfig = $config;
    }

    public function getAuthorizationUrl()
    {
        $parameter_array = array('response_type'=>'code',
            'client_id'=>$this->clientAppConfig->getApplicationId(),
            'redirect_uri'=>$this->clientAppConfig->getRedirectUrl(),
            'scope'=>$this->scopeUrl,
            'state'=> $this->clientAppConfig->getState()
        );

        $http_query_string =http_build_query($parameter_array);

        $this->authorizeUrl = $this->requestTokenUrl."?" .$http_query_string;

        $_SESSION["GoogleProvider"] = OAuthUtil::setUpInstance($this);

        return $this->authorizeUrl;
    }


    public function getAccessToken()
    {

        if(($this->requestTokenResponse["state"]==$this->clientAppConfig->getState()) && ($this->requestTokenResponse["state"]!=NULL) ){

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

            if(!empty($response)){
                $responseParameterArray =(array) json_decode($response);

                //extracting the access token if it is available
                if(array_key_exists("access_token",$responseParameterArray)){

//                    $this->accessToken  = $responseParameterArray['access_token'];

                    $this->accessTokenResponse['response_status'] = "success";
                    $this->accessTokenResponse['access_token'] = $responseParameterArray['access_token'];

                }
                else if(array_key_exists("error",$responseParameterArray) ){

                    $this->accessTokenResponse['response_status'] = "error";
                    $this->accessTokenResponse['error_code'] = $responseParameterArray['error'];
                }
            }
            else{

                //if there is no response from the server
                $this->accessTokenResponse['response_status'] = "error";
                $this->accessTokenResponse['error_code'] = 'no_response';

            }

        }
        else{
            //if state is invalid
            $this->accessTokenResponse['response_status'] = "error";
            $this->accessTokenResponse['error_code'] = 'state_invalid';

        }

        return  $this->accessTokenResponse;

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
        //do all above operations in a single method

        $this->getRequestToken();
        $this->getAccessToken();

        if(array_key_exists('access_token',$this->accessTokenResponse)){

            $this->protectedResourceResponse = $this->getProtectedResource();

        }//array_key_exists
        else if(array_key_exists('error_code',$this->accessTokenResponse)){

            $this->protectedResourceResponse =  $this->accessTokenResponse;

        }

        return $this->protectedResourceResponse;

/*
        $this->getRequestToken();
        $this->getAccessToken();
        $this->getProtectedResource();

        return $this->protectedResourceResponse;
*/
    }
}
