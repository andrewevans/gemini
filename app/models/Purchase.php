<?php
// app/models/Purchase.php

class Purchase extends Eloquent
{
    public $timestamp = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'purchases';

    protected $fillable = ['cust_name', 'cust_email', 'cust_phone', 'cust_address', 'cust_country'];


    public static $rules = array(
        'cust_name'       => 'required',
        'cust_email'       => 'required|email',
        'cust_phone'       => 'required',
        'cust_address'       => 'required',
        'cust_country'       => 'required',
    );

    public static $messages = [
        'cust_name.required' => "Your name is required!",
        'cust_email.required' => "Your email is required!",
        'cust_email.email' => "Uho, that's not a valid email address.",
        'cust_phone.required' => "Your phone number is required!",
        'cust_address.required' => "Your shipping address is required!",
        'cust_country.required' => "Your country number is required!",
    ];

    public function isValid($id = null)
    {

        $validation = Validator::make($this->attributes, static::$rules,  static::$messages);

        if ($validation->passes()) return true;

        $this->errors = $validation->messages();
        return false;
    }

    public static function checkRedirect($routeName)
    {
        switch (Config::get('app.db_source')) {
            case DB_CALDER:
                switch ($routeName) {
                    case 'offer.index':
                        return Redirect::to('http://www.masterworksfineart.com/inventory/best-offer-large.php?i=' . Input::get('artwork_id'), 302);
                        break;

                    case 'purchase.index':
                        return Redirect::to('http://www.masterworksfineart.com/inventory/purchase-large.php?i=' . Input::get('artwork_id'), 302);
                        break;
                }
                break;

            default:
                break;
        }

        return false;
    }
}