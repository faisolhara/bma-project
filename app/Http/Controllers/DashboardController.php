<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Constants;

class DashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function _construct(){
        $this->middleware('customAuth');
    }

    public function index(Request $request)
    {
        $client   = new Client();
        $response = $client->post(env('URL_API').'get-dashboard', [
            'form_params' => [
                'api_token'   => \Session::get('user')['api_token'],
                'employee_id' => \Session::get('user')['employee_id'],
            ],
            'verify'      => false,
        ]);

        $response = json_decode($response->getBody(), true);
        return view('dashboard', [
                'data' => $response['data'],
            ]);
    }

    public function viewSetting(Request $request)
    {
        return view('setting', [
                'languageOptions' => Constants::language(),
            ]);
    }

    public function saveSetting(Request $request)
    {
        $this->validate($request, [
            'language'      => 'required',
            ]);

        \App::setLocale(strtolower($request->get('language')));
        \Session::forget('language');
        \Session::put('language', \App::getLocale());


        $client   = new Client();
        $response = $client->post(env('URL_API').'save-submitemployeelanguage', [
            'form_params' => [
                'api_token'   => \Session::get('user')['api_token'],
                'employee_id' => \Session::get('user')['employee_id'],
                'language'    => \App::getLocale(),
            ],
            'verify'      => false,
        ]);

        $request->session()->flash(
            'successMessage',
            trans('common.saved-message', ['variable' => trans('menu.setting')])
            );

        return redirect('dashboard');
    }
}