<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Constants;
use App\Service\AccessControlService;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mailtrap;
use App\Mail\Gmail;

class MasterUserController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!AccessControlService::checkAccessControl('MasterUser')){
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

        return view('master-user.add',[
            'typeOption'        => Constants::userTypes(),
            'identityOption'    => Constants::identityCards(),
            'departmentOption'  => $responseDepartment['data'],
            ]);
    }

    public function save(Request $request){
        $this->validate($request, [
            'username'          => 'required|max:25',
            'first_name'        => 'required|max:50',
            'middle_name'       => 'max:50',
            'last_name'         => 'max:50',
            'user_type'         => 'required',
            'identity_card'     => 'required|max:5',
            'identity_number'   => 'required|max:25',
            'npwp_number'       => 'max:50',
            'birth_place'       => 'max:25',
            'address'           => 'required|max:200',
            'dept_id'           => 'required|max:25',
            'district'          => 'max:25',
            'email'             => 'required|max:50',
            'phone_number'      => 'required|max:50',
            'administrative_village'    => 'max:25',
            ]);

        $input  = ['header_input' => $request->except(['remove_photo'])];
        $input['header_input']['updated_by'] = \Session::get('user')['employee_id'];
        $input['api_token']                  = \Session::get('user')['api_token'];

        $client   = new Client();
        $response = $client->post(env('URL_API').'save-submitemployeemaster', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        $response = json_decode($response->getBody(), true);

        if(!empty($_FILES['bytea_upload']['tmp_name']) || $request->get('remove_photo')){
            $image['upload_id'] = $request->get('upload_id');
            $image['employee_id'] = $request->get('employee_id');
            $image['bytea_upload'] = $request->get('remove_photo') ? '' : base64_encode(file_get_contents($_FILES['bytea_upload']['tmp_name']));
            $image['updated_by'] = \Session::get('user')['employee_id'];

            $inputImage['header_input'] = json_encode($image);
            $inputImage['api_token'] = \Session::get('user')['api_token'];

            $client   = new Client();
            $responseImage = $client->post(env('URL_API').'save-submitemployeeuploads', [
                'form_params' => $inputImage,
                'verify'      => false,
            ]);
        }

        if(!empty($response['err'])){
            return redirect(\URL::previous())->withInput($request->all())->withErrors(['errorMessage' => $response['err']]);
        }

        $request->session()->flash(
            'successMessage',
            trans('common.saved-message', ['variable' => trans('menu.master-user').' '.$input['header_input']['first_name'].' '.$input['header_input']['last_name']])
            );

        return redirect('master-user');

    }

    public function resetPassword(Request $request){
        $newPassword = $this->generatePassword();

        $input = [
            'api_token'     => \Session::get('user')['api_token'],
            'employee_id'   => $request->get('employee_id'),
            'passwd'        => $newPassword,
        ];

        $client   = new Client();
        $response = $client->post(env('URL_API').'save-employee-reset-password', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        $response = json_decode($response->getBody(), true);

        if(!empty($response['err'])){
            return $response['err'];
        }

        Mail::to($request->get('email'))
            ->send(new Gmail($newPassword));

        return 'success';
    }

    public function generatePassword($length = 8) {
        $randomString = '';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }



}