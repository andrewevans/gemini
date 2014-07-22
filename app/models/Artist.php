<?php
// app/models/Artist.php

class Artist extends Eloquent
{
    public $timestamp = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'artists';

    protected $fillable = ['slug', 'alias', 'first_name', 'last_name', 'url_slug', 'meta_title', 'meta_description', 'year_begin', 'year_end'];


    public static $rules = array(
        'alias'       => 'required',
        'slug'       => 'required',
        'url_slug'       => 'required',
        'year_begin'      => 'required|numeric|min:0',
        'year_end'      => 'required|numeric|min:0',
    );

    public static $messages = [
        'alias.required' => "You need a alias.",
    ];

    public function isValid($id = null)
    {
        $rules_modified = static::$rules;
        $rules_modified['slug'] .= "|unique:artists,slug," . $id;
        $rules_modified['url_slug'] .= "|unique:artists,url_slug," . $id;

        $validation = Validator::make($this->attributes, $rules_modified,  static::$messages);

        if ($validation->passes()) return true;

        $this->errors = $validation->messages();
        return false;
    }

    public function url()
    {
        return '/artists/' . $this->url_slug;
    }

    public function inverted_alias() {

        if ($this->first_name == '') return '<span class="uppercase">' . $this->alias . '</span>';

        return '<span class="uppercase">' . $this->last_name . '</span>, ' . $this->first_name;
    }

    function filterMediumSearch($medium) {

        switch($this->slug) {
            case 'picasso':
                switch($medium) {
                    case 'ceramics':
                        return ['ceramic', 'clay', 'sculpture', 'plate', 'madoura'];
                        break;

                    case 'lithographs':
                        return ['lithograph', 'litho'];
                        break;

                    case 'linocuts':
                        return ['linocut', 'linoleum'];
                        break;

                    case 'etchings':
                        return ['etching'];
                        break;

                    // prints are all that are NOT ceramics, so it returns the words to avoid
                    case 'prints':
                        return ['ceramic', 'clay', 'sculpture', 'plate', 'madoura'];
                        break;

                    default:
                        return array($medium);
                }
                break;

            case 'miro':
                switch($medium) {
                    case 'etchings':
                        return ['etching', 'engraving'];
                        break;

                    case 'lithographs':
                        return ['lithograph', 'litho'];
                        break;

                    case 'aquatints':
                        return ['aquatint'];
                        break;

                    case 'carborundum':
                        return ['carborundum'];
                        break;

                    default:
                        return array($medium);
                }
                break;

            case 'rembrandt':
                switch($medium) {
                    case 'etchings':
                        return ['etching','engraving'];
                        break;

                    default:
                        return $medium;
                }
                break;

            default:
                switch($medium) {
                    case 'ceramics':
                        return ['ceramic', 'clay', 'sculpture', 'plate', 'madoura'];
                        break;

                    case 'lithographs':
                        return ['lithograph', 'litho'];
                        break;

                    case 'linocuts':
                        return ['linocut', 'linoleum'];
                        break;

                    case 'etchings':
                        return ['etching'];
                        break;

                    // prints are all that are NOT ceramics, so it returns the words to avoid
                    case 'prints':
                        return ['ceramic', 'clay', 'sculpture', 'plate', 'madoura'];
                        break;

                    default:
                        return array($medium);
                }

                return array($medium);
        }
    }

    function filterSeriesSearch($series) {

        switch($this->slug) {
            case 'picasso':
                switch($series) {
                    case 'blue-period':
                        return 'blue period';
                        break;

                    case 'cubism':
                        return 'cubism';
                        break;

                    default:
                        return $series;
                }
                break;

            case 'chagall':
                switch($series) {
                    case 'bible-series':
                        return "bible series";
                        break;

                    case 'tribes-of-israel':
                        return "tribes of israel";
                        break;

                    case 'daphnis-and-chloe':
                        return "daphnis and chloe";
                        break;

                    case 'nice-and-the-cote-dazur':
                        return "nice and the c&ocirc;te d'azur";
                        break;

                    default:
                        return $series;
                }
                break;

            default:
                break;
        }

        return $series;
    }


    public function medium_query($filter)
    {
        if ($filter == 'prints') {
            $like = 'NOT LIKE';
            $conjunction = 'AND';
        } else {
            $like = 'LIKE';
            $conjunction = 'OR';
        }

        return 'medium ' . $like . ' "%' . implode('%" ' . $conjunction . ' medium ' . $like . ' "%', $this->filterMediumSearch($filter)). '%"';
    }

