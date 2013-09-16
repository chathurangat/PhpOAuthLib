<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chathuranga
 * Date: 9/14/13
 * Time: 1:22 PM
 * To change this template use File | Settings | File Templates.
 */

class OAuth1AccessTokenResponse {

    private $oauthToken;
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
     * @param mixed $oauthToken
     */
    public function setOauthToken($oauthToken)
    {
        $this->oauthToken = $oauthToken;
    }

    /**
     * @return mixed
     */
    public function getOauthToken()
    {
        return $this->oauthToken;
    }
}

?>
