<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ServiceFilterItems{

    private static $SORT_TYPE = [
        'new-items',
        'old-items',
        'alphabet-start',
        'alphabet-end'
    ];

    public static function filter($class, $settings, $column, $with){

        if(empty($settings)) { return $class::with($with)->paginate(9); }

        $config = self::get_config($settings);

        if($config){

            $condition = array();
            foreach ($config as $key => $value) {
                array_push($condition, $value);
            }
            return self::paginate(
                self::sort(
                    $class::whereIn($column, $condition)
                            ->with($with)
                            ->get(),
                    $settings['sort'] ?? self::$SORT_TYPE[0]
                ),
                9
            );

        }else{
            return self::paginate(
                self::sort(
                    $class::with($with)->get(),
                    $settings['sort'] ?? self::$SORT_TYPE[0]
                ),
                9
            );
        }
    }

    private static function sort($items, $sort){
        if(self::sort_check($sort)){
            $new_items = collect([]);
            switch ($sort) {
                case 'new-items':
                    $new_items = $items->SortBy('created_at');
                    break;
                case 'old-items':
                    $new_items = $items->SortByDesc('created_at');
                    break;
                case 'alphabet-start':
                    $new_items = $items->SortBy('name');
                    break;
                case 'alphabet-end':
                    $new_items = $items->SortByDesc('name');
                    break;
                default:
                    # code...
                    break;
            }
            return $new_items;
        }else{
            return $items;
        }
    }

    private static function sort_check($sort) :bool{

        return in_array($sort, self::$SORT_TYPE);

    }

    public static function get_config($config){

        $new_config = $config;
        if(array_key_exists('page', $config)){
            unset($new_config['page']);
        }if(array_key_exists('sort', $config)){
            unset($new_config['sort']);
        }
        return $new_config;
    }

    private static function paginate($items, $perPage = 15, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage),
                                        $items->count(),
                                        $perPage,
                                        $page,
                                        $options);
    }
}
