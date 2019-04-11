<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class CommonController extends Controller
{

    public function setPlayerIdEmployee(Request $request){
        $input = $request->all();
        $input['api_token']     = \Session::get('user')['api_token'];
        $input['employee_id']   = \Session::get('user')['employee_id'];

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'set-player-id-employee', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        return json_decode($responseOrigin->getBody(), true);
    }
}