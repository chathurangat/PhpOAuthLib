<?php
/**
 * Created by
 * Author : Chathuranga Tennakoon
 * Email  : chathuranga.t@gmail.com
 * Blog   : http://chathurangat.blogspot.com
 * Date   : 6/6/12
 * Time   : 4:13 PM
 * IDE    : JetBrains PhpStorm
 *
 */

require_once "core/OAuth2Impl.php";

class FoursquareProvider extends OAuth2Impl
{

    protected  $requestTokenUrl = "https://foursquare.com/oauth2/authenticate";
    protected  $accessTokenUrl  = "https://foursquare.com/oauth2/access_token";
    protected  $protectedResourceUrl =  "https://api.foursquare.com/v2/users/self";


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

        $_SESSION["FoursquareProvider"] = OAuthUtil::setUpInstance($this);

        return $this->authorizeUrl;
    }


    public function getAccessToken()
    {
        //if request token is available
        if($this->requestTokenResponse["response_status"]=='success'){

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
                //if response is not empty
                $responseParameterArray = (array) json_decode($response);

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

            $this->accessTokenResponse = $this->requestTokenResponse;
        }

        return $this->accessTokenResponse;

    }



    public function getProtectedResource()
    {
        if($this->accessTokenResponse["response_status"]=='success'){

            $requestHeaderData  = array('oauth_token'=>$this->accessTokenResponse['access_token'],'v'=>time());

            $buildUrl  = $this->protectedResourceUrl."?" .http_build_query($requestHeaderData);

            $ch2 = curl_init();

            curl_setopt($ch2, CURLOPT_URL, $buildUrl);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

            $responseJson = curl_exec($ch2);
            curl_close($ch2);

            $this->protectedResourceResponse = json_decode($responseJson,true);
            $this->protectedResourceResponse ['response_status'] = 'success';

        }
        else{
            //if access token is not available
            $this->protectedResourceResponse = $this->accessTokenResponse;

        }

        return $this->protectedResourceResponse;
    }



}
