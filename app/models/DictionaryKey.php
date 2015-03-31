<?php
// app/models/DictionaryKey.php

class DictionaryKey extends Eloquent
{
    public $timestamp = false;

    protected $guarded = [];

    public static $rules = array(
        'id'     => 'required',
        'source'    => 'required',
        'destination'   => 'required',
        'source_key'    => 'required',
        'destination_key'   => 'required',
    );

    /**
     * Map a foreign Artist table key to its destination table key,
     * and maps to create destination Artist. (Currently assumes destination
     * is Gemini)
     *
     * @param  string $source
     * @param  string $key
     * @return Artist
     */
    public static function getArtist($source, $key)
    {
        $artist = new Artist;
        $artist->setConnection('mysql_calder');

        switch ($source) {
            case DB_CALDER:
                $artist_external = $artist->whereFoldername($key)->first();
                $artist->id = $artist_external->aName;
                $artist->slug = $artist_external->folderName;
                $artist->alias = $artist_external->fName . ' ' . $artist_external->lName;
                $artist->first_name = $artist_external->fName;
                $artist->last_name = $artist_external->lName;
                $artist->url_slug = $artist_external->folderName;
                $artist->genre = $artist_external->genre;
                $artist->meta_title = $artist_external->metatitle;
                $artist->meta_description = $artist_external->metadesc;
                $artist->year_begin = $artist_external->yearBegin;
                $artist->year_end = $artist_external->yearEnd;
                break;

            default:
                break;
        }

        return $artist;
    }
}