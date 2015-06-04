<?php
// app/models/Url.php

class Url extends Eloquent
{
    public $timestamp = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'urls';

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


    public function editContact($cust_info, $existing_email)
    {
        $contact = $existing_email;
        $contact->first_name = $cust_info['first_name'];
        $contact->last_name = $cust_info['last_name'];

        return $contact;
    }


    public function createContact($cust_info)
    {
        try {
            $contact = new \Ctct\Components\Contacts\Contact();
            $contact->addEmail($cust_info['cust_email']);
            $contact->first_name = $cust_info['first_name'];
            $contact->last_name = $cust_info['last_name'];
            $contact->addList('2105231740'); // add to 'general' list

            // catch any exceptions thrown during the process and print the errors to screen
        } catch (CtctException $ex) {
            echo '<span class="label label-important">Error</span>';
            echo '<div class="container alert-error"><pre class="failure-pre">';
            print_r($ex->getErrors());
            echo '</pre></div>';
            die();
        }

        return $contact;
    }

    public function createList($list_name)
    {
        $new_list = new \Ctct\Components\Contacts\ContactList();
        $new_list->name = $list_name;
        $new_list->status = 'ACTIVE';

        return $new_list;
    }


    /*
     * Generates an SEO-optimized artwork title under 80 characters
     */
    public static function getTitleSEO(Artwork $artwork)
    {
        $title = $artwork->artist->inverted_alias(true) . ', ' . $artwork->medium_short() . ', ' . $artwork->title_short();

        if (sizeof($title) >= 80) {
            $title = $artwork->artist->inverted_alias(true) . ', ' . $artwork->mediums() . ', ' . $artwork->title_short();
        }

        if (sizeof($title) >= 80) {
            $title = $artwork->artist->inverted_alias(true) . ', ' . $artwork->title_short();
        }

        if (sizeof($title) >= 80) {
            $title = $artwork->title_short();
        }

        return trim($title);
    }

}