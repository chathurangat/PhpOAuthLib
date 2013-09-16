<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chathuranga
 * Date: 9/14/13
 * Time: 11:15 AM
 * To change this template use File | Settings | File Templates.
 */

class OAuth1RequestTokenResponse {

    private $requestToken;
    private $oauthTokenSecret;

    /**
     * @param mixed $oauthTokenSecret
     */
    public function setOauthTokenSecret($oauthTokenSecret)
    {
        $this->oauthTokenSecret = $oauthTokenSecret;
    }

    /**
     * @return mixed
     */
    public function getOauthTokenSecret()
    {
        return $this->oauthTokenSecret;
    }

    /**
     * @param mixed $requestToken
     */
    public function setRequestToken($requestToken)
    {
        $this->requestToken = $requestToken;
    }

    /**
     * @return mixed
     */
    public function getRequestToken()
    {
        return $this->requestToken;
    }
}

?>
