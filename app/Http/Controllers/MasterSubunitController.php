<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Constants;
use App\Service\AccessControlService;

class MasterSubunitController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!AccessControlService::checkAccessControl('MasterSubunit')){
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
            'form_params' => ['api_token' => \Session::get('user')['api_token'], 'is_active' => 'Y'],
            ]);
        $responseDepartment = json_decode($responseDepartment->getBody(), true);

        return view('master-subunit.add',[
            'departmentOption'  => $responseDepartment['data'],
            ]);
    }

    public function save(Request $request){
        $this->validate($request, [
            'subunit_name'      => 'required|max:50',
            'subunit_desc'      => 'required|max:1000',
            'dept_id'           => 'required',
            ]);

        $input  = ['header_input' => $request->all()];
        $input['api_token'] = \Session::get('user')['api_token'];
        $input['header_input']['updated_by'] = \Session::get('user')['employee_id'];
        $client   = new Client();
        $response = $client->post(env('URL_API').'save-submitsubunitmaster', [
            'form_params' => $input,
            'verify'      => false,
        ]);

        $response = json_decode($response->getBody(), true);
        if(!empty($response['err'])){
            return redirect(\URL::previous())->withInput($request->all())->withErrors(['errorMessage' => $response['err']]);
        }

        $request->session()->flash(
            'successMessage',
            trans('common.saved-message', ['variable' => trans('menu.master-subunit').' '.$input['header_input']['subunit_name']])
            );

        return redirect('master-subunit');

    }
}