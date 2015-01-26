<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chathuranga
 * Date: 9/11/13
 * Time: 11:42 AM
 * To change this template use File | Settings | File Templates.
 */

require_once "core/OAuth1Impl.inc.php";
require_once "core/Util/oauth_helper.php";

class TwitterProvider extends OAuth1Impl{

    private $REQUEST_TOKEN_ENDPOINT = "https://api.twitter.com/oauth/request_token";
    private $AUTHORIZATION_ENDPOINT = "https://api.twitter.com/oauth/authorize";
    private $ACCESS_TOKEN_ENDPOINT = "https://api.twitter.com/oauth/access_token";
    private $PROTECTED_RESOURCE_ENDPOINT = "https://api.twitter.com/1.1/account/verify_credentials.json";

    function __construct(OAuthClientConfig $config)
    {
        $this->clientAppConfig = $config;
        $this->requestTokenResponse = new OAuth1RequestTokenResponse();
        $this->accessTokenResponse = new OAuth1AccessTokenResponse();
    }

//    /**
//     * <p>
//     *  building the twitter authorization URL.
//     * </p>
//     * @return twitter authorization URL as String
//     */
//    public function getAuthorizationUrl1()
//    {
//        $parameter_array =  array();
//        $parameter_array['oauth_version'] = '1.0';
//        $parameter_array['oauth_nonce'] = mt_rand();
//        $parameter_array['oauth_timestamp'] = time();
//        $parameter_array['oauth_consumer_key'] = $this->clientAppConfig->getApplicationId();
//        $parameter_array['oauth_callback'] = $this->clientAppConfig->getRedirectUrl();
//        $parameter_array['oauth_signature_method'] = 'HMAC-SHA1';
//        $parameter_array['oauth_signature'] = oauth_compute_hmac_sig("GET", $this->REQUEST_TOKEN_ENDPOINT, $parameter_array,$this->clientAppConfig->getApplicationSecret(), null);
//
//        $http_query_string =http_build_query($parameter_array);
//        $accessTokenUrl = $this->REQUEST_TOKEN_ENDPOINT."?" .$http_query_string;
//        $_SESSION["TwitterProvider"] = OAuthUtil::setUpInstance($this);
//
//        $response = $this->do_curl_get($accessTokenUrl);
//        if(!empty($response)){
//            echo "response is [".$response."]";
//            //parse the query string into array
//            parse_str($response,$response_arr);
//            //building the authorization url
//            $this->authorizeUrl = $this->AUTHORIZATION_ENDPOINT."?oauth_token=".$response_arr["oauth_token"];
//        }
//        return $this->authorizeUrl;
//    }


    /**
     * <p>
     *  building the twitter authorization URL based on the request token provided
     * </p>
     */
    public function getAuthorizationUrl(OAuth1RequestTokenResponse $requestTokenResponse)
    {
        echo "request token response [".$requestTokenResponse->getRequestToken()."]";

        if($requestTokenResponse!=null && $requestTokenResponse->getRequestToken()!=null){
            $this->authorizeUrl = $this->AUTHORIZATION_ENDPOINT."?oauth_token=".$requestTokenResponse->getRequestToken();
        }
        return $this->authorizeUrl;
    }



    public function getRequestTokenResponse()
    {
        $parameter_array =  array();
        $parameter_array['oauth_version'] = '1.0';
        $parameter_array['oauth_nonce'] = mt_rand();
        $parameter_array['oauth_timestamp'] = time();
        $parameter_array['oauth_consumer_key'] = $this->clientAppConfig->getApplicationId();
        $parameter_array['oauth_callback'] = $this->clientAppConfig->getRedirectUrl();
        $parameter_array['oauth_signature_method'] = 'HMAC-SHA1';
        $parameter_array['oauth_signature'] = oauth_compute_hmac_sig("GET", $this->REQUEST_TOKEN_ENDPOINT, $parameter_array,$this->clientAppConfig->getApplicationSecret(), null);

        $http_query_string =http_build_query($parameter_array);
        $accessTokenUrl = $this->REQUEST_TOKEN_ENDPOINT."?" .$http_query_string;
//        $_SESSION["TwitterProvider"] = OAuthUtil::setUpInstance($this);
        echo "Access token url [".$accessTokenUrl."]";
        $response = $this->do_curl_get($accessTokenUrl);
        echo "response [".$response."]";
        if(!empty($response)){
            echo "res[".$response."]";
            //parse the query string into array
            parse_str($response,$response_arr);
            $this->requestTokenResponse->setOauthTokenSecret($response_arr["oauth_token_secret"]);
            $this->requestTokenResponse->setRequestToken($response_arr["oauth_token"]);
        }
        return $this->requestTokenResponse;
    }

