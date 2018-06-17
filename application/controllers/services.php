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
        $url = 'https://www.zillow.com/search/GetResults.htm?spt=homes&status=110001&lt=111101&ht=100000&pr=200000,500000&mp=804,2011&bd=0%2C&ba=0%2C&sf=,&lot=0%2C&yr=,&singlestory=0&hoa=0%2C&pho=0&pets=0&parking=0&laundry=0&income-restricted=0&fr-bldg=0&condo-bldg=0&furnished-apartments=0&cheap-apartments=0&studio-apartments=0&pnd=0&red=0&zso=0&days=any&ds=all&pmf=1&pf=1&sch=100111&zoom=11&rect=-84715577,33843330,-84346505,34084511&p=1&sort=days&search=map&rid=12562&rt=6&listright=true&isMapSearch=true&zoom=11';
        $web = new WebBrowser();
        $result = $web->Process($url);

        $body       = json_decode($result['body']);
        $map        = $body->map;
        $properties = $map->properties;
        $json       = array();
        $zpids      = array();

        foreach( $properties as $property ) {
            $zpids[] = $property[0];
        }

        $databaseProperties = $this->checkDatabaseForProperties($zpids);
                
        foreach( $properties as $property ) {
            $secondLevel  = $property[8];
            $zpid         = $property[0];
            $propertyData = null;

            if ( isset($databaseProperties[$zpid]) ) {
                $propertyData = $databaseProperties[$zpid];

                $json[] = json_decode($propertyData);
                continue;
            }

            $propertyData['zpid']        = $property[0];
            $propertyData['latitude']    = substr_replace($property[1], '.', 2, 0);
            $propertyData['longitude']   = substr_replace($property[2], '.', 3, 0);
            $propertyData['price']       = $secondLevel[0];
            $propertyData['bedrooms']    = $secondLevel[1];
            $propertyData['bathrooms']   = $secondLevel[2];
            $propertyData['sqft']        = number_format($secondLevel[3], 0, '', ',');
            $propertyData['small_photo'] = $secondLevel[5];
            $propertyData['large_photo'] = $secondLevel[5];
            $propertyData['lot']         = $secondLevel[6];
            $propertyData['sale']        = $secondLevel[8];
            $propertyData['saletype']    = $secondLevel[9];
            $propertyData['url']         = $this->getPropertyUrl($web, $zpid);
            $propertyData['address']     = $this->getPropertyAddress($propertyData['url'], $zpid);
            $json[]                      = $propertyData;
echo "<br>";
print_r($propertyData);
echo"<br>";
            $this->addPropertyToDatabase($zpid, json_encode($propertyData));
            exit;
        }        
    }

    public function getPropertyAddress($url, $zpid) {
        $url     = str_replace('https://www.zillow.com/homedetails/', '', $url);
        $zpidPos = strpos($url, '/' . $zpid);
        $address = substr($url, 0, $zpidPos);
        $address = str_replace('-', ' ', $address);

        return $address;
    }

    public function getPropertyUrl($web, $zpid) {
        $url = 'https://www.zillow.com/homedetails//' . $zpid . '_zpid/';
        $result = $web->Process($url);

        return $result['url'];
    }

    public function checkDatabaseForProperties($zpids) {
        // id
        // zpid
        // response
        // data_modified

        $listOfZpids = implode(', ', $zpids);

        $query = sprintf(
            "SELECT
                id AS id,
                zpid AS zpid,
                response AS response
            FROM
                properties
            WHERE
                zpid IN (%s)"
        , $listOfZpids);

        /*
        $query = sprintf(
            "SELECT
                id AS id,
                zpid AS zpid,
                response AS response
            FROM
                properties
            WHERE
                zpid IN (:zpids)"
        );
        */

        $query = $this->_dbh->prepare($query);

        //$query->bindParam(':zpids', $listOfZpids, PDO::PARAM_STR);

        $query->execute();

        $properties = array();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $properties[$row['zpid']] = $row;
        }

        return $properties;
    }

    public function addPropertyToDatabase($zpid, $propertyData) {
        $query = sprintf(
            "INSERT INTO
                properties (zpid, response)
             values
                (:zpid, :response)"
        );

        $query = $this->_dbh->prepare($query);

        $query->bindParam(":zpid", $zpid);
        $query->bindParam(":response", $propertyData);

        return $query->execute();
    }

    public function getPropertyData($zpid) {
        $propertyData = file_get_contents('http://www.zillow.com/webservice/GetUpdatedPropertyDetails.htm?zws-id=' . ZILLOW_KEY . '&zpid=' . $zpid);
        //http://www.zillow.com/webservice/GetUpdatedPropertyDetails.htm?zws-id=X1-ZWz1ghhd0anevf_5upah&zpid=48749425

        return $propertyData;
    }
}