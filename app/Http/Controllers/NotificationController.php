<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Service\NotificationService;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        
        // pagination
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        if ($request->isMethod('post')) {
            $request->session()->put('filters', $request->all());
            return redirect('/notification?page=1');
        } elseif (empty($request->get('page'))) {
            $request->session()->forget('filters');
        }

        $filters = $request->session()->get('filters');
        $client   = new Client();
        $response = $client->post(env('URL_API').'get-employeenotification',[
            'verify'      => false,
            'form_params' => [
                                'api_token'         => \Session::get('user')['api_token'], 
                                'employee_id'       => \Session::get('user')['employee_id'], 
                                'notification_title'=> $filters['notification_title'], 
                                'notification_desc' => $filters['notification_desc'], 
                                'dateFrom'          => $filters['date_from'], 
                                'dateTo'            => $filters['date_to'], 
                            ],
            ]);

        $data = json_decode($response->getBody(), true);

        $article = collect($data['data']);
        $currentResults = $article->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $results = new LengthAwarePaginator($currentResults, $article->count(), $perPage);

        return view('notification.index', [
            'notifications' => $results,
            'filters'       => $filters,
        ]);
    }

    public function read(Request $request, $id)
    {
        $client   = new Client();
        $response = $client->post(env('URL_API').'save-reademployeenotification',[
            'verify'      => false,
            'form_params' => [
                                'api_token'    => \Session::get('user')['api_token'], 
                                'employee_id'  => \Session::get('user')['employee_id'], 
                                'complaint_id' => $id, 
                            ],
            ]);

        $response = json_decode($response->getBody(), true);

        return redirect(url('/complaint?complaint_id='.$id));
    }

    public function getNotification(Request $request)
    {
        $notifications = NotificationService::getNotifications($request->get('lastid', 0));
        $count         = NotificationService::getCountNotification();

        return response()->json(['count' => $count, 'notifications' => $notifications]);
    }

    public function readNotification(Request $request, $id)
    {
        $notification = Notification::find($id);

        if ($notification !== null) {
            $notification->read_at = new \DateTime();
            $notification->save();
        }

        CurrentRoleService::changeCurrentRole($notification->role_id);
        CurrentBranchService::changeCurrentBranch($notification->branch_id);

        if (!empty($notification->url)) {
            return redirect($notification->url);
        } else {
            return redirect(\URL::previous());
        }
    }
}