    public function getAccessToken()
    {
        echo "getting access token <br/><br/>";

        $parameter_array =  array();
        $parameter_array['oauth_version'] = '1.0';
        $parameter_array['oauth_nonce'] = mt_rand();
        $parameter_array['oauth_timestamp'] = time();
        $parameter_array['oauth_consumer_key'] = $this->clientAppConfig->getApplicationId();
        $parameter_array['oauth_callback'] = $this->clientAppConfig->getRedirectUrl();
        $parameter_array['oauth_signature_method'] = 'HMAC-SHA1';
        $parameter_array['screen_name'] = 'dchathurangat';
        $parameter_array["oauth_token"] = $_GET["oauth_token"];
        $parameter_array["oauth_verifier"] = $_GET["oauth_verifier"] ;
        $parameter_array['oauth_signature'] = oauth_compute_hmac_sig("GET", $this->ACCESS_TOKEN_ENDPOINT, $parameter_array,$this->clientAppConfig->getApplicationSecret(), null);


        $http_query_string =http_build_query($parameter_array);
        $accessTokenUrl = $this->ACCESS_TOKEN_ENDPOINT."?" .$http_query_string;
//        $_SESSION["TwitterProvider"] = OAuthUtil::setUpInstance($this);

        $response = $this->do_curl_get($accessTokenUrl);
        if(!is_null($response) && !empty($response)){
            //parse the query string into array
            echo "responseIs[".$response."]<br/><br/>";
            parse_str($response,$response_arr);
            $this->accessTokenResponse->setOauthTokenSecret($response_arr["oauth_token_secret"]);
            $this->accessTokenResponse->setOauthToken($response_arr["oauth_token"]);
            $this->protectedResouse($this->accessTokenResponse);
        }
    }


    public function protectedResouse(OAuth1AccessTokenResponse $accessTokenResponse){
        $parameter_array =  array();
        $parameter_array['oauth_nonce'] = mt_rand();
        $parameter_array['oauth_timestamp'] = time();
        $parameter_array['oauth_consumer_key'] = $this->clientAppConfig->getApplicationId();
//        $parameter_array['oauth_callback'] = $this->clientAppConfig->getRedirectUrl();
        $parameter_array["oauth_token"] = $accessTokenResponse->getOauthToken();
        $parameter_array['oauth_version'] = '1.0';
//        $parameter_array["oauth_verifier"] = $accessTokenResponse->getOauthTokenSecret();
        $parameter_array['oauth_signature_method'] = 'HMAC-SHA1';
        $parameter_array['oauth_signature'] = oauth_compute_hmac_sig("GET", $this->PROTECTED_RESOURCE_ENDPOINT, $parameter_array,$this->clientAppConfig->getApplicationSecret(), $accessTokenResponse->getOauthTokenSecret());

        $http_query_string =http_build_query($parameter_array);
        $accessTokenUrl = $this->PROTECTED_RESOURCE_ENDPOINT."?" .$http_query_string;

        echo "<br/>=[".$accessTokenUrl."]=<br/><br/><br/>";
        $response = $this->do_curl_get($accessTokenUrl);
        echo "protected resource response [".$response."]<br/><br/>";
    }

    public function do_curl_get($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }


    public function do_curl_post($url,$param_array){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST ,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$param_array);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}

?>
