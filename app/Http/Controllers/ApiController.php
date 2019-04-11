<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ApiController extends Controller
{

    public function getEmployee(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-employee', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        return json_decode($responseOrigin->getBody(), true);
    }

    public function getEmployeeIndex(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-employee-index', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        return json_decode($responseOrigin->getBody(), true);
    }

    public function getTenant(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-tenant', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        return json_decode($responseOrigin->getBody(), true);
    }

    public function getUnit(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-unit', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        return json_decode($responseOrigin->getBody(), true);
    }

    public function getSubunit(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-subunit', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        return json_decode($responseOrigin->getBody(), true);
    }

    public function getDetailUnit(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-detailunit', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        return json_decode($responseOrigin->getBody(), true);
    }

    public function getDetailUnitByRoom(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-detailunitbyroom', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        return json_decode($responseOrigin->getBody(), true);
    }

    public function getRoomIndex(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-room-index', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        return json_decode($responseOrigin->getBody(), true);
    }

    public function getRoom(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-room', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        return json_decode($responseOrigin->getBody(), true);
    }

    public function getDepartment(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-department', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        return json_decode($responseOrigin->getBody(), true);
    }

    public function getFacility(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-facility', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        return json_decode($responseOrigin->getBody(), true);
    }

    public function getComplaintIndex(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-complaint-index', [
            'form_params' => $input,
            'verify'      => false,
        ]);

        return json_decode($responseOrigin->getBody(), true);
    }

    public function getComplaint(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-complaint', [
            'form_params' => $input,
            'verify'      => false,
        ]);

        return json_decode($responseOrigin->getBody(), true);
    }

    public function getHistTrans(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];

        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-hist-trans', [
            'form_params' => $input,
            'verify'      => false,
        ]);

        return json_decode($responseOrigin->getBody(), true);
    }

    public function getEmployeeDetailUnit(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];
        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-employeedetailunit', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        return json_decode($responseOrigin->getBody(), true);
    }

    public function getSuggestIndex(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];
        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-suggest-index', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        return json_decode($responseOrigin->getBody(), true);
    }

    public function getSuggest(Request $request){
        $input = $request->all();
        $input['api_token'] = \Session::get('user')['api_token'];
        $client             = new Client();
        $responseOrigin     = $client->post(env('URL_API').'get-suggest', [
            'form_params' => $input,
            'verify'      => false,
        ]);
        
        return json_decode($responseOrigin->getBody(), true);
    }

}