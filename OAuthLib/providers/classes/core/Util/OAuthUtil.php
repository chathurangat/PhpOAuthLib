<?php
/**
 * Created by
 * Author : Chathuranga Tennakoon
 * Email  : chathuranga.t@gmail.com
 * Blog   : http://chathurangat.blogspot.com
 * Date   : 5/30/12
 * Time   : 3:18 PM
 * IDE    : JetBrains PhpStorm
 *
 */
class OAuthUtil
{


    public static function setUpInstance($object){
        return base64_encode(gzdeflate(serialize($object)));
    }


    public static function getOriginalInstance($object){
        if($object!=NULL){
            return unserialize(gzinflate(base64_decode($object)));
        }
        else{
            return NULL;
        }
    }
}
