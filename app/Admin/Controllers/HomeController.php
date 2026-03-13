<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Event;
use App\Models\InformationRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Utils;
use Carbon\Carbon;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Auth;
use SplFileObject;

class HomeController extends Controller
{
    public function index(Content $content)
    {
 
        Utils::my_boot();
        $u = Auth::user();
        $content
            ->title('<b>' . Utils::greet() . " " . $u->last_name . '!</b>');
        $u = Admin::user();


        $content->row(function (Row $row) {
            $row->column(6, function (Column $column) {
                $u = Admin::user();
                $conditions_pending = [
                    'status' => 'Pending',
                ];
                $conditions_waiting = [
                    'status' => 'Waiting for response',
                ];
                if (!$u->isRole('admin')) {
                    $conditions_pending['receiver_id'] = $u->id;
                    $conditions_waiting['receiver_id'] = $u->id;
                }
                $column->append(view('widgets.dashboard-segment-1', [
                    'title' => 'Pending Requests',
                    'users' => User::count(),
                    'pending_requests' => InformationRequest::where($conditions_pending)->get(),
                    'waiting_requests' => InformationRequest::where($conditions_waiting)->get(),
                    'events' => Event::where([])->where('event_date', '>=', Carbon::now()->format('Y-m-d'))->orderBy('id', 'desc')->get()
                ]));

                $countries = [];
                $requests = [];
                foreach (Country::all() as $key => $value) {
                    $countries[] = $value->name;
                    $requests[] = InformationRequest::where([
                        'sender_country_id' => $value->id,
                    ])->count();
                }

                $column->append(view('graphs.status-chats', [
                    'labels' => $countries,
                    'data' => $requests,
                ]));
            });
            $row->column(6, function (Column $column) {

                $countries = [];
                $requests = [];
                $requests[] = InformationRequest::where(['status' => "Pending"])->count();
                $requests[] = InformationRequest::where(['status' => "Waiting for response"])->count();
                $requests[] = InformationRequest::where(['status' => "Halted"])->count();
                $requests[] = InformationRequest::where(['status' => "Completed"])->count();

                $column->append(view('graphs.status-pie-chats', [
                    'labels' => [
                        'Pending',
                        'Waiting for response',
                        'Halted',
                        'Completed',
                    ],
                    'data' => $requests,
                ]));

                //$column->append(Dashboard::dashboard_calender());
            });
        });

        return $content;
    }

    public function calendar(Content $content)
    {
        $u = Auth::user();
        $content
            ->title('Company Calendar');
        $content->row(function (Row $row) {
            $row->column(8, function (Column $column) {
                $column->append(Dashboard::dashboard_calender());
            });
            $row->column(4, function (Column $column) {
                $u = Admin::user();
                $column->append(view('dashboard.upcoming-events', [
                    'items' => Event::where([
                        'company_id' => $u->company_id,
                    ])
                        ->where('event_date', '>=', Carbon::now()->format('Y-m-d'))
                        ->orderBy('id', 'desc')->limit(8)->get()
                ]));
            });
        });
        return $content;


        return $content;
    }
}
