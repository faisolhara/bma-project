<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Constants;
use App\Service\AccessControlService;

class SuggestController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!AccessControlService::checkAccessControl('Suggest')){
                abort(403);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        return view('suggest.add',[
            'request'           => $request,
            ]);
    }

    public function save(Request $request){
        // dd($request->all());
        $this->validate($request, [
            'suggest_name'          => 'required|max:50',
            'suggest_desc'          => 'required|max:4000',
            'room_id'               => 'required',
            'facility_id'           => 'required',
            ]);


        $header_input = [
            'suggest_id'                => $request->get('suggest_id'),
            'suggest_name'              => $request->get('suggest_name'),
            'suggest_desc'              => $request->get('suggest_desc'),
            'room_id'                   => $request->get('room_id'),
            'facility_id'               => $request->get('facility_id'),
            'updated_by'                => \Session::get('user')['employee_id'],
        ];

        $upload_input = [];
        if($request->get('suggest_id') == -1 && !empty($request->file('photo'))){
            foreach ($request->file('photo') as $key => $photo) {
                $upload_input[$key]['bytea_upload'] = base64_encode(file_get_contents($photo));
                $upload_input[$key]['upload_id']    = -1;
            }
        }

        $input= [
            'header_input'  => json_encode($header_input, true),
            'upload_input'  => json_encode($upload_input, true),
            'api_token'     => \Session::get('user')['api_token'],
        ];

        $client   = new Client();
        $response = $client->post(env('URL_API').'save-submitsuggest', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        $response = json_decode($response->getBody(), true);
        if(!empty($response['err'])){
            return redirect(\URL::previous())->withInput($request->all())->withErrors(['errorMessage' => $response['err']]);
        }

        $request->session()->flash(
            'successMessage',
            trans('common.saved-message', ['variable' => trans('menu.suggest').' '.$response['data']])
            );


        return redirect('suggest');

    }
}