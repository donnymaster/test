<?php

namespace App\Http\Controllers;

use App\Broadcast;
use App\KindSport;
use App\Services\ServiceAddBroadcastPlayers;
use App\Services\ServiceFilterItems;
use App\Services\ServiceUpdateStatistic;
use App\Services\ServiceValidBroadcast;
use App\Services\ServiceYoutube;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BroadcastController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only([
            'create',
            'store',
            'edit',
            'update',
            'destroy'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $broadcasts = ServiceFilterItems::filter(
            Broadcast::class,
            $request->all(),
            'kind_sport_id', // column name
            'kind_sport' // with
        )->withPath('broadcasts');

        $type_sports = KindSport::all();
        $config = ServiceFilterItems::get_config($request->all() ?? array());

        // sevices
        if($config){
            $type_sports = $type_sports->map(function($item) use ($config){
                foreach ($config as $key => $value) {
                    if($item->id == $value){
                        $item->isChecked = true;
                        break;
                    }else{
                        $item->isChecked = false;
                    }
                }
                return $item;
            });
        }

        return view('user-side.broadcasts', compact('type_sports', 'broadcasts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kind_sports = KindSport::all();

        return view('admin.add-broadcast', compact('kind_sports'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
        $validatedData = ServiceValidBroadcast::valid($request, true);

        $players_id = ServiceAddBroadcastPlayers::add($request->all());
        $validatedData['json_players'] = $players_id;
        Broadcast::create($validatedData);

        return back()->with('make', 'Трансляція була додана');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $broadcast = Broadcast::with(['team_1', 'team_2', 'players_in_broadcast'])->where('id', '=', $id)->first();

        
        ServiceUpdateStatistic::update(
            Carbon::now()->format('Y-m-d'),
            'statistic_views_sport',
            $broadcast->kind_sport_id
        );

        $status = ServiceYoutube::getStatusBroadcast($broadcast->url_video);


        if($status == null)
        {
            $is_valid = false;
            return view('user-side.broadcast', compact(['is_valid', 'broadcast']));
        }

        if($status == 'в майбутньому'){
            $is_valid = true;
            $date = Carbon::parse($broadcast->video_start_date . ' ' . $broadcast->video_start_time);
            $date_start = $date->isoFormat('MMMM D, YYYY HH:mm:ss');
            $video = ServiceYoutube::getContainerVideo($broadcast->url_video)->embedHtml;
            return view('user-side.broadcast', compact(['is_valid', 'broadcast', 'status', 'date_start', 'video']));
        }
        if($status == 'у прямому ефірі'){

            $is_valid = true;
            $video = ServiceYoutube::getContainerVideo($broadcast->url_video)->embedHtml;
            return view('user-side.broadcast', compact(['is_valid', 'broadcast', 'status', 'video']));
        }
        if($status == 'закінчилася'){
            $is_valid = true;
            $status = 'у прямому ефірі';
            $video = ServiceYoutube::getContainerVideo($broadcast->url_video)->embedHtml;
            return view('user-side.broadcast', compact(['is_valid', 'broadcast', 'status', 'video']));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $broadcast = Broadcast::where('id', '=', $id)->with(['kind_sport', 'team_1', 'team_2'])->first();

        $kind_sports = KindSport::all();

        $video_start_date = \Carbon\Carbon::parse($broadcast->video_start_date)->format('m/d/Y');

        return view('admin.edit-broadcast', compact(['broadcast', 'kind_sports', 'video_start_date']));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = ServiceValidBroadcast::valid($request);

        $broadcast = Broadcast::where('id', '=', $id)->first();
        $broadcast_name = $broadcast->name;

        ServiceAddBroadcastPlayers::update($request->all(), $broadcast->json_players);

        $broadcast->update($validatedData);

        return back()->with('update', 'Трансляція ' . $broadcast_name . ' була оновлена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $broadcast = Broadcast::where('id', '=', $id)->first();

        if($broadcast){
            $broadcast_name = $broadcast->name;
            try {
                $broadcast->delete();
                return back()->with('delete', 'Трансляція ' . $broadcast_name . ' була видалена');
            } catch (\Illuminate\Database\QueryException $th) {
                if($th->errorInfo[0] == '23000'){
                    return back()->with('delete', 'Ви не можете видалити цей запис так, як на неї посилаються інші записи!');
                }
            }
        }

        return back();
    }
}
