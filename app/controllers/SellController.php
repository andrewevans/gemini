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

        $img_1 = Input::file('img_1_hardcount');
        $img_2 = Input::file('img_2_hardcount');
        $img_3 = Input::file('img_3_hardcount');

        $date_stamp = date("Y-m-d H:i:s");

        //$sell = new Sell;
        $this->sell->cust_email = Input::get('cust_email');
        $this->sell->cust_name = Input::get('cust_name');

        $this->sell->img_1_name = $this->sell->img_url($this->sell->cust_email . $date_stamp, 1);
        $this->sell->img_2_name = $this->sell->img_url($this->sell->cust_email . $date_stamp, 2);
        $this->sell->img_3_name = $this->sell->img_url($this->sell->cust_email . $date_stamp, 3);

        // resizing an uploaded file
        if ($img_1 != null) {
            $mime_type = $img_1->getClientOriginalExtension(); // unused
            $image['profile'] = Image::make($img_1->getRealPath())->resize(ARTIST_MAX_WIDTH, null, true, false)->resize(null, ARTIST_MAX_HEIGHT, true, false)->save($this->sell->img_1_name);
        }

        if ($img_2 != null) {
            $mime_type = $img_2->getClientOriginalExtension(); // unused
            $image['profile'] = Image::make($img_2->getRealPath())->resize(ARTIST_MAX_WIDTH, null, true, false)->resize(null, ARTIST_MAX_HEIGHT, true, false)->save($this->sell->img_2_name);
        }

        if ($img_3 != null) {
            $mime_type = $img_3->getClientOriginalExtension(); // unused
            $image['profile'] = Image::make($img_3->getRealPath())->resize(ARTIST_MAX_WIDTH, null, true, false)->resize(null, ARTIST_MAX_HEIGHT, true, false)->save($this->sell->img_3_name);
        }

        // Customer receipt
        Mail::send('emails.sell.receipt', $this->sell->toArray(), function($message)
        {
            $message->to($this->sell->cust_email, $this->sell['cust_name'])->replyTo('sell@masterworksfineart.com', 'Masterworks Fine Art Gallery Sales')->subject('Thank you for sending us your images, ' . $this->sell['cust_name'] . '!');
        });

        // To the boss man
        Mail::send('emails.sell.inquiry', $this->sell->toArray(), function($message)
        {
            $message->to('sell@masterworksfineart.com', $this->sell['cust_name'])->attach($this->sell['img_1_name'])->attach($this->sell['img_2_name'])->attach($this->sell['img_3_name'])->replyTo($this->sell['cust_email'], $this->sell['cust_name'])->subject('In response to the images you sent us, ' . $this->sell['cust_name'] . '!');
        });

        // To the henchmen
        Mail::send('emails.sell.inquiry', $this->sell->toArray(), function($message)
        {
            $message->to('aupusher@gmail.com', 'Records: sell inquiry')->attach($this->sell['img_1_name'])->attach($this->sell['img_2_name'])->attach($this->sell['img_3_name'])->subject('Inquiry, looking to sell from, ' . $this->sell['cust_name'] . '!');
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
