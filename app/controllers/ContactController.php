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

    public function newsletter()
    {
        $artists = Artist::all();
        $submited = false;

        if (! empty($_POST)) {

            $cust_info = array("email" => $_POST['cust_email'],
                "first_name" => $_POST['cust_first_name'],
                "last_name" => $_POST['cust_last_name']);

            if (isset($_POST['artists'])) {
                $lists = $_POST['artists'];
            } else
                $lists = [];

            $data_string = json_encode($cust_info);

            $api_call = 'http://www.appelfineart.com/api/v1/newsletter/' . $cust_info['email'] . '/' . $cust_info['first_name'] . '/' . $cust_info['last_name'] . '/' . implode(',', $lists);

            $ch = curl_init($api_call);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
            );

            $result = curl_exec($ch);
            $submited = true;
            return View::make('contact.newsletter', ['artists' => $artists, 'cust_info' => $cust_info, 'submitted' => $submited]);
        }

        return View::make('contact.newsletter', ['artists' => $artists, 'submitted' => $submited]);
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

        // Customer receipt
        Mail::send('emails.contact.receipt', $this->input, function($message)
        {
            $message->to($this->input['cust_email'], $this->input['cust_name'])->subject('Thank you for your inquiry, ' . $this->input['cust_name'] . '!');
        });

        // To the boss man
        Mail::send('emails.contact.inquiry', $this->input, function($message)
        {
            $message->to('robmasterworks@mailinator.com', $this->input['cust_name'])->subject('Thank you for your inquiry, ' . $this->input['cust_name'] . '!');
        });

        // To the henchmen
        Mail::send('emails.contact.inquiry', $this->input, function($message)
        {
            $message->to('apbmasterworks@mailinator.com', $this->input['cust_name'])->subject('Thank you for your inquiry, ' . $this->input['cust_name'] . '!');
        });

        if ($this->input['cust_newsletter'] == '1') {
            $url = '/api/v1/newsletter/' . $this->input['cust_email'];

            $ch = curl_init( $url );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt( $ch, CURLOPT_HEADER, 0);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec( $ch );
        }

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
