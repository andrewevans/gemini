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
}