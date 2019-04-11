<?php 

namespace App\Service;

class AccessControlService
{
    public static function checkAccessControl($resourceInput)
    {
        $accessControl = config('menu.access-control');
        foreach ($accessControl as $access) {
            if($access['user'] == \Session::get('user')['user_type']){
                foreach ($access['resource'] as $resource) {
                    if($resource == $resourceInput){
                        return true;
                    }
                }
            }
        }
        return false;
    }
}