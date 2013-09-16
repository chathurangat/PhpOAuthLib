<?php
/**
 * Created by JetBrains PhpStorm.
 * User: chathuranga
 * Date: 9/11/13
 * Time: 11:49 AM
 * To change this template use File | Settings | File Templates.
 */

interface OAuth1Interface {

    public function getRequestTokenResponse();

    public function getAuthorizationUrl(OAuth1RequestTokenResponse $requestTokenResponse);

    public function getAccessToken();

    public function getProtectedResource();

    public function retrieveRequestedResourceData();

}
?>
