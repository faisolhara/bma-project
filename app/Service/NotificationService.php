<?php 

namespace App\Service;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class NotificationService
{
    public static function getNotifications($lastid = 0)
    {
        $client   = new Client();
        $response = $client->post(env('URL_API').'get-employeenotification',[
            'verify'      => false,
            'form_params' => [
                                'api_token'   => \Session::get('user')['api_token'], 
                                'employee_id' => \Session::get('user')['employee_id'], 
                                'is_read'     => 'N', 
                                'limit'       => 10, 
                                'lastid'      => $lastid, 
                            ],
            ]);

        $response = json_decode($response->getBody(), true);

        return $response['data'];
    }

    public static function getCountNotification()
    {
        $client   = new Client();
        $response = $client->post(env('URL_API').'get-countemployeenotificationunread',[
            'verify'      => false,
            'form_params' => [
                                'api_token'   => \Session::get('user')['api_token'], 
                                'employee_id' => \Session::get('user')['employee_id'], 
                            ],
            ]);

        $response = json_decode($response->getBody(), true);

        return $response['data'];
    }
}