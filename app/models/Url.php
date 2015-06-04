<?php
// app/models/Url.php
use DTS\eBaySDK\Constants;
use DTS\eBaySDK\Finding\Services as FindingServices;
use DTS\eBaySDK\Finding\Types as FindingTypes;
use DTS\eBaySDK\Trading\Services as TradingServices;
use DTS\eBaySDK\Trading\Types as TradingTypes;
use DTS\eBaySDK\Trading\Enums as TradingEnums;
use \DTS\eBaySDK\Trading;
use \DTS\eBaySDK\FileTransfer;

class Url extends Eloquent
{
    public $timestamp = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'urls';

    protected $fillable = [];


    public static $rules = [];

    public static $messages = [];

    public function isValid($id = null)
    {

        $validation = Validator::make($this->attributes, static::$rules,  static::$messages);

        if ($validation->passes()) return true;

        $this->errors = $validation->messages();
        return false;
    }


    public function editContact($cust_info, $existing_email)
    {
        $contact = $existing_email;
        $contact->first_name = $cust_info['first_name'];
        $contact->last_name = $cust_info['last_name'];

        return $contact;
    }


    public function createContact($cust_info)
    {
        try {
            $contact = new \Ctct\Components\Contacts\Contact();
            $contact->addEmail($cust_info['cust_email']);
            $contact->first_name = $cust_info['first_name'];
            $contact->last_name = $cust_info['last_name'];
            $contact->addList('2105231740'); // add to 'general' list

            // catch any exceptions thrown during the process and print the errors to screen
        } catch (CtctException $ex) {
            echo '<span class="label label-important">Error</span>';
            echo '<div class="container alert-error"><pre class="failure-pre">';
            print_r($ex->getErrors());
            echo '</pre></div>';
            die();
        }

        return $contact;
    }

    public function createList($list_name)
    {
        $new_list = new \Ctct\Components\Contacts\ContactList();
        $new_list->name = $list_name;
        $new_list->status = 'ACTIVE';

        return $new_list;
    }


    /*
     * Generates an SEO-optimized artwork title under 80 characters
     */
    public static function getTitleSEO(Artwork $artwork)
    {
        $title = $artwork->artist->inverted_alias(true) . ', ' . $artwork->medium_short() . ', ' . $artwork->title_short();

        if (sizeof($title) >= 80) {
            $title = $artwork->artist->inverted_alias(true) . ', ' . $artwork->mediums() . ', ' . $artwork->title_short();
        }

        if (sizeof($title) >= 80) {
            $title = $artwork->artist->inverted_alias(true) . ', ' . $artwork->title_short();
        }

        if (sizeof($title) >= 80) {
            $title = $artwork->title_short();
        }

        return trim($title);
    }


    /*
     * Creates an eBay Item
     *
     * @var Artwork
     * @var string
     *
     * @return TradingTypes\ItemType $item
     */
    public static function getEbayItem(Artwork $artwork, $item_number = null)
    {
        $item = new TradingTypes\ItemType();

        if ($item_number) {
            $item->ItemID = $item_number;
        }

        $item->Title = html_entity_decode(Url::getTitleSEO($artwork), ENT_NOQUOTES);
        $item->SubTitle = html_entity_decode('Masterworks Fine Art Inc. (510)777-9970/1-800-805-7060', ENT_NOQUOTES);

        $ch = curl_init("http://www.masterworksfineart.com/ext_files/ebayTemplate_clean.php?i=" . $artwork->id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);

        $item->Description = htmlspecialchars($content, ENT_XML1);

        $item->PictureDetails = new TradingTypes\PictureDetailsType();
        $item->PictureDetails->GalleryType = TradingEnums\GalleryTypeCodeType::C_GALLERY;
        $item->PictureDetails->PictureURL = array($artwork->img_url());

        $item->PrimaryCategory = new TradingTypes\CategoryType();
        $item->PrimaryCategory->CategoryID = '360';

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

        $item->BestOfferDetails = new TradingTypes\BestOfferDetailsType();
        $item->BestOfferDetails->BestOfferEnabled = true;

        $item->ListingDetails = new TradingTypes\ListingDetailsType();
        $item->ListingDetails->MinimumBestOfferPrice = new TradingTypes\AmountType(array('value' => (double)($artwork->price/2)));

        $item->Country = 'US';
        $item->Location = 'Oakland, CA, 94619';
        $item->Currency = 'USD';
        $item->PaymentMethods[] = 'PayPal';
        $item->PayPalEmailAddress = 'rob@masterworksfineart.com';
        $item->DispatchTimeMax = 5;
        $item->ShipToLocations[] = 'Worldwide';
        $item->ReturnPolicy = new TradingTypes\ReturnPolicyType();
        $item->ReturnPolicy->ReturnsAcceptedOption = 'ReturnsAccepted';

        $item->ShippingDetails = new TradingTypes\ShippingDetailsType();
        $item->ShippingDetails->ShippingType = TradingEnums\ShippingTypeCodeType::C_FLAT;

        $shippingService = new TradingTypes\InternationalShippingServiceOptionsType();
        $shippingService->ShippingServicePriority = 1;
        $shippingService->ShippingService = 'StandardInternational';
        $shippingService->ShippingServiceCost = new TradingTypes\AmountType(array('value' => 250.00));
        $shippingService->ShipToLocation = array('WorldWide');

        $item->ShippingDetails->InternationalShippingServiceOption[] = $shippingService;

        $item->ShippingDetails->PaymentInstructions = html_entity_decode("Masterworks Fine Art, Inc. accepts MasterCard, Visa, American Express, PayPal and PayPal E-Check, for payment. $1000 deposit due within 2 days of winning via Credit Card or PayPal, balance due in 5 business days. PayPal E-Check is a great way to pay for your eBay purchases. We reserve the right to refuse credit card shipments to foreign addresses if they do not go to the verified billing address.", ENT_NOQUOTES);

        $shippingService = new TradingTypes\ShippingServiceOptionsType();
        $shippingService->ShippingServicePriority = 1;
        $shippingService->ShippingService = 'ShippingMethodStandard';
        $shippingService->ShippingServiceCost = new TradingTypes\AmountType(array('value' => 150.00));

        $item->ShippingDetails->ShippingServiceOptions[] = $shippingService;

        return $item;
    }
}