<?php

require_once '../vendor/constantcontact/constantcontact/src/Ctct/autoload.php';

use Ctct\ConstantContact;
use Ctct\Components\Contacts\Contact;
use Ctct\Components\Contacts\ContactList;
use Ctct\Components\Contacts\EmailAddress;
use Ctct\Exceptions\CtctException;
use DTS\eBaySDK\Constants;
use DTS\eBaySDK\Finding\Services as FindingServices;
use DTS\eBaySDK\Finding\Types as FindingTypes;
use DTS\eBaySDK\Trading\Services as TradingServices;
use DTS\eBaySDK\Trading\Types as TradingTypes;
use DTS\eBaySDK\Trading\Enums as TradingEnums;
use \DTS\eBaySDK\Trading;
use \DTS\eBaySDK\FileTransfer;

define("APIKEY", "g7rbwgf9xzygfhneax9j3j4w");
define("ACCESS_TOKEN", "99b48825-3ded-4ccc-b416-0d19502f0751");


class UrlController extends Controller {

    protected $artist;
    protected $artwork;
    protected $catalogue;
    protected $catref;
    protected $url;

    public function __construct(Artist $artist, Artwork $artwork, Catalogue $catalogue, Catref $catref, Url $url)
    {
        $this->artist = $artist;
        $this->artwork = $artwork;
        $this->catalogue = $catalogue;
        $this->catref =$catref;
        $this->cc = new ConstantContact(APIKEY);
        $this->url = $url;
        //$this->beforeFilter('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return View::make('url.index');
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
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($data)
	{
        if (! Auth::check() && Str::lower(Input::get('secret')) != 'dog') {
            return Response::json([], 200);
        }

        $term = Str::lower(Input::get('term'));
        $return_array = array();

        switch ($data) {
            case 'artists':
                $artists = $this->artist->orderBy('last_name', 'asc')->get();

                foreach ($artists as $artist) {
                    $return_array[] = array(
                        'value' => $artist->alias,
                        'first_name' => $artist->first_name,
                        'last_name' => $artist->last_name,
                        'url_slug' => $artist->url_slug,
                        'meta_title' => $artist->meta_title,
                        'meta_description' => $artist->meta_description,
                        'year_begin' => $artist->year_begin,
                        'year_end' => $artist->year_end,
                        //'img_url' => $artist->img_url(),
                        'guid' => 'a-' . $artist->id,
                        'id' => $artist->id);
                }
                break;

            case 'artists_descriptions':

                $artists = Artist::all();

                foreach ($artists as $artist) {

                    $args = array(
                        'category_name'    => $artist->url_slug . '-artist-biography',
                        'post_type'        => 'page',
                        'orderby'          => 'post_date',
                        'order'            => 'DESC',
                        'post_status'      => 'publish',
                        'suppress_filters' => true );

                    $biographies = get_posts( $args );

                    $artist->artist_id = $artist->id;

                    $artist_biographies = array();

                    if (sizeof($biographies)) {

                        foreach ($biographies as $key => $biography) {
                            $artist_biographies[$key]['title'] = $biography->post_title;
                            $artist_biographies[$key]['content'] = apply_filters('the_content',$biography->post_content);

                            $post_categories = wp_get_post_categories($biography->ID);

                            foreach ($post_categories as $post_category) {
                                $post_category = get_category($post_category);

                                if ($post_category->slug == $artist->url_slug . '-artist-biography') {
                                    $post_category->slug = 'artist-biography';
                                }

                                $artist_biographies[$key]['categories'][] = str_replace('-' . $artist->url_slug . '-artist-biography', '', $post_category->slug);
                            }
                        }

                        $artist->biographies = $artist_biographies;
                    }

                    $return_array[] = array(
                        'id' => $artist->id,
                        'biography' => $artist->biographies,
                    );
                }

                break;

            case 'artworks_descriptions':

                $artworks_descriptions = ArtworkDescription::get();

                foreach ($artworks_descriptions as $artwork_description) {
                    $return_array[] = array(
                        'id' => $artwork_description->artwork_id,
                        '$artwork_description' => $artwork_description->description
                    );
                }

                break;

            case 'artworks':
                $artworks = $this->artwork
                    ->whereIn('artist_id', function($query)
                    {
                        $query->select('id')
                            ->from('artists')
                            ->whereRaw('id != 0');
                    })->whereSold(0)->whereHidden(0)->orderBy('id', 'DESC')->get();

                foreach ($artworks as $artwork) {
                    $artwork_json = array(
                        'value' => html_entity_decode($artwork->title_short),
                        'title' => $artwork->title,
                        'price' => $artwork->price,
                        'medium' => $artwork->medium,
                        'medium_short' => $artwork->medium_short(),
                        'series' => $artwork->series,
                        'series_short' => $artwork->series_short,
                        'after' => $artwork->after,
                        'signature' => $artwork->signature,
                        'condition' => $artwork->condition,
                        'size_img' => $artwork->size_img,
                        'size_sheet' => $artwork->size_sheet,
                        'size_framed' => $artwork->size_framed,
                        'tagline' => $artwork->tagline,
                        'reference' => $artwork->reference,
                        'framing' => $artwork->framing,
                        'sold' => $artwork->sold,
                        'hidden' => $artwork->hidden,
                        'on_hold' => $artwork->on_hold,
                        'price_on_req' => $artwork->price_on_req,
                        'url' => 'http://' . $_SERVER['HTTP_HOST'] . $artwork->url(),
                        'mfa_img_url' => 'http://www.masterworksfineart.com/inventory/' . $artwork->artist->slug . '/original/' . $artwork->artist->slug . $artwork->id . '.jpg',
                        'mfa_img_thumb_url' => 'http://www.masterworksfineart.com/inventory/' . $artwork->artist->slug . '/prev_' . $artwork->artist->slug . $artwork->id . '.jpg',
                        'artist_id' => $artwork->artist_id,
                        'guid' => 'w-' . $artwork->id,
                        'id' => $artwork->id);

                    if (Input::get('params')) {
                        $params = explode(',', Input::get('params'));

                        if (in_array('desc', $params)) {
                            $artwork_description = ArtworkDescription::whereArtworkId($artwork->id)->first();

                            if ($artwork_description) {
                                $artwork_json['artwork_description'] = $artwork_description->description;
                            } else {
                                $artwork_json['artwork_description'] = '';
                            }
                        }
                    }

                    $return_array[] = $artwork_json;
                }
                break;

            case 'catalogues':
                $catalogues = $this->catalogue->whereIn('artist_id', function ($query) {
                    $query->select('id')
                        ->from('artists')
                        ->whereRaw('id != 0');
                })->orderBy('id', 'DESC')->get();;

                foreach ($catalogues as $catalogue) {
                    $return_array[] = array(
                        'value' => $catalogue->title,
                        'artist_id' => $catalogue->artist_id,
                        'slug' => $catalogue->slug,
                        'url_slug' => $catalogue->url_slug,
                        'meta_description' => $catalogue->meta_description,
                        'guid' => 'c-' . $catalogue->id,
                        'id' => $catalogue->id);
                }
                break;

            case 'catrefs':
                $catrefs = $this->catref
                    ->whereIn('catalogue_id', function($query)
                    {
                        $query->select('id')
                            ->from('catalogues')
                            ->whereIn('artist_id', function($query)
                            {
                                $query->select('id')
                                    ->from('artists')
                                    ->whereRaw('id != 0');
                            });
                    })->orderBy('id', 'DESC')->get();

                foreach ($catrefs as $catref) {
                    $return_array[] = array(
                        'value' => $catref->title,
                        'title_ext' => $catref->title_ext,
                        'size' => $catref->size,
                        'signed' => $catref->signed,
                        'edition' => $catref->edition,
                        'medium' => $catref->medium,
                        'therest' => $catref->therest,
                        'img' => $catref->img_url(),
                        'reference_num' => $catref->reference_num,
                        'catalogue_id' => $catref->catalogue_id,
                        'guid' => 'r-' . $catref->id,
                        'id' => $catref->id);
                }
                break;

            default:
                return Response::json(array(), 404);
                break;
        }

        return Response::json($return_array, 200);
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


    /*
     * Search eBay with keywords and return result
     * @return Response
     */
    public function ebay($type = 'search', $keyword = '')
    {
        $return = [];

        switch ($type) {

            case 'find_item':
                $service = new FindingServices\FindingService(array(
                    'sandbox' => false,
                    'appId' => $_ENV['EBAY_APP_KEY'],
                    'globalId' => Constants\GlobalIds::US
                ));

                // Create the API request object.
                $request = new FindingTypes\FindItemsByKeywordsRequest();

                // Assign the keywords.
                $request->keywords = $keyword;

                // Ask for the first 25 items.
                $request->paginationInput = new FindingTypes\PaginationInput();
                $request->paginationInput->entriesPerPage = 25;
                $request->paginationInput->pageNumber = 1;

                // Ask for the results to be sorted from high to low price.
                $request->sortOrder = 'CurrentPriceHighest';

                // Send the request.
                $response = $service->findItemsByKeywords($request);

                // Output the response from the API.
                if ($response->ack !== 'Success') {
                    foreach ($response->errorMessage->error as $error) {
                        $return = "Error: %s\n" . $error->message;
                    }
                } else {
                    foreach ($response->searchResult->item as $item) {
                        $return['itemId'][] = $item->itemId;
                    }
                }
                break;

            case 'time':
                $service = new TradingServices\TradingService(array(
                    'sandbox' => false,
                    'apiVersion' => $_ENV['EBAYSDK_VERSION'],
                    'siteId' => Constants\SiteIds::US,
                ));

                $request = new TradingTypes\GeteBayOfficialTimeRequestType();
                $request->RequesterCredentials = new TradingTypes\CustomSecurityHeaderType();
                $request->RequesterCredentials->eBayAuthToken = $_ENV['EBAY_AUTH_TOKEN'];

                $response = $service->geteBayOfficialTime($request);
                if ($response->Ack !== 'Success') {
                    if (isset($response->Errors)) {
                        foreach ($response->Errors as $error) {
                            $return = ["result" => "Error: " . $error->ShortMessage];
                        }
                    }
                } else {
                    $return = ["result" => "The official eBay time is:" . $response->Timestamp->format('H:i (\G\M\T) \o\n l jS F Y')];
                }
                break;

            case 'get_item_number':
                $service = new FindingServices\FindingService(array(
                    'sandbox' => false,
                    'appId' => $_ENV['EBAY_PRODUCTION_APPID'],
                    'globalId' => Constants\GlobalIds::US
                ));

                $request = new FindingTypes\FindItemsIneBayStoresRequest();
                $request->storeName = "Masterworks Fine Art";
                $response = $service->findItemsIneBayStores($request);

                $return['itemId'] = null;

                if ($response->ack !== 'Success') {
                    foreach ($response->errorMessage->error as $error) {
                        $return = "Error: %s\n" . $error->message;
                    }
                } else {
                    foreach ($response->searchResult->item as $item) {
                        $requestItemNumber = Request::create('/api/v1/ebay/get_id/' . $item->itemId, 'GET');
                        $artwork_data = json_decode(Route::dispatch($requestItemNumber)->getContent());

                        if ($artwork_data->id == $keyword) {
                            $return['itemId'] = $item->itemId;
                        }
                    }
                }

                break;

            case 'get_id':
                $service = new TradingServices\TradingService(array(
                    'sandbox' => false,
                    'apiVersion' => $_ENV['EBAYSDK_VERSION'],
                    'siteId' => Constants\SiteIds::US,
                ));

                $request = new TradingTypes\GetItemRequestType();
                $request->RequesterCredentials = new TradingTypes\CustomSecurityHeaderType();
                $request->RequesterCredentials->eBayAuthToken = $_ENV['EBAY_AUTH_TOKEN'];
                $request->ItemID = $keyword;
                $request->IncludeItemSpecifics = true;

                $response = $service->getItem($request);

                if (isset($response->Errors)) {
                    foreach ($response->Errors as $error) {
                        $return[] = sprintf("%s: %s\n%s\n\n",
                            $error->SeverityCode === TradingEnums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                            $error->ShortMessage,
                            $error->LongMessage
                        );
                    }
                }

                if ($response->Ack !== 'Failure') {
                    $return[] = sprintf("The item was listed to the eBay Sandbox with the Item number %s\n",
                        $response->Item->ItemID
                    );
                }

                $return = ['id' => null];

                foreach ($response->Item->ItemSpecifics->NameValueList as $item) {
                    if ($item->Name == 'MFA Item Number') {
                        $return = ['id' => $item->Value[0]];
                    }
                }
                break;

            case 'add_item':
                $service = new TradingServices\TradingService(array(
                    'sandbox' => false,
                    'apiVersion' => $_ENV['EBAYSDK_VERSION'],
                    'siteId' => Constants\SiteIds::US,
                ));

                $request = new TradingTypes\AddFixedPriceItemRequestType();
                $request->RequesterCredentials = new TradingTypes\CustomSecurityHeaderType();
                $request->RequesterCredentials->eBayAuthToken = $_ENV['EBAY_AUTH_TOKEN'];

                $artwork_id = $keyword;
                $artwork = Artwork::find($artwork_id);

                if ($artwork->sold != 0 || $artwork->hidden != 0) {
                    $return = ['message' => 'Item not available for sale.'];
                    return Response::make($return, 200);
                }

                $item = Url::getEbayItem($artwork);

                $request->Item = $item;

                $response = $service->addFixedPriceItem($request);

                if (isset($response->Errors)) {
                    foreach ($response->Errors as $error) {
                        $return[] = sprintf("%s: %s\n%s\n\n",
                            $error->SeverityCode === TradingEnums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                            $error->ShortMessage,
                            $error->LongMessage
                        );
                    }
                }

                if ($response->Ack !== 'Failure') {
                    $return[] = sprintf("The item was listed to the eBay Sandbox with the Item number %s\n",
                        $response->ItemID
                    );
                }

                $return[] = $response;
                break;

            case 'revise':
                $artwork = Artwork::find((int)$keyword);

                if (! isset($artwork->id) || $artwork->sold + $artwork->hidden + $artwork->onhold + $artwork->price_on_req > 0
                    || $artwork->price < 1000) {
                    $return = ['itemNumber' => null];

                    return Response::make($return, 200);
                }

                $requestItemNumber = Request::create('/api/v1/ebay/get_item_number/' . $keyword, 'GET');
                $item_number = json_decode(Route::dispatch($requestItemNumber)->getContent());

                $service = new TradingServices\TradingService(array(
                    'sandbox' => false,
                    'apiVersion' => $_ENV['EBAYSDK_VERSION'],
                    'siteId' => Constants\SiteIds::US,
                ));

                if ($item_number->itemId) {
                    $request = new TradingTypes\ReviseItemRequestType();
                } else {
                    $request = new TradingTypes\AddFixedPriceItemRequestType();
                }

                $request->RequesterCredentials = new TradingTypes\CustomSecurityHeaderType();
                $request->RequesterCredentials->eBayAuthToken = $_ENV['EBAY_AUTH_TOKEN'];

                $item = Url::getEbayItem($artwork, $item_number->itemId);

                $request->Item = $item;

                if ($item_number->itemId) {
                    $response = $service->reviseItem($request);
                } else {
                    $response = $service->addFixedPriceItem($request);
                }

                if (isset($response->Errors)) {
                    foreach ($response->Errors as $error) {
                        $return['error'] = sprintf("%s: %s\n%s\n\n",
                            $error->SeverityCode === TradingEnums\SeverityCodeType::C_ERROR ? 'Error' : 'Warning',
                            $error->ShortMessage,
                            $error->LongMessage
                        );
                    }
                }

                if ($response->Ack !== 'Failure') {
                    $return['itemNumber'] = $response->ItemID;
                } else {
                    $return['itemNumber'] = null;
                }

                break;
        }

        return Response::make($return, 200);
    }

    public function newsletter($cust_email, $first_name = null, $last_name = null, $lists = null)
    {
        if ($first_name == "null") {
            $first_name = null;
        }

        if ($last_name == "null") {
            $last_name = null;
        }

        $cust_info = ['cust_email' => $cust_email,
            'first_name' => $first_name,
            'last_name' => $last_name];


        $existing_email = $this->cc->getContactByEmail(ACCESS_TOKEN, $cust_info['cust_email']);

        if (empty($existing_email->results)) {
            $contact = $this->addContact($cust_info); // add them, and put them in the general list
        } else {
            $contact = $this->updateContact($cust_info, $existing_email->results[0]); // they already exist, so update their info
        }

        if ($lists != null) {
            $lists = explode(',', $lists);
            $contact = $this->addToList($contact, $lists);
        }

        return Response::json($contact, 200);
    }

    public function addContact($cust_info)
    {
        $contact = $this->url->createContact($cust_info);
        return $this->cc->addContact(ACCESS_TOKEN, $contact);
    }

    public function updateContact($cust_info, $existing_email)
    {
        $contact = $this->url->editContact($cust_info, $existing_email);
        return $this->cc->updateContact(ACCESS_TOKEN, $contact);
    }

    public function addToList($contact, $list_names)
    {
        array_map('strtolower', $list_names);
        // attempt to fetch lists in the account, catching any exceptions and printing the errors to screen
        try{
            $lists = $this->cc->getLists(ACCESS_TOKEN);
        } catch (CtctException $ex) {
            foreach ($ex->getErrors() as $error) {
                print_r($error);
            }
        }

        foreach ($list_names as $list_name) {
            $list_name .= '-list';
            $list = null;

            foreach ($lists as $l){
                if (strtolower($l->name) == $list_name) {
                    $list = $this->cc->getList(ACCESS_TOKEN, $l->id);
                }
            }

            // list doesn't exist yet, so make it!
            if ($list == null) {
                $new_list = $this->url->createList($list_name);
                $list = $this->cc->addList(ACCESS_TOKEN, $new_list);
            }

            $contact->addList($list->id);
        }

        return $this->cc->updateContact(ACCESS_TOKEN, $contact);
    }

}
