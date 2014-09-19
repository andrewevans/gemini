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

            case 'manifest':
                if (null !== Input::get('artist_url_slug')) {
                    $artist_url_slug_query = "url_slug = '" . Str::lower(Input::get('artist_url_slug')) . "'";
                    $artist_url_slug = Str::lower(Input::get('artist_url_slug'));
                } else {
                    $artist_url_slug_query = "url_slug != '0'";
                    $artist_url_slug = null;
                }

                switch ((int)Input::get('chapter')) {
                    case 1:
                        $chapter = 1;
                        $artists_filter = "slug = 'picasso' or slug = 'chagall' or slug = 'miro' or slug = 'braque'";
                        break;

                    default:
                        $chapter = 2;
                        $artists_filter = "slug != 'picasso' and slug != 'chagall' and slug != 'miro' and slug != 'braque'";
                        break;
                }

                $artists = Artist::
                    whereRaw('id !=0')
                    ->whereIn('id', function($query)
                    {
                        $query->select('artist_id')
                            ->from('artworks')
                            ->whereRaw('sold = 0 and hidden = 0');
                    })->whereRaw($artists_filter)->orderBy('last_name', 'asc')->get();

                foreach ($artists as $artist) {
                    $artist->artist_offline_url = '/offline/flipboard/' . $artist->url_slug;
                    $artist->manifest_url = '/api/v1/url/manifest?secret=dog&artist_url_slug='. $artist->url_slug;
                }

                foreach ($artists as $artist) {
                    $artworks[] = $artist->artworks()->whereSold(0)->whereHidden(0)->orderBy('artist_id', 'asc')->get();
                }

                foreach ($artworks as $artwork_artist) {
                    foreach ($artwork_artist as $artwork) {
                        $return_array[] = array(
                            'img_url' => $artwork->img_url(),
                            'mfa_img_url' => 'http://www.masterworksfineart.com/inventory/' . $artwork->artist->slug . '/original/' . $artwork->artist->slug . $artwork->id . '.jpg',
                            'artwork_url' => '/offline' . $artwork->url(),
                            'artist_url' => '/offline' . $artwork->artist->url()
                        );
                    }
                }

                $response = Response::make(View::make('artworks.manifest')
                    ->with('return_array', $return_array)
                    ->with('artists', $artists)
                    ->with('artist_url_slug', $artist_url_slug));

                $response->header('Content-Type', 'text/cache-manifest');

                return $response;

                // show the edit form and pass the artwork
                return Response::make(View::make(), 200, array('Content-Type' => 'text/plain'));
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
                    $return_array[] = array(
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

    public function newsletter($cust_email, $first_name = null, $last_name = null, $lists = null)
    {
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
