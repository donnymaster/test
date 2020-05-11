<?php

namespace App\Http\Controllers;

use App\Broadcast;
use App\Feedback;
use App\Players;
use App\Services\ServiceYoutube;
use App\Teams;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Cloner\Data;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackMail;
use App\PlayerInBroadcast;
use App\Services\ServiceChart;
use App\Services\ServiceChartFeedback;

class ManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $chart_views_sport = ServiceChart::chart('statistic_views_sport');

       $chart_type_sport = ServiceChart::chart('statistic_type_sports');

        $chart_feedback = ServiceChartFeedback::chart();

       if($chart_views_sport->datasets === array()){
            $chart_views_sport = null;
       }
       if($chart_type_sport->datasets === array()){
            $chart_type_sport = null;
       }
       if($chart_feedback->datasets === array()){
            $chart_feedback = null;
       }
      //  dd($chart_feedback, $chart_type_sport, $chart_views_sport);

        return view('admin.index', compact('chart_views_sport', 'chart_type_sport', 'chart_feedback'));
    }

    public function teams()
    {
        return view('admin.teams');
    }

    public function players()
    {
        return view('admin.players');
    }

    public function broadcasts()
    {

        return view('admin.broadcasts');

    }

    public function feedbacks()
    {
        return view('admin.feedback');
    }

    public function answerFeedback($id)
    {
        $feedback = Feedback::where('id', '=', $id)->first();

        if(!$feedback){ return back(); }

        return view('admin.answer-feedback', compact('feedback'));
    }

    public function answerQuestion(Request $request)
    {
        $validatedData = $request->validate([
            'answer-admin' => 'required|min:6',
            'user_name' => 'required|max:255',
            'user_email' => 'required'
        ]);

        $feedback = (object) '';
        $feedback->user_name = $validatedData['user_name'];
        $feedback->answer = $validatedData['answer-admin'];
        $email_send = 'Ваша відповідь відправлена';

        try {

            $foo = Mail::to($validatedData['user_email'])->send(new FeedbackMail($feedback));

            Feedback::where('id', '=', $request->input('id'))->delete();

            return view('admin.feedback', compact('email_send'));

        } catch (\Throwable $th) {
            $error_send = $th->getMessage();
            return view('admin.feedback', compact('error_send'));
        }

    }

    public function feedbacksJson()
    {
        $feedbacks = DataTables::of(Feedback::with('user'))
                        ->addColumn('action', function($item){
                            return '
                                <div class="edit-delete">

                                    <a href="' . route('admin.answerFeedback', ['id' => $item->id]) . '"
                                        class="btn btn-primary btn-sm">
                                        Відповісти
                                    </a>

                                </div>
                            ';
                        })
                        ->editColumn('message', function($item){
                            return Str::limit($item->message, 20);
                        })
                        ->orderColumn('message', 'message $1')
                        ->rawColumns(['action'])
                        ->make(true);

        return $feedbacks;
    }

    public function broadcastsJson()
    {
        $broadcast = DataTables::of(Broadcast::with(['team_1', 'team_2'])->select('broadcasts.*'))
            ->addColumn('action', function($item){
                return '
                    <div class="edit-delete">
                        <a href="' . route('broadcasts.edit', ['broadcast' => $item->id]) .'" class="btn btn-primary btn-sm">Редагувати</a>
                        <button type="button"
                                class="btn btn-danger btn-sm delete-item"
                                data-toggle="modal"  data-id="' . $item->id . '"
                                data-target="#exampleModal">
                                    Видалити
                                </button>
                    </div>
                ';
            })
            ->editColumn('name', function($item){
                return '
                    <a data-order="' . $item->id . '" target="_blank" href="' . route('broadcasts.show', ['broadcast' => $item->id]) . '">
                        ' . Str::limit($item->name, 25) . '
                    </a>
                ';
            })
            ->editColumn('status', function($item){
                return '
                    <div class="text-center">
                        <div class="
                            ' . ServiceYoutube::getClasBroadcast($item->status) . '
                        ">
                           ' . $item->status . '
                        </div>
                    </div>
                ';
            })
            ->orderColumns(['name', 'status'], ':column $1')
            ->rawColumns(['status', 'action', 'name'])
            ->addColumn('team_id_1', function($item){
                return $item->team_1->name;
            })
            ->addColumn('team_id_2', function($item){
                return $item->team_2->name;
            })
            ->addColumn('video_start', function($item){
                return $item->video_start_date . ' ' . $item->video_start_time;
            })
            ->make(true);

            return $broadcast;
    }

    public function teamsJson(){

        $teams = DataTables::of(Teams::with('kind_sport'))
                    ->addColumn('action', function($item){
                        return '
                            <div class="edit-delete">
                                <a href="' . route('teams.edit', ['team' => $item->id]) .'" class="btn btn-primary btn-sm">Редагувати</a>
                                <button type="button"
                                        class="btn btn-danger btn-sm delete-item"
                                        data-toggle="modal"  data-id="' . $item->id . '"
                                        data-target="#exampleModal">
                                            Видалити
                                        </button>
                            </div>
                        ';
                    })
                    ->editColumn('name', function($item){
                        return '
                            <a target="_blank" href="' . route('teams.show', ['team' => $item->id]) . '">
                                ' . $item->name . '
                            </a>
                        ';
                    })
                    ->orderColumn('name', 'name $1')
                    ->addColumn('kind_sport', function($item){
                        return $item->kind_sport->name_kind_sport;
                    })
                    ->addColumn('description', function($item){
                        return Str::limit($item->description, 20);
                    })
                    ->rawColumns(['action', 'name'])
                    ->make(true);
        return $teams;
    }

    public function playersJson(){

        $players = DataTables::of(Players::with('teams'))
                        ->addColumn('action', function($item){
                            return '
                                <div class="edit-delete">
                                    <a href="' . route('players.edit', ['player' => $item->id]) .'" class="btn btn-primary btn-sm">Редагувати</a>
                                    <button type="button"
                                            class="btn btn-danger btn-sm delete-item"
                                            data-toggle="modal"  data-id="' . $item->id . '"
                                            data-target="#exampleModal">
                                                Видалити
                                            </button>
                                </div>
                            ';
                        })
                        ->editColumn('name', function($item){
                            return '
                                <a target="_blank" href="' . route('players.show', ['player' => $item->id]) . '">
                                    ' . $item->name . '
                                </a>
                            ';
                        })
                        ->addColumn('teams', function($item){
                            return $item->teams->name;
                        })
                        ->addColumn('description', function($item){
                            return Str::limit($item->description, 20);
                        })
                        ->orderColumns(['name', 'description'], ':column $1')
                        ->rawColumns(['action', 'name'])
                        ->make(true);
        return $players;
    }

    public function autocompleteTeams(Request $request){

        $data = Teams::select("name", "id")
                    ->where("name","LIKE","%{$request->input('query')}%")
                    ->get();

        return response()->json($data);
    }

    public function allTeams(Request $request){
        
        $data = Players::select("name", "surname", "id")
                    ->where("team_id", "=", "{$request->input('id')}")
                    ->get();

        return response()->json($data);
    }

    public function initUpdatePlayers(Request $request){
        
        $data = PlayerInBroadcast::select("*")
                    ->where("id", "=", "{$request->input('id')}")
                    ->get();

        return response()->json($data);
    }

}
