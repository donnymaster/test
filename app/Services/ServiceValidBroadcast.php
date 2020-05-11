<?php

namespace App\Services;

use Illuminate\Support\Str;

class ServiceValidBroadcast{

    public static function valid($request, $create = false){

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|min:6|max:2000',
            'kind_sport_id' => 'required|exists:kind_sports,id',
            'url_video' => 'required',
            'team_id_1' => 'required|exists:teams,id',
            'team_id_2' => 'required|exists:teams,id',
            'video_start_date' => 'required',
            'video_start_time' => 'required'
        ]);

        if(!ServiceYoutube::getStatusVideo($validatedData['url_video'])){
            return back()->with('error', 'Відео недоступне! Виберете інше відео.');
        }

        $validatedData['video_start_date'] = \Carbon\Carbon::parse($validatedData['video_start_date'])->format('Y-m-d');
        $validatedData['logo'] = ServiceYoutube::getCoverVideo($validatedData['url_video']);
        $validatedData['status'] = ServiceYoutube::getStatusBroadcast($validatedData['url_video']);

        if($create)
        {
            $validatedData['identifier'] = Str::uuid();
        }

        return $validatedData;

    }
}
