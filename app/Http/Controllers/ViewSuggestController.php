<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Constants;
use App\Service\AccessControlService;

class ViewSuggestController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!AccessControlService::checkAccessControl('ViewSuggest')){
                abort(403);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $startDateFilter = $request->get('start_date');
        $endDateFilter   = $request->get('end_date');

        if($request->isMethod('post')){
            $input = $request->all();
            $input['start_date'] = $startDateFilter;
            $input['end_date']   = $endDateFilter;

            $input['api_token'] = \Session::get('user')['api_token'];
            $client   = new Client();
            $responseSuggest = $client->post(env('URL_API').'get-suggest-index',['form_params' => $input,'verify' => false,]);
            $responseSuggest = json_decode($responseSuggest->getBody(), true);
        }


        return view('view-suggest.view',[
            'dataSuggest'       => !empty($responseSuggest['data']) ? $responseSuggest['data'] : [],
            'startDateFilter'   => (!empty($startDateFilter)) ? $startDateFilter : Date('01-M-Y'),
            'endDateFilter'     => (!empty($endDateFilter)) ? $endDateFilter : Date('d-M-Y'),
            ]);
    }
}