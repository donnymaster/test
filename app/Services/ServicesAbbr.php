<?php

namespace App\Services;

class ServicesAbbr{

    public static function abbreviate( $longname )
    {
        $letters=array();
        $words=explode(' ', $longname);

        foreach($words as $word)
        {
            $word = (mb_substr($word, 0, 1));
            array_push($letters, $word);
        }

        $shortname = mb_strtoupper(implode($letters));

        return $shortname;
    }


}
