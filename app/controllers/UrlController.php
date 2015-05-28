<?php

require_once '../vendor/constantcontact/constantcontact/src/Ctct/autoload.php';

use Ctct\ConstantContact;
use Ctct\Components\Contacts\Contact;
use Ctct\Components\Contacts\ContactList;
use Ctct\Components\Contacts\EmailAddress;
use Ctct\Exceptions\CtctException;

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
            case 'search':
                $api_endpoint = 'http://svcs.ebay.com/services/search/FindingService/'
                    . 'v1?'
                    . 'OPERATION-NAME=findItemsByKeywords'
                    . '&SERVICE-VERSION=1.0.0'
                    . '&SECURITY-APPNAME=' . $_ENV['EBAY_PRODUCTION_APPID']
                    . '&RESPONSE-DATA-FORMAT=JSON'
                    . '&REST-PAYLOAD'
                    . '&keywords='
                    . urlencode($keyword)
                    . '&paginationInput.entriesPerPage=10';

                $connection = curl_init();
                curl_setopt($connection, CURLOPT_URL, $api_endpoint);
                curl_setopt($connection, CURLOPT_RETURNTRANSFER, true);
                $response = json_decode(curl_exec($connection), true);
                curl_close($connection);

                $return = $response['findItemsByKeywordsResponse'][0]['searchResult'][0]['item'];
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
