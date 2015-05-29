<?php
// app/models/Artwork.php

class Artwork extends Eloquent
{
    public $timestamp = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'artworks';

    protected $guarded = [];

    public static $rules = array(
        'artist_id'     => 'required|numeric|min:0',
        'price'       => 'required|numeric|min:0',
        'title'       => 'required',
        'medium'       => 'required',
        'price_on_req'       => 'required|numeric|min:0|max:1',
        'sold'       => 'required|numeric|min:0|max:3',
        'onhold'       => 'required|numeric|min:0|max:1',
        'hidden'       => 'required|numeric|min:0|max:2',
    );

    public static $messages = [
        'title.required' => "You need a title for sure!",
    ];

    public function isValid($id = null)
    {
        $rules_modified = static::$rules;

        $validation = Validator::make($this->attributes, $rules_modified,  static::$messages);

        if ($validation->passes()) return true;

        $this->errors = $validation->messages();
        return false;
    }

    public function title_short()
    {
        if ($this->title_short == '') {
            return $this->title;
        }

        return $this->title_short;
    }

    public function medium_short()
    {
        if ($this->medium_short == '') {
            return $this->medium;
        }

        return $this->medium_short;
    }

    public function url()
    {
        return '/artists/' . $this->artist->url_slug . "/" . $this->friendly_url($this->mediums($this->medium_short)) . "/" . $this->friendly_url($this->title_short) . "/id/" . $this->id;
    }

    public function friendly_url($data)
    {
        return $this->url_slug(html_entity_decode($data));
    }

    public function medium_simple($medium = null)
    {
        if ($medium == null) {
            $medium = strtolower($this->mediums());
        } else {
            $medium = strtolower($medium);
        }

        $medium_simple = 'artwork';

        if (preg_match('/aquatint/', $medium)){
            $medium_simple = 'aquatint';
        }

        if (preg_match('/linocut|linoleum/', $medium)){
            $medium_simple = 'linocut';
        }

        if (preg_match('/etching|engraving/', $medium)){
            $medium_simple = 'etching';
        }

        if (preg_match('/drawing/', $medium)){
            $medium_simple = 'drawing';
        }

        if (preg_match('/panting/', $medium)){
            $medium_simple = 'painting';
        }

        if (preg_match('/woodcut/', $medium)){
            $medium_simple = 'woodcut';
        }

        if (preg_match('/tapestry/', $medium)){
            $medium_simple = 'tapestry';
        }

        if (preg_match('/screenprint/', $medium)){
            $medium_simple = 'screenprint';
        }

        if (preg_match('/sculpture|sculpt/', $medium)){
            $medium_simple = 'sculpture';
        }

        if (preg_match('/ceramic|madoura|clay/', $medium)){
            $medium_simple = 'ceramic';
        }

        if (preg_match('/lithograph/', $medium)){
            $medium_simple = 'lithograph';
        }

        return $medium_simple;
    }

    // mediums() needs serious refactoring and cleanup!
    public function mediums($medium = null)
    {
        if ($medium == null) $medium = $this->medium_short;
        if ($medium == '') $medium = $this->medium;

        $seomediumnone=$medium;

        $seomedium = "";

        if(strpos(strtolower($medium),"unique") !== false)
            $seomedium = " Unique";

        if(strpos(strtolower($medium),"acrylic") !== false)
            $seomedium = $seomedium." Acrylic";

        if(strpos(strtolower($medium),"aluminum") !== false)
            $seomedium = $seomedium." Aluminum";

        if(strpos(strtolower($medium),"woodcut") !== false)
            $seomedium = $seomedium." Woodcut";
        else
            if(strpos(strtolower($medium),"wood") !== false || strpos(strtolower($medium),"wooden") !== false)
                $seomedium = $seomedium." Wood";

        if(strpos(strtolower($medium),"linocut") !== false || strpos(strtolower($medium),"linoleum") !== false)
            $seomedium = $seomedium." Linocut / Linoleum Cut";
        else
            if(strpos(strtolower($medium),"lithograph") !== false)
                $seomedium = $seomedium." Lithograph";

        if(strpos(strtolower($medium),"ceramic") !== false || strpos(strtolower($medium),"clay") !== false)
            $seomedium = $seomedium." Ceramic";

        if(strpos(strtolower($medium),"etching") !== false)
            $seomedium = $seomedium." Etching";

        if(strpos(strtolower($medium),"engraving") !== false)
            $seomedium = $seomedium." Engraving";

        if(strpos(strtolower($medium),"aquatint") !== false)
            $seomedium = $seomedium." Aquatint";

        if(strpos(strtolower($medium),"carborundum") !== false)
            $seomedium = $seomedium." Carborundum";

        if(strpos(strtolower($medium),"madoura") !== false)
            $seomedium = $seomedium." Madoura Sculpture";

        if(strpos(strtolower($medium),"sculpture") !== false)
            $seomedium = $seomedium." Sculpture";

        if(strpos(strtolower($medium),"pastel") !== false)
            $seomedium = $seomedium." Pastel";

        if(strpos(strtolower($medium),"crayon") !== false)
            $seomedium = $seomedium." Crayon Drawing";
        else
            if(strpos(strtolower($medium),"drawing") !== false)
                $seomedium = $seomedium." Drawing";

        if(strpos(strtolower($medium),"oil") !== false)
            $seomedium = $seomedium." Oil Painting";
        else
            if(strpos(strtolower($medium),"painting") !== false)
                $seomedium = $seomedium." Painting";

        if(strpos(strtolower($medium),"serigraph") !== false)
            $seomedium = $seomedium." Serigraph";

        if(strpos(strtolower($medium),"screenprint") !== false)
            $seomedium = $seomedium." Screenprint";

        if(strpos(strtolower($medium),"tapestry") !== false)
            $seomedium = $seomedium." Hand-woven Tapestry";

        if(strpos(strtolower($medium),"watercolor") !== false)
            $seomedium = $seomedium." Watercolor";

        if(strpos(strtolower($medium),"gouache") !== false)
            $seomedium = $seomedium." Gouache";

        if(strpos(strtolower($medium),"silkscreen") !== false)
            $seomedium = $seomedium." Silkscreen";

        if(strpos(strtolower($medium),"collotype") !== false)
            $seomedium = $seomedium." Collotype";

        if(strpos(strtolower($medium),"horse") !== false)
            $seomedium = $seomedium." Lifesize Sculpture";

        if(strpos(strtolower($medium),"porcelain relief") !== false)
            $seomedium = $seomedium." Ceramic Porcelain Relief";

        if(strpos(strtolower($medium),"canvas") !== false)
            $seomedium = $seomedium." on Canvas";

        if($seomedium=='')
            return $seomediumnone;
        else
            return $seomedium;
    }

