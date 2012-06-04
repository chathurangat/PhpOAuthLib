<?php
/**
 *  User      : Chathuranga Tennkoon
 *  Blog       : http://chathurangat.blogspot.com
 *  GitHub   : https://github.com/chathurangat
 *  Email     : chathuranga.t@gmail.com
 *  Location : Colombo, Sri Lanka
 *  IDE         :  JetBrains PhpStorm.
 */

class OAuthClientConfig
{

    private $oauth_provider = NULL;
    private $application_id = NULL;
    private $application_secret  = NULL;
    private $redirect_url = NULL;
    private $state = NULL;

    public function setApplicationId($application_id)
    {
        $this->application_id = $application_id;
    }

    public function getApplicationId()
    {
        return $this->application_id;
    }

    public function setApplicationSecret($application_secret)
    {
        $this->application_secret = $application_secret;
    }

    public function getApplicationSecret()
    {
        return $this->application_secret;
    }

    public function setRedirectUrl($redirect_url)
    {
        $this->redirect_url = $redirect_url;
    }

    public function getRedirectUrl()
    {
        return $this->redirect_url;
    }

    public function setState($state=NULL )
    {
          if($state!=NULL){
            $this->state = $state;
          }
        else{
            $this->state = md5(uniqid(rand(), TRUE));
        }
    }

    public function getState()
    {
        return $this->state;
    }

    public function setOAuthProvider($oauth_provider)
    {
        $this->oauth_provider = $oauth_provider;
    }

    public function getOAuthProvider()
    {
        return $this->oauth_provider;
    }


}
