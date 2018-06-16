<?php

/**
 * home controller
 */
class Services extends AbstractController {
    const CONTROLLER_NAME  = 'Home';
    const PAGE_TITLE       = 'Home';
    const PAGE_DESCRIPTION = 'Home Description';
    const ZILLOW_URL       = 'https://www.zillow.com/webservice/';

    public function __construct($params) {
        parent::__construct();
        $this->_setPageTitle();
        $this->_setParameters($params);
    }

    public function index() {
        echo "Yeh nothing here";
    }

    public function getSearchResults() {
        // Get cURL resource
        $curl = curl_init();
/*
        $parameters = array(
            'p' =>,
            'ds' =>,
            'zso' =>,
            'pnd' =>,
            'pho' =>,
            'red' =>,
            'rt' =>,
            'ht' =>,
            'lt' =>,
            'yr' =>,
            'lot' =>,
            'sf' =>,
            'ba' =>,
            'pr' =>,
            'bd' =>,
            'pets' =>,
            'parking' =>,
            'laundry' =>,
            'pmf'     =>,
            'pf'      =>,
            'zoom'    =>,
            'sort'    =>,
            'att'     =>,
            'days'    =>,
            'rid'      =>,
            'spt'      =>,
            '**kwargs' =>,
            'rect'    =>
        );
*/
        require_once ABS_BASE_PATH . 'library/ultimate-web-scraper/support/web_browser.php';
        require_once ABS_BASE_PATH . 'library/ultimate-web-scraper/support/tag_filter.php';
    
        // Retrieve a URL (emulating Firefox by default).
        $url = 'https://www.zillow.com/search/GetResults.htm?spt=homes&status=110001&lt=111101&ht=100000&pr=200000,500000&mp=801,2002&bd=0%2C&ba=0%2C&sf=,&lot=0%2C&yr=,&singlestory=0&hoa=0%2C&pho=0&pets=0&parking=0&laundry=0&income-restricted=0&fr-bldg=0&condo-bldg=0&furnished-apartments=0&cheap-apartments=0&studio-apartments=0&pnd=0&red=0&zso=0&days=any&ds=all&pmf=1&pf=1&sch=100111&zoom=10&rect=-84721756,33812528,-83983613,34074559&p=1&sort=days&search=maplist&rid=13709&rt=6&listright=true&isMapSearch=true&zoom=10';
        $web = new WebBrowser();
        $result = $web->Process($url);

        $body       = json_decode($result['body']);
        $map        = $body->map;
        $properties = $map->properties;
        $json       = array();

        foreach( $properties as $property ) {
            $secondLevel = $property[8];

            $attributes              = array();
            $attributes['zpid']      = $property[0];
            $attributes['latitude']  = $property[1];
            $attributes['longitude'] = $property[2];
            $attributes['price']     = $secondLevel[0];
            $attributes['bedrooms']  = $secondLevel[1];
            $attributes['bathrooms'] = $secondLevel[2];
            $attributes['sqft']      = $secondLevel[3];
            $attributes['test1']     = $secondLevel[4];
            $attributes['photo']     = $secondLevel[5];
            $attributes['lot']       = $secondLevel[6];
            $attributes['blank']     = $secondLevel[7];
            $attributes['sale']      = $secondLevel[8];
            $attributes['saletype']  = $secondLevel[9];
            $attributes['test2']     = $secondLevel[10];
            $attributes['test3']     = $secondLevel[12];
            $json[]                  = $attributes;
        }

        print_r(json_encode($json));
    }
}