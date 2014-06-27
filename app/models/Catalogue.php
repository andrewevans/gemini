<?php
// app/models/Catalogue.php

class Catalogue extends Eloquent
{
    public $timestamp = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'catalogues';

    protected $fillable = ['artist_id', 'slug', 'title', 'url_slug', 'meta_description'];


    public static $rules = array(
        'artist_id' => 'required',
        'slug'       => 'required',
        'title'       => 'required',
        'url_slug'       => 'required',
    );

    public static $messages = [
        'title.required' => "You need a title!",
    ];

    public function isValid($id = null)
    {
        $rules_modified = static::$rules;

        $validation = Validator::make($this->attributes, $rules_modified,  static::$messages);

        if ($validation->passes()) return true;

        $this->errors = $validation->messages();
        return false;
    }

    public function url()
    {
        return '/artists/' . $this->artist->url_slug . "/bio/catalogue-raisonnes/" . $this->url_slug;
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
            case 'rembrandt':
                switch($medium) {
                    case 'ceramics':
                        return 'Ceramics';
                        break;

                    case 'linocuts':
                        return 'Linocuts';
                        break;

                    case 'etchings':
                        return 'Etchings';
                        break;

                    case 'prints':
                        return 'Works on Paper';
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
        return $this->title;
    }


    public function artist()
    {
        return $this->belongsTo('Artist');
    }

    public function catrefs()
    {
        return $this->hasMany('Catref');
    }


}