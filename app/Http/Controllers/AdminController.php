<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class AdminController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login');
    }
    
    public function login(Request $request){

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $client   = new Client();
        $response = $client->post(env('URL_API').'login-employee', [
            'form_params' => $request->all(),
            'verify'      => false,
        ]);

        $response = json_decode($response->getBody(), true);
        
        if(empty($response['data'])){
            return redirect(\URL::previous())->withInput($request->all())->withErrors(['errorMessage' => $response['message']]);
        }
        \Session::put('user', $response['data']);
        \Session::put('language', $response['data']['language']);
        return redirect('/dashboard');
    }

    public function logout(Request $request){

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'delete-player-id-employee', [
            'form_params' => [
                                'api_token'   => \Session::get('user')['api_token'],
                                'employee_id' => \Session::get('user')['employee_id'],
                            ],
            'verify'      => false,
        ]);

        $request->session()->flush();
        return redirect('/');
    }
}