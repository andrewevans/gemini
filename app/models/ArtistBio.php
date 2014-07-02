<?php
// app/models/ArtistBio.php

class ArtistBio extends Eloquent
{
    public $timestamp = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'artists_bios';

    protected $guarded = [];

    public static $rules = array(
        'artist_id'     => 'required|numeric|min:0',
    );

    public static $messages = [
        'title.artist_id' => "You need a artist ID!",
    ];

    public function isValid($id = null)
    {
        $rules_modified = static::$rules;

        $validation = Validator::make($this->attributes, $rules_modified,  static::$messages);

        if ($validation->passes()) return true;

        $this->errors = $validation->messages();
        return false;
    }


    public function artist()
    {
        return $this->belongsTo('Artist');
    }


}