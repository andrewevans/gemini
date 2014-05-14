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

    protected $fillable = ['slug','first_name'];


    public static $rules = array(
        'slug'       => 'required',
        'first_name'      => 'required',
    );

    public static $messages = [
        'slug.required' => "You need a cost. No free lunches.",
    ];


}