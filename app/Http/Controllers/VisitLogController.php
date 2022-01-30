<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sarfraznawaz2005\VisitLog\Models\VisitLog as VisitLogModel;
use App\Observers\ActivityLogObserver;

class VisitLogController extends Controller
{
    public function __construct()
    {
        \App\Visit_logs::observe(ActivityLogObserver::class);
    }

    public function index()
    {
        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Visit_logs(),
            'property' => ['name' => 'Check Web Visitors List'],
            'type' => 'Read',
            'log' => 'Check Web Visitors List Read By ' . \Auth::user()->name,
        ]));

        if (!config('visitlog.visitlog_page')) {
            abort(404);
        }
        return view('backend.visitor.index',['visitors'=>VisitLogModel::orderBy('viewstatus','DESC')->get()]);
    }

    public function get_visitor_info(Request $request){

        $visitor =\App\Visit_logs::where('id',$request->id)->first();
        $get_old_status=$visitor->viewstatus;
        \App\Visit_logs::where('id',$request->id)->update(['viewstatus' => \Carbon\Carbon::now()]);
        $visitor=array(
            'id'=>$visitor->id,
            'user_name'=>$visitor->user_name,
            'ip'=>$visitor->ip,
            'browser'=>$visitor->browser,
            'os'=>$visitor->os,
            'user_view_count'=>$visitor->view_count,
            'country_code'=>$visitor->country_code,
            'country_name'=>$visitor->country_name,
            'region_name'=>$visitor->region_name,
            'city'=>$visitor->city,
            'zip_code'=>$visitor->zip_code,
            'latitude'=>$visitor->latitude,
            'longitude'=>$visitor->longitude,
            'time_zone'=>$visitor->time_zone,
            'geoname_id'=>$visitor->geoname_id,
            'capital'=>$visitor->capital,
            'country_flag'=>$visitor->country_flag,
            'connection_asn'=>$visitor->connection_asn,
            'connection_isp'=>$visitor->connection_isp,
            'languages'=>$visitor->languages,
            'last_visit'=>$visitor->updated_at->diffForHumans(),
            'time'=>(string)date('d-m-Y h:i:s A',strtotime($visitor->created_at)),
            'view_status'=>$get_old_status,
        );

        (new ActivityLogController())->store((new Request())->replace([
            'model' => new \App\Visit_logs(),
            'property' => \App\Visit_logs::find($request->id),
            'type' => 'Read',
            'log' => 'Check Web Visitor Details Read By ' . \Auth::user()->name,
        ]));

        return response()->json($visitor);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {
    }


    public function edit($id)
    {
    }

    public function destroy(Request $request)
    {
        $visitor=\App\Visit_logs::find($request->id);
        $data=array(
            'status'=>$visitor->viewstatus,
            'msg'=>$visitor->ip.'\'s visitor record has been deleted!',
        );
        $visitor->delete();
        return response()->json($data);
    }

    public function destroy_bulk()
    {
        \App\Visit_logs::query()->truncate();
        return redirect()->route('site-visitors.index')->with('success', 'All Visitors information has been successfully cleared!');
    }
}