    public function series_query($filter)
    {
        $like = 'LIKE';

        return 'series ' . $like . ' "%' . $this->filterSeriesSearch($filter). '%"';
    }

    function filterMediumReadable($medium) {

        switch($this->slug) {
            case 'picasso':
            case 'miro':
            case 'rembrandt':
                switch($medium) {
                    case 'ceramics':
                        return 'Ceramics';
                        break;

                    case 'linocuts':
                        return 'Linocuts';
                        break;

                    case 'lithographs':
                        return 'Lithographs';
                        break;

                    case 'etchings':
                        return 'Etchings';
                        break;

                    case 'prints':
                        return 'Works on Paper';
                        break;

                    case 'aquatints':
                        return 'Aquatints';
                        break;

                    case 'carborundum':
                        return 'Carborundum';
                        break;

                    default:
                        break;
                }
                break;

            default:
                switch($medium) {
                    default:
                        break;
                }
        }

        return false;
    }

    function filterSeriesReadable($medium) {

        switch($this->slug) {
            case 'picasso':
                switch($medium) {
                    case 'blue-period':
                        return 'Blue Period';
                        break;

                    case 'cubism':
                        return 'Cubism';
                        break;

                    default:
                        break;
                }
                break;

            case 'chagall':
                switch($medium) {
                    case 'bible-series':
                        return 'Bible Series';
                        break;

                    case 'tribes-of-israel':
                        return 'Tribes of Israel';
                        break;

                    case 'daphnis-and-chloe':
                        return 'Daphnis and Chloe';
                        break;

                    case 'nice-and-the-cote-dazur':
                        return 'Nice and The C&ocirc;te d\'Azur';
                        break;

                    default:
                        break;
                }
                break;

            default:
                switch($medium) {
                    default:
                        break;
                }
        }

        return false;
    }

    /*
     * Creates page title by concatenating alias and, if available, 1) filter, or 2) meta title, or 3) default value;
     */
    public function title($filter = null)
    {
        if ($filter) {
            return $this->alias . ' ' . $filter;
        } else if ($this->meta_title != '') {
            return $this->alias . ' ' . $this->meta_title;
        }

        return $this->alias . " Original Prints";
    }


    public function filters()
    {
        switch($this->slug) {

            case 'picasso':
                return ['ceramics', 'etchings', 'linocuts', 'prints'];
                break;

            case 'miro':
                return ['etchings', 'lithographs', 'aquatints', 'carborundum'];
                break;

            case 'rembrandt':
                return ['etchings'];

                break;
            default:
                return [];
                break;
        }

    }


    public function series()
    {
        switch($this->slug) {

            case 'chagall':
                return ['bible-series', 'tribes-of-israel', 'daphnis-and-chloe', 'nice-and-the-cote-dazur'];
                break;

            default:
                return [];
                break;
        }

    }


    public function img_url($upload = false)
    {
        $extension = 'jpg';

        $local_file = $this->img_directory_url() . $this->url_slug . '.' . $extension;

        if (file_exists($local_file) || $upload) return $local_file;

        $remote_file = 'http://www.masterworksfineart.com/images/artists_bio/' . $this->slug . '.jpg';

        if ($this->checkRemoteFile($remote_file)) { return $remote_file; }

        return 'img/no-image.jpg';

    }


    public function img_directory_url()
    {
        return 'img/artists/' . $this->slug . '/profile/';
    }


    function checkRemoteFile($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        // don't download content
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(curl_exec($ch)!==FALSE)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    public function artworks()
    {
        return $this->hasMany('Artwork');
    }

    public function artist_bio()
    {
        return $this->hasMany('ArtistBio');
    }

    public function catalogues()
    {
        return $this->hasMany('Catalogue');
    }


    public function artists_previous()
    {

        $artists_previous_session = unserialize(Session::get('artists_previous', ''));

        if (! is_array($artists_previous_session)) $artists_previous_session = [];

        if (! in_array($this->id, $artists_previous_session)) {
            $artists_previous_session = serialize(array_merge( $artists_previous_session, (array) $this->id));
            Session::put('artists_previous', $artists_previous_session);
        } else {
            // it is in the array, so unset it and reassign it to the beginning
            $key = array_search($this->id, $artists_previous_session);
            unset($artists_previous_session[$key]);
            $artists_previous_session = array_values($artists_previous_session);
            $artists_previous_session = serialize(array_merge( $artists_previous_session, (array) $this->id));
            Session::put('artists_previous', $artists_previous_session);
        }

        return Tools::artists_previous();
    }


}