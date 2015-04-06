<?php

class PurchaseController extends \BaseController {

    protected $purchase;

    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id = null)
	{
        $input = Input::all();
        $route = Route::current()->getName();

        $redirect = Purchase::checkRedirect($route);
        if ($redirect) return $redirect;

        $artwork = Artwork::find($input['artwork_id']);
        $artworks = [];
        $artworks[] = $artwork;

        if ('offer.index' == $route) {
            $page_title = "Your Offer for " . $artwork->title_short();
            return View::make('widgets.forms.offer', ['id' => $input['artwork_id'], 'artworks' => $artworks, 'route' => $route, 'page_title' => $page_title]);
        } else {
            $page_title = "Purchasing " . $artwork->title_short();
            return View::make('widgets.forms.purchase', ['id' => $input['artwork_id'], 'artworks' => $artworks, 'route' => $route, 'page_title' => $page_title]);
        }
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

        if ( ! $this->purchase->fill($this->input)->isValid())
        {
            return Redirect::back()->withInput()->withErrors($this->purchase->errors);
        }

        $this->input['artwork'] = Artwork::find($this->input['artwork_id']);


        // Customer receipt
        Mail::send('emails.purchase.receipt', $this->input, function($message)
        {
            $message->to($this->input['cust_email'], $this->input['cust_name'])->subject('Thank you for your purchase, ' . $this->input['cust_name'] . '!');
        });

        // To the boss man
        Mail::send('emails.purchase.inquiry', $this->input, function($message)
        {
            $message->to('robmasterworks@mailinator.com', $this->input['cust_name'])->subject('Thank you for your purchase, ' . $this->input['cust_name'] . '!');
        });

        // To the henchmen
        Mail::send('emails.purchase.inquiry', $this->input, function($message)
        {
            $message->to('apbmasterworks@mailinator.com', $this->input['cust_name'])->subject('Thank you for your purchase, ' . $this->input['cust_name'] . '!');
        });

        Session::flash('message', 'Successfully sent purchase inquiry!');
        return Redirect::back();
    }


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id = null)
	{
        //
        return View::make('emails.purchase.inquiry');
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
