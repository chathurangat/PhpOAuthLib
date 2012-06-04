<?php
/**
 *  User      : Chathuranga Tennkoon
 *  Blog       : http://chathurangat.blogspot.com
 *  GitHub   : https://github.com/chathurangat
 *  Email     : chathuranga.t@gmail.com
 *  Location : Colombo, Sri Lanka
 *  IDE         :  JetBrains PhpStorm.
 */

include "core/OAuth2Impl.php";

class FacebookProvider extends OAuth2Impl
{

    protected  $requestTokenUrl = "https://www.facebook.com/dialog/oauth";
    protected  $accessTokenUrl  = "https://graph.facebook.com/oauth/access_token";
    protected  $protectedResourceUrl =  "https://graph.facebook.com/me";


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

        $_SESSION["FacebookProvider"] = OAuthUtil::setUpInstance($this);

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

                parse_str($response,$responseParameterArray);

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
            //if access token is not avaialble
            $this->protectedResourceResponse = $this->accessTokenResponse;

        }
        return $this->protectedResourceResponse;

    }


    public function retrieveRequestedResourceData()
    {
        // TODO: Implement getRequestedResourceData() method.
    }

}
