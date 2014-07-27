<?php
// app/models/Sell.php

class Sell extends Eloquent
{
    public $timestamp = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sells';

    protected $fillable = ['cust_email', 'cust_name', 'cust_inquiry'];

    public $img = [];

    public static $rules = array(
        'cust_email'       => 'required|email',
        'cust_inquiry'       => 'required',
    );

    public static $messages = [
        'cust_email.required' => "You need an email address!",
        'cust_email.email' => "Uho, that's not a valid email address.",
        'cust_inquiry.required' => "You need an inquiry.",
    ];

    public function isValid($id = null)
    {

        $validation = Validator::make($this->attributes, static::$rules,  static::$messages);

        if ($validation->passes()) return true;

        $this->errors = $validation->messages();
        return false;
    }

    public function img_url($img_name, $key = null)
    {
        $extension = 'jpg';
        $img_num_av = '';

        if ($key != null) $img_num_av = '_' . $key;

        return $local_file = $this->img_directory_url() . '/' . $img_name . $img_num_av . '.' . $extension;
    }


    public function img_directory_url()
    {
        return 'uploads';
    }


}