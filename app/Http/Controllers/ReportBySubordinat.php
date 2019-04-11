<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Constants;
use App\Service\AccessControlService;

class ReportBySubordinat extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!AccessControlService::checkAccessControl('Report2')){
                abort(403);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {   
        return view('report2.report',[
            'dataReport'  => array(),
            'startdateFilter'    => Date('01-M-Y'),
            'enddateFilter'    => Date('d-M-Y')
        ]);
    }

    public function getData(Request $request)
    {
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];
        $input['employee_id'] = \Session::get('user')['employee_id'];
        $input['user_type'] = \Session::get('user')['user_type'];
        $client   = new Client();
        $responseReport = $client->post(env('URL_API').'get-report-complaint-by-subordinat',['form_params' => $input,'verify' => false,]);
        $responseReport = json_decode($responseReport->getBody(), true);

        $startdateFilter = $request->get('start_date');
        $enddateFilter = $request->get('end_date');

        return view('report2.report',[
            'dataReport'  => $responseReport['data'],
            'startdateFilter'    => (!empty($startdateFilter)) ? $startdateFilter : Date('d-M-Y'),
            'enddateFilter'    => (!empty($enddateFilter)) ? $enddateFilter : Date('d-M-Y')
            ]);
    }
}