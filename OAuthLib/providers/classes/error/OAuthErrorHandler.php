<?php
/**
 *  User      : Chathuranga Tennkoon
 *  Blog       : http://chathurangat.blogspot.com
 *  GitHub   : https://github.com/chathurangat
 *  Email     : chathuranga.t@gmail.com
 *  Location : Colombo, Sri Lanka
 *  IDE         :  JetBrains PhpStorm.
 */
class OAuthErrorHandler
{
    static function getErrorDescription($errorCode){

        switch($errorCode){

            case 'invalid_request' :
                return "The request is missing a required parameter, includes an unknown parameter or parameter value, or is otherwise malformed";
                break;

            case 'invalid_client' :
                return "The client identifier provided is invalid";
                break;

            case 'unauthorized_client' :
                return "The client is not authorized to use the requested response type";
                break;

            case 'redirect_uri_mismatch' :
                return "The redirection URI provided does not match a pre-registered value";
                break;

            case  'access_denied' :
                return "The end-user or authorization server denied the request";
                break;

            case  'unsupported_response_type' :
                return  "The requested response type is not supported by the authorization server";
                break;

            case 'invalid_grant' :
                return "The provided access grant is invalid, expired, or revoked (e.g. invalid assertion, expired authorization token, bad end-user basic credentials, or mismatching authorization code and redirection URI)";
                break;

            //application specific
            case 'no_response':
                return   "No response from the server";
                break;

            //application specific
            case 'state_invalid':
                return   "State Invalid- the value received for the state is different from the value sent";
                break;

            //application specific
            case 'access_token_missing':
                return   "Access Token is not Available";
                break;

            default:
                return "Error code is undefined";
                break;
        }
    }


}
