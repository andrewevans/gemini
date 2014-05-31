<?php
// app/models/Artwork.php

class Artwork extends Eloquent
{
    public $timestamp = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'artworks';

    protected $guarded = [];

    public static $rules = array(
        'artist_id'     => 'required|numeric|min:0',
        'price'       => 'required|numeric|min:0',
        'title'       => 'required',
        'medium'       => 'required',
        'price_on_req'       => 'required|numeric|min:0|max:1',
        'sold'       => 'required|numeric|min:0|max:3',
        'onhold'       => 'required|numeric|min:0|max:1',
        'hidden'       => 'required|numeric|min:0|max:2',
    );

    public static $messages = [
        'title.required' => "You need a title for sure!",
    ];

    public function isValid($id = null)
    {
        $rules_modified = static::$rules;

        $validation = Validator::make($this->attributes, $rules_modified,  static::$messages);

        if ($validation->passes()) return true;

        $this->errors = $validation->messages();
        return false;
    }

    public function title_short()
    {
        if ($this->title_short == '') {
            return $this->title;
        }

        return $this->title_short;
    }

    public function medium_short()
    {
        if ($this->medium_short == '') {
            return $this->medium;
        }

        return $this->medium_short;
    }

    public function artist()
    {
        return $this->belongsTo('Artist');
    }


}