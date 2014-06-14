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
        'first_name'       => 'required',
        'last_name'       => 'required',
        'alias'       => 'required',
        'year_begin'      => 'required|numeric|min:0',
        'year_end'      => 'required|numeric|min:0',
    );

    public static $messages = [
        'alias.required' => "You need a alias.",
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
        return '/artists/' . $this->url_slug;
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

    public function artworks()
    {
        return $this->hasMany('Artwork');
    }


}