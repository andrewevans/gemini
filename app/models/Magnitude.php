<?php
// app/models/Magnitude.php

class Magnitude extends Eloquent
{
    public $timestamp = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'object_importance';

    protected $fillable = ['id', 'object_type', 'object_id', 'magnitude'];


    public static $rules = array(
        'object_type'       => 'required',
        'object_id'       => 'required',
    );

    public static $messages = [
        'object_type.required' => "What object type is it?",
        'object_id.required' => "What object ID is it?",
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