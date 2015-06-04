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

            case 'get_id':
                $service = new TradingServices\TradingService(array(
                    'sandbox' => false,
                    'apiVersion' => $_ENV['EBAYSDK_VERSION'],
                    'siteId' => Constants\SiteIds::US,
                ));

                $request = new TradingTypes\GetItemRequestType();
                $request->RequesterCredentials = new TradingTypes\CustomSecurityHeaderType();
                $request->RequesterCredentials->eBayAuthToken = $_ENV['EBAY_AUTH_TOKEN_DEV'];
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
                $request->RequesterCredentials->eBayAuthToken = "AgAAAA**AQAAAA**aAAAAA**//ZvVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wJnY+pCpSLoAudj6x9nY+seQ**2uACAA**AAMAAA**xXX/lmbVsw2chrKA6fsoCs/Y7cZ5FEstdY4GLIdEg4RTa5SLwZTW9+Cm6knTGes41QSfzJ5pE/NOwGo3vjFmXDK0Kgo4SxZUMKI5nplcQbeB0nXzpRNcrJmb7Nm8EcGjmcJbqk7ueidibO8AVAmqVrjxs9DyUD2GvRfDWhs0+f1cP+j2djLUKeZ+tUdnIyVQQ3p06czeVi+zFMDihANm936gi4hMzY+zn6ZhV0Hk486dttqtB7EilJgtIGB7LcRdXhj09CfgQt5AWVwQbCd6l0TOShqAqXbWCjHjl2evmUJyMEIGux2xG88mjVbjtYFThOEhS2edncns2RIOMcReavwrpmiUazKgQRlS/t3YIV17fq3RqHIu67Ows9fV9PcAYkM+/+ks2bqedImOsn+ZxF5YJ28xwRvnJsjiMdYcIYLx5sJQdsoRmSDAYeM9cDOjefrdk3LJ+xIsX3CLNdTkv789GEiKoFY7/XZO1pY+0LUjw/IHKdCJjqq2LgaHZQoYwCUNMNydddcShC36bZwAsR8jZyQ6AGmdwV137oj4MiP7lSfk5QK6w4HbzqJm1TwsVhx9RLT426mMh0mXK+xJRLnfnLiksAOgmn3iGV+PvhUas0/UuvEFVkxjnkmaRbjT7ulRjWoEF9ydUto8uB+TH/6voKWjUEj5w86hcQwi0Fy1lqH7iiCul5z0j5bMhugZdowmHT9+2u/ANs6BFkTsl8uZjuNeypcPeKiTE7XhaQzxk+9zgbs19NA/QTu2BuLP";

                $artwork_id = $keyword;
                $artwork = Artwork::find($artwork_id);

                if ($artwork->sold != 0 || $artwork->hidden != 0) {
                    $return = ['message' => 'Item not available for sale.'];
                    return Response::make($return, 200);
                }

                $ch = curl_init("http://www.masterworksfineart.com/ext_files/ebayTemplate_clean.php?i=" . $artwork_id);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
                $content = curl_exec($ch);
                curl_close($ch);

                $artwork->artwork_description = ArtworkDescription::whereArtworkId($artwork_id)->first();
                $artwork->price = number_format($artwork->price, 2, '.', '');

                $item = new TradingTypes\ItemType();

                $item->Title = htmlspecialchars($artwork->title_short(), ENT_XML1);
                $item->SubTitle = htmlspecialchars('Masterworks Fine Art Inc. (510)777-9970/1-800-805-7060');
                $item->Description = htmlspecialchars($content, ENT_XML1);

                $item->PictureDetails = new TradingTypes\PictureDetailsType();
                $item->PictureDetails->GalleryType = TradingEnums\GalleryTypeCodeType::C_GALLERY;
                $img_url = $artwork->img_url();
                $item->PictureDetails->PictureURL = array($img_url);

                $item->PrimaryCategory = new TradingTypes\CategoryType();
                $item->PrimaryCategory->CategoryID = '360';
                $item->DispatchTimeMax = 5;

                $item->ItemSpecifics = new TradingTypes\NameValueListArrayType();
                $item->ItemSpecifics->NameValueList[] = new TradingTypes\NameValueListType(array(
                    'Name' => 'Listed By',
                    'Value' => array('Dealer or Reseller')
                ));

                $item->ItemSpecifics->NameValueList[] = new TradingTypes\NameValueListType(array(
                    'Name' => 'Original/Reproduction',
                    'Value' => array('Original Print')
                ));

                $item->ItemSpecifics->NameValueList[] = new TradingTypes\NameValueListType(array(
                    'Name' => 'Signed',
                    'Value' => array('Signed')
                ));

                $item->ItemSpecifics->NameValueList[] = new TradingTypes\NameValueListType(array(
                    'Name' => 'Edition Type',
                    'Value' => array('Limited Edition')
                ));

                $item->ItemSpecifics->NameValueList[] = new TradingTypes\NameValueListType(array(
                    'Name' => 'MFA Item Number',
                    'Value' => array((string)$artwork->id)
                ));

                $item->ListingType = TradingEnums\ListingTypeCodeType::C_FIXED_PRICE_ITEM;
                $item->Quantity = 1;
                $item->ListingDuration = TradingEnums\ListingDurationCodeType::C_DAYS_10;
                $item->StartPrice = new TradingTypes\AmountType(array('value' => (double)$artwork->price));
                $item->Country = 'US';
                $item->Location = 'Oakland';
                $item->Currency = 'USD';
                $item->PaymentMethods[] = 'PayPal';
                $item->PayPalEmailAddress = 'rob@masterworksfineart.com';
                $item->DispatchTimeMax = 1;
                $item->ShipToLocations[] = 'Worldwide';
                $item->ReturnPolicy = new TradingTypes\ReturnPolicyType();
                $item->ReturnPolicy->ReturnsAcceptedOption = 'ReturnsAccepted';

                $item->ShippingDetails = new TradingTypes\ShippingDetailsType();
                $item->ShippingDetails->ShippingType = TradingEnums\ShippingTypeCodeType::C_FLAT;

                $shippingService = new TradingTypes\ShippingServiceOptionsType();
                $shippingService->ShippingServicePriority = 1;
                $shippingService->ShippingService = 'UPSGround';
                $shippingService->ShippingServiceCost = new TradingTypes\AmountType(array('value' => 150.00));

                $item->ShippingDetails->ShippingServiceOptions[] = $shippingService;

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

                $requestItemNumber = Request::create('/api/v1/ebay/get_id/' . $keyword, 'GET');
                $artwork_data = json_decode(Route::dispatch($requestItemNumber)->getContent());

                $artwork = Artwork::find($artwork_data->id);

                if ($artwork->sold != 0 || $artwork->hidden != 0) {
                    $return = ['message' => 'Item not available for revision.'];
                    return Response::make($return, 200);
                }

                $service = new TradingServices\TradingService(array(
                    'sandbox' => false,
                    'apiVersion' => $_ENV['EBAYSDK_VERSION'],
                    'siteId' => Constants\SiteIds::US,
                ));

                $request = new TradingTypes\ReviseItemRequestType();
                $request->RequesterCredentials = new TradingTypes\CustomSecurityHeaderType();
                $request->RequesterCredentials->eBayAuthToken = $_ENV['EBAY_AUTH_TOKEN'];

                $item = new TradingTypes\ItemType();

                $item->ItemID = $keyword;

                $item->Title = $artwork->title_short();
                $item->SubTitle = 'Masterworks Fine Art Inc. (510)777-9970/1-800-805-7060';

                $item->PictureDetails = new TradingTypes\PictureDetailsType();
                $item->PictureDetails->GalleryType = TradingEnums\GalleryTypeCodeType::C_GALLERY;
                $item->PictureDetails->PictureURL = array($artwork->img_url());

                $item->PrimaryCategory = new TradingTypes\CategoryType();
                $item->PrimaryCategory->CategoryID = '360';
                $item->DispatchTimeMax = 5;

                $item->ItemSpecifics = new TradingTypes\NameValueListArrayType();
                $item->ItemSpecifics->NameValueList[] = new TradingTypes\NameValueListType(array(
                    'Name' => 'Listed By',
                    'Value' => array('Dealer or Reseller')
                ));

                $item->ItemSpecifics->NameValueList[] = new TradingTypes\NameValueListType(array(
                    'Name' => 'Original/Reproduction',
                    'Value' => array('Original Print')
                ));

                $item->ItemSpecifics->NameValueList[] = new TradingTypes\NameValueListType(array(
                    'Name' => 'Signed',
                    'Value' => array('Signed')
                ));

                $item->ItemSpecifics->NameValueList[] = new TradingTypes\NameValueListType(array(
                    'Name' => 'Edition Type',
                    'Value' => array('Limited Edition')
                ));

                $item->ItemSpecifics->NameValueList[] = new TradingTypes\NameValueListType(array(
                    'Name' => 'MFA Item Number',
                    'Value' => array((string)$artwork->id)
                ));

                $item->ListingType = TradingEnums\ListingTypeCodeType::C_FIXED_PRICE_ITEM;
                $item->Quantity = 1;
                $item->ListingDuration = TradingEnums\ListingDurationCodeType::C_DAYS_10;
                $item->StartPrice = new TradingTypes\AmountType(array('value' => (double)$artwork->price));
                $item->Country = 'US';
                $item->Location = 'Oakland';
                $item->Currency = 'USD';
                $item->PaymentMethods[] = 'PayPal';
                $item->PayPalEmailAddress = 'rob@masterworksfineart.com';
                $item->DispatchTimeMax = 1;
                $item->ShipToLocations[] = 'Worldwide';
                $item->ReturnPolicy = new TradingTypes\ReturnPolicyType();
                $item->ReturnPolicy->ReturnsAcceptedOption = 'ReturnsAccepted';

                $item->ShippingDetails = new TradingTypes\ShippingDetailsType();
                $item->ShippingDetails->ShippingType = TradingEnums\ShippingTypeCodeType::C_FLAT;

                $shippingService = new TradingTypes\ShippingServiceOptionsType();
                $shippingService->ShippingServicePriority = 1;
                $shippingService->ShippingService = 'UPSGround';
                $shippingService->ShippingServiceCost = new TradingTypes\AmountType(array('value' => 150.00));

                $item->ShippingDetails->ShippingServiceOptions[] = $shippingService;

                $request->Item = $item;

                $response = $service->reviseItem($request);

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
