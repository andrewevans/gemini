<?php
// app/models/ArtworkDescription.php

class ArtworkDescription extends Eloquent
{
    public $timestamp = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'artworks_descriptions';

    protected $guarded = [];

    public static $rules = array(
        'artwork_id'     => 'required|numeric|min:0',
    );

    public static $messages = [
        'artwork_id' => "You need a artwork ID!",
    ];

    public function isValid($id = null)
    {
        $rules_modified = static::$rules;

        $validation = Validator::make($this->attributes, $rules_modified,  static::$messages);

        if ($validation->passes()) return true;

        $this->errors = $validation->messages();
        return false;
    }


    public function artwork()
    {
        return $this->belongsTo('Artwork');
    }


}