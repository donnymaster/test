<?php

namespace App\Services;

class ServiceYoutube{

    private const API_URL = [
        'videos.list' => 'https://www.googleapis.com/youtube/v3/videos'
    ];

    public const BROADCAST_LIVE = "live";
    public const BROADCAST_NONE = "none";
    public const BROADCAST_UPCOMING = "upcoming";

    private const API_KEY = 'AIzaSyAUaRQdaiwT83La2mYEU3NjWb4oqQw2p0k';


    public static function getStatusBroadcast($url_video){

        $info = self::getVideoInfo(self::getId($url_video));

        if($info == false) { return false; } // удалено или скрыто

        $status = $info->snippet->liveBroadcastContent;
        $video_status = "";

        switch ($status) {
            case self::BROADCAST_NONE:
                $video_status = "закінчилася";
                break;

            case self::BROADCAST_UPCOMING:
                $video_status = "в майбутньому";
                break;

            case self::BROADCAST_LIVE:
                $video_status = "у прямому ефірі";
                break;
        }

        return $video_status;
    }

    public static function getContainerVideo($url_video){

        $info = self::getVideoInfo(self::getId($url_video));

        return $info->player;
    }

    public static function getCoverVideo($url_video){

        $info = self::getVideoInfo(self::getId($url_video));

        if($info == false) { return false; } // удалено или скрыто

        $data = json_decode(json_encode($info), true);

        if(array_key_exists('maxres', $data['snippet']['thumbnails'])){
            return $data['snippet']['thumbnails']['maxres']['url'];
        }
        if(array_key_exists('standard', $data['snippet']['thumbnails'])){
            return $data['snippet']['thumbnails']['standard']['url'];
        }
        if(array_key_exists('high', $data['snippet']['thumbnails'])){
            return $data['snippet']['thumbnails']['high']['url'];
        }

        return 'non-avatar';

    }

    public static function getClasBroadcast($status){

        $class = "";

        switch ($status) {
            case 'закінчилася':
                $class = 'badge badge-pill badge-warning';
                break;
            case 'в майбутньому':
                $class = 'badge badge-pill badge-info';
                break;
            case 'у прямому ефірі':
                $class = 'badge badge-pill badge-success';
                break;
        }

        return $class;

    }

    public static function getStatusVideo($url_video){

        $info = self::getVideoInfo(self::getId($url_video));

        if($info == false) { return false; }

        return true;
    }

    public static function getId($str_video){

        $video = array();

        parse_str( parse_url( $str_video, PHP_URL_QUERY ), $video );

        if(array_key_exists('v', $video)){
            return $video['v'];
        }
        return '';
    }

    public static function getVideoInfo($vId, $part = ['id', 'snippet', 'contentDetails', 'player', 'statistics', 'status'])
    {
        $API_URL = self::API_URL['videos.list'];
        $params = [
            'id' => is_array($vId) ? implode(',', $vId) : $vId,
            'key' => self::get_key(),
            'part' => implode(', ', $part),
        ];

        $apiData = self::api_get($API_URL, $params);

        if (is_array($vId)) {
            return self::decodeMultiple($apiData);
        }

        return self::decodeSingle($apiData);
    }

    private static function get_key(){

        return self::API_KEY;

    }


    private static function api_get($url, $params)
    {
        //set the youtube key
        $params['key'] = self::get_key();

        //boilerplates for CURL
        $tuCurl = curl_init();
        curl_setopt($tuCurl, CURLOPT_URL, $url . (strpos($url, '?') === false ? '?' : '') . http_build_query($params));
        if (strpos($url, 'https') === false) {
            curl_setopt($tuCurl, CURLOPT_PORT, 80);
        } else {
            curl_setopt($tuCurl, CURLOPT_PORT, 443);
        }

        curl_setopt($tuCurl, CURLOPT_RETURNTRANSFER, 1);
        $tuData = curl_exec($tuCurl);
        if (curl_errno($tuCurl)) {
            throw new \Exception('Curl Error : ' . curl_error($tuCurl));
        }

        return $tuData;
    }

    private static function decodeSingle(&$apiData)
    {
        $resObj = json_decode($apiData);
        if (isset($resObj->error)) {
            $msg = "Error " . $resObj->error->code . " " . $resObj->error->message;
            if (isset($resObj->error->errors[0])) {
                $msg .= " : " . $resObj->error->errors[0]->reason;
            }

            throw new \Exception($msg);
        } else {
            $itemsArray = $resObj->items;
            if (!is_array($itemsArray) || count($itemsArray) == 0) {
                return false;
            } else {
                return $itemsArray[0];
            }
        }
    }

    private static function decodeMultiple(&$apiData)
    {
        $resObj = json_decode($apiData);
        if (isset($resObj->error)) {
            $msg = "Error " . $resObj->error->code . " " . $resObj->error->message;
            if (isset($resObj->error->errors[0])) {
                $msg .= " : " . $resObj->error->errors[0]->reason;
            }

            throw new \Exception($msg);
        } else {
            $itemsArray = $resObj->items;
            if (!is_array($itemsArray)) {
                return false;
            } else {
                return $itemsArray;
            }
        }
    }


}
