<?php

class Filterby {

    public static function sort($sort_value)
    {
        switch ($sort_value) {
            case 'high':
                $sortBy['value'] = 'high';
                $sortBy['orderBy'] = 'price DESC';
                $sortBy['name'] =  SORT_HIGH;
                break;
            case 'low':
                $sortBy['value'] = 'low';
                $sortBy['orderBy'] = 'price ASC';
                $sortBy['name'] = SORT_LOW;
                break;
            case 'new':
                $sortBy['value'] = 'new';
                $sortBy['orderBy'] = 'id DESC';
                $sortBy['name'] = SORT_NEW;
                break;
            case 'featured':
            default:
                $sortBy['value'] = 'featured';
                $sortBy['orderBy'] = 'RAND()';
                $sortBy['name'] = SORT_FEATURED;
                break;
        }

        return $sortBy;
    }


    public static function sortList()
    {
        $params = Input::all();

        $sortList['high']['value'] = $params['sort'] = 'high';
        $sortList['high']['orderBy'] = 'price DESC';
        $sortList['high']['name'] =  SORT_HIGH;
        $sortList['high']['current_url'] = URL::to(URL::current() . '?' . http_build_query($params));

        $sortList['low']['value'] = $params['sort'] = 'low';
        $sortList['low']['orderBy'] = 'price ASC';
        $sortList['low']['name'] = SORT_LOW;
        $sortList['low']['current_url'] = URL::to(URL::current() . '?' . http_build_query($params));

        $sortList['new']['value'] = $params['sort'] = 'new';
        $sortList['new']['orderBy'] = 'id DESC';
        $sortList['new']['name'] = SORT_NEW;
        $sortList['new']['current_url'] = URL::to(URL::current() . '?' . http_build_query($params));

        $sortList['featured']['value'] = $params['sort'] = 'featured';
        $sortList['featured']['orderBy'] = 'RAND()';
        $sortList['featured']['name'] = SORT_FEATURED;
        $sortList['featured']['current_url'] = URL::to(URL::current() . '?' . http_build_query($params));

        return $sortList;
    }
}

