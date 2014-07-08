<?php
// app/models/Page.php

class Page extends Eloquent
{
    public $timestamp = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pages';

    protected $fillable = [];


    public static $rules = [];

    public static $messages = [];

    public function isValid($id = null)
    {

        $validation = Validator::make($this->attributes, static::$rules,  static::$messages);

        if ($validation->passes()) return true;

        $this->errors = $validation->messages();
        return false;
    }

    public function url()
    {
        return 'dog';
    }

}