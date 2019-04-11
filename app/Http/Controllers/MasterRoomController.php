<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Constants;
use App\Service\AccessControlService;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class MasterRoomController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!AccessControlService::checkAccessControl('MasterRoom')){
                abort(403);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        return view('master-room.add');
    }

    public function save(Request $request){
        $this->validate($request, [
            'room_name'      => 'required|max:20',
            'room_passwd'    => 'required|max:80',
            'room_desc'      => 'max:4000',
            'unit_id'        => 'required',
            'tenant_id'      => 'required',
            'landlord_id'    => 'required',
            ]);

        $input  = ['header_input' => 
                        [
                            'room_id'       => $request->get('room_id'),
                            'room_name'     => $request->get('room_name'),
                            'room_passwd'   => $request->get('room_passwd'),
                            'unit_id'       => $request->get('unit_id'),
                            'tenant_id'     => $request->get('tenant_id'),
                            'landlord_id'   => $request->get('landlord_id'),
                            'room_desc'     => $request->get('room_desc'),
                            'is_active'     => $request->get('is_active'),
                        ]
                ];
        $input['api_token'] = \Session::get('user')['api_token'];
        $input['header_input']['updated_by'] = \Session::get('user')['employee_id'];
        $client   = new Client();

        try {
            $response = $client->post(env('URL_API').'save-submitroommaster', [
                'form_params' => $input,
                'verify'      => false,
            ]);
            $response = json_decode($response->getBody(), true);
            
        } catch (RequestException $e) {
            echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                echo (Psr7\str($e->getResponse()));
                exit();
            }
        }
        

        if(!empty($response['err'])){
            return redirect(\URL::previous())->withInput($request->all())->withErrors(['errorMessage' => $response['err']]);
        }

        $request->session()->flash(
            'successMessage',
            trans('common.saved-message', ['variable' => trans('menu.master-room').' '.$input['header_input']['room_name']])
            );

        return redirect('master-room');

    }
}