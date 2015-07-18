<?php
// app/models/Quotable.php

class Quotable extends Eloquent
{
    public $timestamp = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'quotables';

    protected $fillable = [
        'description',
        'author',
        'vibe',
        'quotable_date',
    ];

    public static $rules = array(
        'description'       => 'required',
    );

    public static $messages = [
        'description.required' => "A quotable description is required.",
    ];
}
