<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Constants;
use App\Service\AccessControlService;

class ReportTechnician extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!AccessControlService::checkAccessControl('Report4')){
                abort(403);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {   
        $client   = new Client();
        $responseDepartment = $client->post(env('URL_API').'get-department',[
            'verify'      => false,
            'form_params' => ['api_token' => \Session::get('user')['api_token']],
            ]);
        $responseDepartment = json_decode($responseDepartment->getBody(), true);

        return view('report4.report',[
            'departmentOption'  => $responseDepartment['data'],
            'dataReport'  => array(),
            'deptId'  => '',
            'startdateFilter'    => Date('01-M-Y'),
            'enddateFilter'    => Date('d-M-Y')
        ]);
    }

    public function getData(Request $request)
    {
        $client   = new Client();
        $responseDepartment = $client->post(env('URL_API').'get-department',[
            'verify'      => false,
            'form_params' => ['api_token' => \Session::get('user')['api_token']],
            ]);
        $responseDepartment = json_decode($responseDepartment->getBody(), true);


        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];
        $client   = new Client();
        $responseReport = $client->post(env('URL_API').'get-report-technician',['form_params' => $input,'verify' => false,]);
        $responseReport = json_decode($responseReport->getBody(), true);

        $startdateFilter = $request->get('start_date');
        $enddateFilter = $request->get('end_date');

        return view('report4.report',[
            'deptId' => $request->get('dept_id'),
            'departmentOption'  => $responseDepartment['data'],
            'dataReport'  => $responseReport['data'],
            'startdateFilter'    => (!empty($startdateFilter)) ? $startdateFilter : Date('d-M-Y'),
            'enddateFilter'    => (!empty($enddateFilter)) ? $enddateFilter : Date('d-M-Y')
            ]);
    }
}