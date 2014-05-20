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
        'title'       => 'required',
        'price'       => 'required|numeric|min:0',
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


}