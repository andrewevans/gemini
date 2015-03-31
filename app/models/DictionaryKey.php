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
    public static function get_artist($source, $key)
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


    /**
     * Map a foreign Artworks to create destination Artwork properties.
     * (Currently assumes destination is Gemini)
     *
     * @param  string $source
     * @param  Artist $artist
     * @return Array Artwork
     */
    public static function get_artworks($source, Artist $artist)
    {
        $artwork = new Artwork;
        $artwork->setConnection('mysql_calder');

        switch ($source) {
            case DB_CALDER:
                $artworks_external = $artwork->whereRaw('aId = ' . $artist->id)
                    ->where('sold', '!=', '1')
                    ->where('hidden', '!=', 1)
                    ->orderBy('id', 'desc')->get();
                $artworks = [];

                foreach ($artworks_external as $artwork_external) {
                    $artwork = new Artwork;
                    $artwork->id = $artwork_external->id;
                    $artwork->artist_id = $artwork_external->aId;
                    $artwork->catref_id = null;
                    $artwork->price = $artwork_external->price;
                    $artwork->title = $artwork_external->title;
                    $artwork->title_short = $artwork_external->title_short;
                    $artwork->series = $artwork_external->series;
                    $artwork->series_short = $artwork_external->series;
                    $artwork->medium = $artwork_external->medium;
                    $artwork->medium_short = $artwork_external->medium_short;
                    $artwork->edition = $artwork_external->edition;
                    $artwork->edition_short = $artwork_external->edition_short;
                    $artwork->after = $artwork_external->after;
                    $artwork->signature = $artwork_external->signature;
                    $artwork->condition = $artwork_external->external;
                    $artwork->size_img = $artwork_external->imgsize;
                    $artwork->size_sheet = $artwork_external->sheetsize;
                    $artwork->size_framed = $artwork_external->framedsize;
                    $artwork->tagline = $artwork_external->tagline;
                    $artwork->reference = null;
                    $artwork->price_on_req = $artwork_external->priceonrequest;
                    $artwork->sold = $artwork_external->sold;
                    $artwork->hidden = $artwork_external->hidden;
                    $artwork->onhold = $artwork_external->onhold;

                    $artworks[] = $artwork;
                }
                break;

            default:
                break;
        }

        return $artworks;
    }
}

