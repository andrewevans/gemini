<?php

class Tools {

    // My common functions
    public static function somethingOrOther()
    {
        return (mt_rand(1,2) == 1) ? 'something' : 'other';
    }

    /*
     * Method to strip tags globally.
     */
    public static function global_xss_clean()
    {
        // Recursive cleaning for array [] inputs, not just strings.
        $sanitized = static::array_strip_tags(Input::get());
        Input::merge($sanitized);
    }

    public static function array_strip_tags($array)
    {
        $result = array();

        foreach ($array as $key => $value) {
            // Don't allow tags on key either, maybe useful for dynamic forms.
            $key = strip_tags($key);

            // If the value is an array, we will just recurse back into the
            // function to keep stripping the tags out of the array,
            // otherwise we will set the stripped value.
            if (is_array($value)) {
                $result[$key] = static::array_strip_tags($value);
            } else {
                // I am using strip_tags(), you may use htmlentities(),
                // also I am doing trim() here, you may remove it, if you wish.
                $result[$key] = trim(strip_tags($value));
            }
        }

        return $result;
    }

    public static function artworks_previous()
    {
        $artworks_previous_array = unserialize(Session::get('artworks_previous', ''));
        if (! is_array($artworks_previous_array)) $artworks_previous_array = [];

        $artworks_previous = [];

        foreach ($artworks_previous_array as $artwork_previous) {
            $artwork_previous = Artwork::whereId($artwork_previous)->whereSold(0)->whereHidden(0)->first();

            if ($artwork_previous != null) $artworks_previous[] = $artwork_previous;
        }

        return array_slice(array_reverse($artworks_previous), 0, 3);
    }

    public static function artists_previous()
    {
        $artists_previous_array = unserialize(Session::get('artists_previous'));
        if (! is_array($artists_previous_array)) $artists_previous_array = [];

        $artists_previous = [];

        foreach ($artists_previous_array as $artist_previous) {
            $artist_previous = Artist::whereId($artist_previous)->first();

            if ($artist_previous != null) $artists_previous[] = $artist_previous;
        }

        return array_slice(array_reverse($artists_previous), 0, 3);
    }

}

