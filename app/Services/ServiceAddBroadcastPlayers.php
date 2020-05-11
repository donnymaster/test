<?php

namespace App\Services;

use App\PlayerInBroadcast;

class ServiceAddBroadcastPlayers{
    public static function add($array)
    {
        $result = self::array_to_arrays($array);
        
        $obj = PlayerInBroadcast::create([
            'team_1_players' => $result[0],
            'team_2_players' => $result[1]
        ]);

        return $obj->id;
        
    }

    public static function update($array, $id){
        $players = PlayerInBroadcast::where('id', '=', $id)->first();

        $result = self::array_to_arrays($array);

        $players->update([
            'team_1_players' => $result[0],
            'team_2_players' => $result[1]
        ]);
    }

    public static function array_to_arrays($array){
        $team_1 = array();
        $team_2 = array();
        // players_team_1_0
        $team_1 = array_filter($array, function($key){
            return preg_match("/^players_team_1_\d+$/", $key);
        }, ARRAY_FILTER_USE_KEY);

        $team_2 = array_filter($array, function($key){
            return preg_match("/^players_team_2_\d+$/", $key);
        }, ARRAY_FILTER_USE_KEY);
       
        $json_team_1 = self::get_json($team_1);

        $json_team_2 = self::get_json($team_2);  

        return array($json_team_1, $json_team_2);
    }

    public static function get_json($array)
    {

        if($array === array()) { return null; }

        $json_team = "[";

        foreach ($array as $value) {
            $json_team .= $value . ',';
        }
       
        $json_team = substr($json_team, 0, -1);

        $json_team .= "]";

        return $json_team;
    }
}