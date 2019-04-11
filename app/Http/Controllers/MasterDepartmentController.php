<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Constants;
use App\Service\AccessControlService;

class MasterDepartmentController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!AccessControlService::checkAccessControl('MasterDepartment')){
                abort(403);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        return view('master-department.add');
    }

    public function save(Request $request){
        $this->validate($request, [
            'dept_name'      => 'required|max:50',
            'dept_desc'      => 'required|max:1000',
            'dept_id'        => 'required',
            ]);

        $input  = ['header_input' => $request->all()];
        $input['header_input']['updated_by'] = \Session::get('user')['employee_id'];
        $input['api_token'] = \Session::get('user')['api_token'];
        $client   = new Client();
        $response = $client->post(env('URL_API').'save-submitdepartmentmaster', [
            'form_params' => $input,
            'verify'      => false,
        ]);

        $response = json_decode($response->getBody(), true);
        if(!empty($response['err'])){
            return redirect(\URL::previous())->withInput($request->all())->withErrors(['errorMessage' => $response['err']]);
        }

        $request->session()->flash(
            'successMessage',
            trans('common.saved-message', ['variable' => trans('menu.master-department').' '.$input['header_input']['dept_name']])
            );

        return redirect('master-department');

    }
}