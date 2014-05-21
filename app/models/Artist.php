<?php
// app/models/Artist.php

class Artist extends Eloquent
{
    public $timestamp = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'artists';

    protected $fillable = ['slug', 'alias', 'first_name', 'last_name', 'url_slug', 'meta_title', 'meta_description', 'year_begin', 'year_end'];


    public static $rules = array(
        'first_name'       => 'required',
        'last_name'       => 'required',
        'alias'       => 'required',
        'slug'       => 'required',
        'url_slug'       => 'required',
        'year_begin'      => 'required|numeric|min:0',
        'year_end'      => 'required|numeric|min:0',
    );

    public static $messages = [
        'slug.required' => "You need a slug.",
    ];

    public function isValid($id = null)
    {
        $rules_modified = static::$rules;

        $validation = Validator::make($this->attributes, $rules_modified,  static::$messages);

        if ($validation->passes()) return true;

        $this->errors = $validation->messages();
        return false;
    }

    public function artworks()
    {
        return $this->hasMany('Artwork');
    }


}