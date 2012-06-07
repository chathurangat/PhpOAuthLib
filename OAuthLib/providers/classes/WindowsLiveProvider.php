<?php
/**
 * Created by
 * Author : Chathuranga Tennakoon
 * Email  : chathuranga.t@gmail.com
 * Blog   : http://chathurangat.blogspot.com
 * Date   : 6/7/12
 * Time   : 2:38 PM
 * IDE    : JetBrains PhpStorm
 *
 */

require_once  "core/OAuth2Impl.php";

class WindowsLiveProvider extends OAuth2Impl
{


    protected  $requestTokenUrl = "https://login.live.com/oauth20_authorize.srf";
    protected  $accessTokenUrl  = "https://login.live.com/oauth20_token.srf";
    protected  $protectedResourceUrl =  "https://api.github.com/user";


    function __construct(OAuthClientConfig $config)
    {
        $this->clientAppConfig = $config;
    }


    public function getAuthorizationUrl()
    {

        $parameter_array = array('response_type'=>'code',
            'client_id'=>$this->clientAppConfig->getApplicationId(),
            'redirect_uri'=>$this->clientAppConfig->getRedirectUrl(),
            'scope'=>$this->clientAppConfig->getScope(),
            'state'=>$this->clientAppConfig->getState()
        );

        $http_query_string =http_build_query($parameter_array);

        $this->authorizeUrl = $this->requestTokenUrl."?" .$http_query_string;

        $_SESSION["WindowsLiveProvider"] = OAuthUtil::setUpInstance($this);

        return $this->authorizeUrl;
    }





    public function getAccessToken()
    {
        if($this->requestTokenResponse['response_status']=='success'){

            //if the request token is available
            if(($this->requestTokenResponse["state"]==$this->clientAppConfig->getState()) && ($this->requestTokenResponse["state"]!=NULL)){

                echo "valid state<br/>";

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
                curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($requestParameterArray));
                curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/x-www-form-urlencoded'));

                $response = curl_exec($ch);

                curl_close($ch);

                if(!empty($response)){

                   $responseParameterArray =(array) json_decode($response,true);

                   print_r($responseParameterArray);
                    //extracting the access token if it is available
                    if(array_key_exists("access_token",$responseParameterArray)){

                        $this->accessTokenResponse['access_token'] = $responseParameterArray['access_token'];
                        $this->accessTokenResponse['response_status'] = "success";

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
        }
        else{

            //if the request token is not available
            $this->accessTokenResponse = $this->requestTokenResponse;
        }

        return  $this->accessTokenResponse;
    }





}
