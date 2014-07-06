<?php

class SellController extends \BaseController {

    protected $sell;

    public function __construct(Sell $sell)
    {
        $this->sell = $sell;
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('sell.index');
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $this->input = Input::all();

        if ( ! $this->sell->fill($this->input)->isValid())
        {
            return Redirect::back()->withInput()->withErrors($this->sell->errors);
        }

        // Customer receipt
        Mail::send('emails.sell.receipt', $this->input, function($message)
        {
            $message->to($this->input['cust_email'], $this->input['cust_name'])->subject('Thank you for your purchase, ' . $this->input['cust_name'] . '!');
        });

        // To the boss man
        Mail::send('emails.sell.inquiry', $this->input, function($message)
        {
            $message->to('robmasterworks@mailinator.com', $this->input['cust_name'])->subject('Thank you for your purchase, ' . $this->input['cust_name'] . '!');
        });

        // To the henchmen
        Mail::send('emails.sell.inquiry', $this->input, function($message)
        {
            $message->to('apbmasterworks@mailinator.com', $this->input['cust_name'])->subject('Thank you for your purchase, ' . $this->input['cust_name'] . '!');
        });


        Session::flash('message', 'Successfully sent inquiry!');
        return Redirect::to('sell');
    }


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
