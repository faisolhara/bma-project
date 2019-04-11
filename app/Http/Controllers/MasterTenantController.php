<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Constants;
use App\Service\AccessControlService;

class MasterTenantController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!AccessControlService::checkAccessControl('MasterTenant')){
                abort(403);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        return view('master-tenant.add',[
            'typeOption'        => Constants::tenantTypes(),
            'identityOption'    => Constants::identityCards(),
            ]);
    }

    public function save(Request $request){

        $this->validate($request, [
            'first_name'        => 'required|max:50',
            'middle_name'       => 'max:50',
            'last_name'         => 'max:50',
            'tenant_type'       => 'required',
            'identity_card'     => 'required|max:5',
            'identity_number'   => 'required|max:25',
            'npwp_number'       => 'max:50',
            'birth_place'       => 'max:25',
            'address'           => 'required:max:200',
            'district'          => 'max:25',
            'email'             => 'required|max:50',
            'phone_number'      => 'required|max:50',
            'administrative_village'    => 'max:25',
            ]);

        $input    = ['header_input' => $request->all()];
        $input['api_token']['updated_by']    = \Session::get('user')['api_token'];
        $input['header_input']['updated_by'] = \Session::get('user')['employee_id'];
        $client   = new Client();
        $response = $client->post(env('URL_API').'save-submittenantmaster', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        $response = json_decode($response->getBody(), true);
        if(!empty($response['err'])){
            return redirect(\URL::previous())->withInput($request->all())->withErrors(['errorMessage' => $response['err']]);
        }
        
        $request->session()->flash(
            'successMessage',
            trans('common.saved-message', ['variable' => trans('menu.master-tenant').' '.$input['header_input']['first_name']])
            );

        return redirect('master-tenant');

    }
}