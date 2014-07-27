<?php
// app/models/Splash.php

class Splash extends Eloquent
{
    public $timestamp = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'splashes';

    protected $fillable = ['id', 'location_slug', 'destination_url', 'asset_url', 'title', 'description', 'position'];


    public static $rules = array(
        'asset_url'       => 'required',
        'title'           => 'required',
    );

    public static $messages = [
        'asset_url.required' => "What image to show?",
        'title.required' => "Title is required.",
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