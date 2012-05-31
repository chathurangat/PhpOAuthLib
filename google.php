<?php
/**
 * Created by
 * Author : Chathuranga Tennakoon
 * Email  : chathuranga.t@gmail.com
 * Blog   : http://chathurangat.blogspot.com
 * Date   : 5/30/12
 * Time   : 9:09 AM
 * IDE    : JetBrains PhpStorm
 *
 */

include "OAuthLib/providers/OAuthProviderFactory.php";


echo " Retrieving Data from Google <br/>";

$providerInstance = new OAuth2Impl();
$providerInstance = OAuthProviderFactory::getOAuthProvider(OAuthProvider::GOOGLE);

$requestToken = $providerInstance->getRequestToken();

echo "Request Token [".$requestToken."]";

?>
