<?php

namespace App\Http\Controllers;

use App\KindSport;
use App\Services\ServiceFilterItems;
use Illuminate\Http\Request;
use App\Players;
use App\Services\ServiceUpdateStatistic;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PlayersController extends Controller
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
        $players = ServiceFilterItems::filter(
            Players::class,
            $request->all(),
            'kind_sport_id', // column name
            'kind_sport' // with
        )->withPath('players');

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

        return view('user-side.players', compact('type_sports', 'players'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $kind_sports = KindSport::all();

        return view('admin.add-player', compact('kind_sports'));

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
            'surname' => 'required|max:255',
            'game_number' => 'required',
            'city' => 'required',
            'description' => 'required|min:6|max:2000',
            'kind_sport_id' => 'required|exists:kind_sports,id',
            'team_id' => 'required|exists:teams,id',
            'date_birth' => 'required',
            'avatar' => 'required'
        ]);
        // save file
        $validatedData['avatar'] = Storage::putFile('public/players', $validatedData['avatar']);
       // dd($validatedData);
        $validatedData['date_birth'] = \Carbon\Carbon::parse($validatedData['date_birth'])->format('Y-m-d');

        Players::create($validatedData);

        return back()->with('make', 'Новий гравець доданий');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $player = Players::where('id', '=', $id)->with(['kind_sport', 'teams'])->first();

        ServiceUpdateStatistic::update(
            Carbon::now()->format('Y-m-d'),
            'statistic_type_sports',
            $player->kind_sport_id
        );

        return view('user-side.player', compact('player'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $player = Players::where('id', '=', $id)->with(['kind_sport', 'teams'])->first();
        $kind_sports = KindSport::all();

        $date_birth = \Carbon\Carbon::parse($player->date_birth)->format('m/d/Y');

        return view('admin.edit-player', compact('player', 'kind_sports', 'date_birth'));
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
            'surname' => 'required|max:255',
            'game_number' => 'required',
            'city' => 'required',
            'description' => 'required|min:6|max:2000',
            'kind_sport_id' => 'required|exists:kind_sports,id',
            'team_id' => 'required|exists:teams,id',
            'date_birth' => 'required'
        ]);

        $player = Players::where('id', '=', $id)->first();
        $old_name = $player->name;

        if($request->hasFile('avatar_update')){
            $validatedData['avatar'] = Storage::putFile('public/players', $request->file('avatar_update'));
            Storage::delete($player->avatar);
        }

        $validatedData['date_birth'] = \Carbon\Carbon::parse($validatedData['date_birth'])->format('Y-m-d');

        $player->update($validatedData);

        return back()->with('update', 'Гравець  ' . $old_name . ' оновлений');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $player = Players::where('id', '=', $id)->first();

        if($player){
            $player_name = $player->name;
            try {
                $player->delete();
                return back()->with('delete', 'Гравець ' . $player_name . ' був видалений');
            } catch (\Illuminate\Database\QueryException $th) {
                if($th->errorInfo[0] == '23000'){
                    return back()->with('delete', 'Ви не можете видалити цей запис так, як на неї посилаються інші записи!');
                }
            }
        }

        return back();
    }
}
