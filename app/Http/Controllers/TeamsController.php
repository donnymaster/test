<?php

namespace App\Http\Controllers;

use App\Services\ServiceFilterItems;
use Illuminate\Http\Request;
use App\Teams;
use App\KindSport;
use App\Players;
use App\Services\ServicesAbbr;
use App\Services\ServiceUpdateStatistic;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;


class TeamsController extends Controller
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
        $teams = ServiceFilterItems::filter(
            Teams::class,
            $request->all(),
            'kind_sport_id', // column name
            'kind_sport' // with
        )->withPath('teams');

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

        return view('user-side.teams', compact('type_sports', 'teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kind_sports = KindSport::all();

        return view('admin.add-team', compact('kind_sports'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'kind_sport_id' => 'required|exists:kind_sports,id',
            'city' => 'required',
            'description' => 'required|min:6|max:2000',
            'logo' => 'required'
        ]);

        $validatedData['abbr'] = ServicesAbbr::abbreviate($request->input('name'));
        $validatedData['logo'] = Storage::putFile('public/teams', $validatedData['logo']);

        Teams::create($validatedData);

        return back()->with('make', 'Нова команда створена');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = Teams::where('id', '=', $id)->with('kind_sport')->first();
        $players = Players::where('team_id', '=', $id)->paginate(8);
        ServiceUpdateStatistic::update(
            Carbon::now()->format('Y-m-d'),
            'statistic_type_sports',
            $team->kind_sport_id
        );

        return view('user-side.team', compact('team', 'players'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $team = Teams::where('id', '=', $id)->with('kind_sport')->first();
        $kind_sports = KindSport::all();

        return view('admin.edit-team', compact('team', 'kind_sports'));
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
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'kind_sport_id' => 'required|exists:kind_sports,id',
            'city' => 'required',
            'description' => 'required|min:6|max:2000'
        ]);

        $team = Teams::where('id', '=', $id)->first();
        $old_name = $team->name;

        if($request->hasFile('logo')){
            $validatedData['logo'] = Storage::putFile('public/teams', $request->file('logo'));
            Storage::delete($team->avatar);
        }

        $team->update($validatedData);

        return back()->with('update', 'Команда  ' . $old_name . ' оновлений');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Teams::where('id', '=', $id)->first();
        if($team){
            $team_name = $team->name;
            try {
                $team->delete();
                return back()->with('delete', 'Команда ' . $team_name . ' була видалена');
            } catch (\Illuminate\Database\QueryException $th) {
                if($th->errorInfo[0] == '23000'){
                    return back()->with('delete', 'Ви не можете видалити цей запис так, як на неї посилаються інші записи!');
                }
            }
        }

        return back();
    }
}
