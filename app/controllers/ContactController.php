<?php

class ContactController extends \BaseController {

    protected $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
        return View::make('contact.index');
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
		//
        $this->input = Input::all();

        if ( ! $this->contact->fill($this->input)->isValid())
        {
            return Redirect::back()->withInput()->withErrors($this->contact->errors);
        }

        Mail::send('emails.contact.inquiry', $this->input, function($message)
        {
            $message->to($this->input['cust_email'], $this->input['cust_name'])->subject('Thank you, ' . $this->input['cust_name'] . '!');
        });

        Session::flash('message', 'Successfully sent inquiry!');
        return Redirect::to('contact');
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
        return View::make('emails.contact.inquiry');
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
