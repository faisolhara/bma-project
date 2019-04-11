<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Constants;
use App\Service\AccessControlService;

class ComplaintController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!AccessControlService::checkAccessControl('Complaint')){
                abort(403);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        return view('complaint.add',[
            'statusOption'      => Constants::complaintStatus(),
            'request'           => $request,
            ]);
    }

    public function save(Request $request){
        // dd($request->all());
        $this->validate($request, [
            'complaint_desc'        => 'required|max:4000',
            'room_id'               => 'required',
            'detail_unit_id'        => 'required',
            'complaint_status'      => 'required',
            'complaint_reference'   => 'max:255',
            'complaint_note'        => 'max:1000',
            'cancel_note'           => 'max:1000|required_if:complaint_status,==,'.Constants::CANCEL,
            ]);

        if (in_array($request->get('complaint_status'), [Constants::INSPECTING, Constants::COSTING, Constants::WAITING_APPROVAL, Constants::APPROVED]) && empty($request->get('employee_id'))) {
            return redirect(\URL::previous())->withInput($request->all())->withErrors(['errorMessage' => trans('common.technician-required')]);
        }

        if (empty($request->get('detail_unit_id')) && empty($request->get('facility_id'))) {
            return redirect(\URL::previous())->withInput($request->all())->withErrors(['errorMessage' => trans('common.complaint-line-required')]);
        }

        $header_input = [
            'complaint_id'          => $request->get('complaint_id'),
            'complaint_desc'        => $request->get('complaint_desc'),
            'room_id'               => $request->get('room_id'),
            'complaint_status'      => $request->get('complaint_status'),
            'current_status'        => $request->get('current_status'),
            'complaint_reference'   => $request->get('complaint_reference'),
            'complaint_rate'        => $request->get('complaint_rate'),
            'complaint_note'        => $request->get('complaint_note'),
            'cancel_note'           => $request->get('cancel_note'),
            'additional_note'       => $request->get('additional_note'),
            'available_contact_number'  => $request->get('available_contact_number'),
            'complaint_progress_result' => $request->get('complaint_progress_result'),
            'additional_note'       => $request->get('additional_note'),
            'complaint_cost'        => intval(str_replace(',', '', $request->get('complaint_cost'))),
            'updated_by'            => \Session::get('user')['employee_id'],
            'complaint_inspect_result'  => $request->get('complaint_inspect_result'),
        ];

        if(!empty($request->file('complaint_cost_detail'))){
            $header_input['complaint_cost_detail'] = base64_encode(file_get_contents($request->file('complaint_cost_detail')));
        }

        if(!$request->get('is_save') && $request->get('complaint_status') == Constants::OPEN){
            $header_input['complaint_cost']        = 0;
            $header_input['complaint_cost_detail'] = null;
            $header_input['complaint_inspect_result'] = null;
            $header_input['complaint_progress_result'] = null;
            $header_input['additional_note'] = null;
            $header_input['complaint_rate'] = null;

        }

        if(!empty($request->get('employee_id'))){
            $header_input['employee_id'] = $request->get('employee_id');
        }

        if(!empty($request->get('available_start_date'))){
            $header_input['available_start_date'] = $request->get('available_start_date');
        }

        if(!empty($request->get('available_end_date'))){
            $header_input['available_end_date'] = $request->get('available_end_date');
        }

        if(!empty($request->get('facility_id'))){
            $header_input['facility_id'] = $request->get('facility_id');
        }

        $line_input [] = [
                        'complaint_line_id'     => $request->get('complaint_line_id'),
                        'detail_unit_id'        => $request->get('detail_unit_id'),
         ];

        $upload_input = [];
        if($request->get('complaint_id') == -1 && !empty($request->file('photo'))){
            foreach ($request->file('photo') as $key => $photo) {
                $upload_input[$key]['bytea_upload'] = base64_encode(file_get_contents($photo));
                $upload_input[$key]['upload_id']    = -1;
            }
        }
        $is_save = $request->get('is_save') ? 'true' : 'false';
        $input= [
            'header_input'  => json_encode($header_input, true),
            'line_input'    => json_encode($line_input, true),
            'upload_input'  => json_encode($upload_input, true),
            'api_token'     => \Session::get('user')['api_token'],
            'is_save'       => $is_save,
        ];
        $client   = new Client();
        $response = $client->post(env('URL_API').'save-submitcomplaint', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        $response = json_decode($response->getBody(), true);
        if(!empty($response['err'])){
            return redirect(\URL::previous())->withInput($request->all())->withErrors(['errorMessage' => $response['err']]);
        }

        $is_save = $request->get('is_save');
        $message = trans('common.complaint-saved-message', [
                'complaint' => $response['data'], 
                'room_id'   => $request->get('room_id'), 
                'room_name' => $request->get('room_name'), 
                ]);
        $complaint_status = '';
        if(!$is_save){
            if($request->get('complaint_status') == Constants::CANCEL){
                $complaint_status = 'has CANCELED';
            }else if($request->get('complaint_status') == Constants::OPEN){
                $complaint_status = 'has REJECTED';
            }else if($request->get('complaint_status') == Constants::INSPECTING){
                $complaint_status = 'now INSPECTING';
            }else if($request->get('complaint_status') == Constants::COSTING){
                $complaint_status = 'COSTED';
            }else if($request->get('complaint_status') == Constants::WAITING_APPROVAL){
                $complaint_status = 'now WAITING APPROVAL';
            }else if($request->get('complaint_status') == Constants::APPROVED){
                $complaint_status = 'APPROVED';
            }else if($request->get('complaint_status') == Constants::DONE){
                $complaint_status = 'DONE';
            }


            $message = trans('common.change-complaint-saved-message', [
                'complaint' => $response['data'], 
                'room_id'   => $request->get('room_id'), 
                'room_name' => $request->get('room_name'), 
                'complaint_status' => $complaint_status, 
                ]);
        }

        $request->session()->flash(
            'successMessage',
            $message
            );


        return redirect('complaint');

    }
}