    /**
     * Create a web friendly URL slug from a string.
     *
     * Although supported, transliteration is discouraged because
     *     1) most web browsers support UTF-8 characters in URLs
     *     2) transliteration causes a loss of information
     *
     * @author Sean Murphy <sean@iamseanmurphy.com>
     * @copyright Copyright 2012 Sean Murphy. All rights reserved.
     * @license http://creativecommons.org/publicdomain/zero/1.0/
     *
     * @param string $str
     * @param array $options
     * @return string
     */
    function url_slug($str, $options = array()) {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => true,
        );

        // Merge options
        $options = array_merge($defaults, $options);

        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',

            // Latin symbols
            '©' => '(c)',

            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',

            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',

            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',

            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',

            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        );

        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }

        // Replace non-alphanumeric characters with our delimiter
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

        // Truncate slug to max. characters
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

        // Remove delimiter from ends
        $str = trim($str, $options['delimiter']);

        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }

    public function page_title()
    {
        $page_title = $this->artist->last_name . " " . $this->medium_short() . " | " . $this->title_short();

        if ($this->sold) $page_title .= " (Sold)";

        return $page_title;
    }


    public function img_url($upload = false, $key = null)
    {
        $extension = 'jpg';

        $img_num_av = '';

        if ($key != null) $img_num_av = '_' . $key;

        $local_file = $this->img_directory_url() . '/' . $this->artist->slug . $this->id . $img_num_av . '.' . $extension;

        if (file_exists($local_file) || $upload) return '/' . $local_file;

        $remote_file = 'http://www.masterworksfineart.com/inventory/' . $this->artist->slug . '/original/' . $this->artist->slug . $this->id . $img_num_av . '.' . $extension;

        if ($this->checkRemoteFile($remote_file)) { return $remote_file; }

        return '/img/no-image.jpg';
    }


    public function img_directory_url()
    {
        return 'img/artists/' . $this->artist->slug . '/original';
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


    public function price_box()
    {
        return View::make('widgets.artworks.price', ['artwork' => $this]);
    }


    public function artist()
    {
        return $this->belongsTo('Artist');
    }

    public function artwork_description()
    {
        return $this->hasOne('ArtworkDescription');
    }

    public function artworks_related()
    {
        $artist = $this->artist;
        $artworks_related = $artist->artworks()->where('sold', '=', '0')->where('hidden', '!=', 1)->take(5)->orderBy('id', 'DESC')->get();

        return $artworks_related;
    }

    public function artworks_previous()
    {
        if ($this->attributes['hidden'] != 1) {

            $artworks_previous_session = unserialize(Session::get('artworks_previous', ''));

            if (! is_array($artworks_previous_session)) $artworks_previous_session = [];

            if (! in_array($this->id, $artworks_previous_session)) {
                $artworks_previous_session = serialize(array_merge( $artworks_previous_session, (array) $this->id));
                Session::put('artworks_previous', $artworks_previous_session);
            } else {
                // it is in the array, so unset it and reassign it to the beginning
                $key = array_search($this->id, $artworks_previous_session);
                unset($artworks_previous_session[$key]);
                $artworks_previous_session = array_values($artworks_previous_session);
                $artworks_previous_session = serialize(array_merge( $artworks_previous_session, (array) $this->id));
                Session::put('artworks_previous', $artworks_previous_session);
            }

        }

        return Tools::artworks_previous();
    }


}