<?php

namespace App\Http\Controllers;

// use Alaouy\Youtube\Facades\Youtube;
use Alaouy\Youtube\Youtube;
use App\Broadcast;
use App\Charts\ViewTypeSport;
use Illuminate\Http\Request;
use App\Services\ServiceYoutube;
use ConsoleTVs\Charts\Classes\C3\Chart;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $broadcasts = Broadcast::with(['kind_sport'])->limit(3)->get();

        return view('user-side.index', compact('broadcasts'));
    }
}
