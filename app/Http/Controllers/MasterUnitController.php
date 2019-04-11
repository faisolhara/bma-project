<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Constants;
use App\Service\AccessControlService;

class MasterUnitController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!AccessControlService::checkAccessControl('MasterUnit')){
                abort(403);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {   
        $client   = new Client();
        $responseSubUnit = $client->post(env('URL_API').'get-subunit', [
            'verify'      => false,
            'form_params' => [
                'api_token' => \Session::get('user')['api_token'],
                'is_active' => 'Y',
                ],
        ]);
        
        $responseSubUnit = json_decode($responseSubUnit->getBody(), true);

        return view('master-unit.add',[
                'subunitOption' => $responseSubUnit['data'],
            ]);
    }

    public function save(Request $request){
        $this->validate($request, [
            'unit_type'     => 'required|max:50',
            'unit_desc'     => 'required|max:1000',
            'subunit'       => 'required',
            ]);

        $input  =  ['header_input' => [
                        'unit_id'   => $request->get('unit_id'),
                        'unit_type' => $request->get('unit_type'),
                        'unit_desc' => $request->get('unit_desc'),
                        'is_active' => $request->get('is_active'),
                        ],
                    'line_input' => $request->get('subunit'),
                   ];
        $input['header_input']['updated_by'] = \Session::get('user')['employee_id'];
        $input['api_token'] = \Session::get('user')['api_token'];
        
        $client   = new Client();
        $response = $client->post(env('URL_API').'save-submitunitmaster', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        $response = json_decode($response->getBody(), true);
        if(!empty($response['err'])){
            return redirect(\URL::previous())->withInput($request->all())->withErrors(['errorMessage' => $response['err']]);
        }

        $request->session()->flash(
            'successMessage',
            trans('common.saved-message', ['variable' => trans('menu.master-unit').' '.$input['header_input']['unit_type']])
            );

        return redirect('master-unit');

    }
}