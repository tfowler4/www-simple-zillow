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
        $curl = curl_init();

        // http://www.zillow.com/webservice/GetSearchResults.htm?zws-id=X1-ZWz1ghhd0anevf_5upah&address=2325+Valley+Creek+Drive&citystatezip=30122
    
        // https://www.zillow.com/search/GetResults.htm?spt=homes&status=110001&lt=111101&ht=001000&pr=200000,500000&mp=803,2008&bd=5%2C&ba=3.0%2C&sf=3000,&lot=0%2C&yr=,&singlestory=0&hoa=0%2C&pho=0&pets=0&parking=0&laundry=0&income-restricted=0&fr-bldg=0&condo-bldg=0&furnished-apartments=0&cheap-apartments=0&studio-apartments=0&pnd=0&red=0&zso=0&days=any&ds=all&pmf=1&pf=1&sch=100111&zoom=10&rect=-84709397,33930542,-83971253,34159261&p=1&sort=days&search=map&rid=54219&rt=6&listright=true&isMapSearch=1&zoom=10

        // Get cURL resource
        $curl = curl_init();

        // Setting the HTTP Request Headers
        $User_Agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36';

        $request_headers = array();
        $request_headers[] = 'User-Agent: '. $User_Agent;
        $request_headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';

        // Set some options - we are passing in a useragent too here
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36');
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_URL, 'http://www.zillow.com/search/GetResults.htm?spt=homes&status=110001&lt=111101&ht=001000&pr=200000,500000&mp=803,2008&bd=0%2C&ba=0%2C&sf=,&lot=0%2C&yr=,&singlestory=0&hoa=0%2C&pho=0&pets=0&parking=0&laundry=0&income-restricted=0&fr-bldg=0&condo-bldg=0&furnished-apartments=0&cheap-apartments=0&studio-apartments=0&pnd=0&red=0&zso=0&days=any&ds=all&pmf=1&pf=0&sch=100111&zoom=10&rect=-84721756,33829071,-83983613,34058063&p=1&sort=days&search=map&rid=13709&rt=6&listright=true&isMapSearch=1&zoom=10');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
        curl_setopt($curl, CURLOPT_COOKIESESSION, TRUE);
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        curl_setopt($curl, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEFILE, 'cookie.txt');

        // Send the request & save response to $resp
        $response = curl_exec($curl);
        //$parser   = xml_parser_create();
        //$results  = array();

        // Close request to clear up some resources
        //curl_close($curl);

        //xml_parse_into_struct($parser, $response, $results);

        //xml_parser_free($parser);

        //$response = file_get_contents(urlencode('https://www.zillow.com/search/GetResults.htm?spt=homes&status=110001&lt=111101&ht=001000&pr=200000,500000&mp=803,2008&bd=5%2C&ba=3.0%2C&sf=3000,&lot=0%2C&yr=,&singlestory=0&hoa=0%2C&pho=0&pets=0&parking=0&laundry=0&income-restricted=0&fr-bldg=0&condo-bldg=0&furnished-apartments=0&cheap-apartments=0&studio-apartments=0&pnd=0&red=0&zso=0&days=any&ds=all&pmf=1&pf=1&sch=100111&zoom=10&rect=-84709397,33930542,-83971253,34159261&p=1&sort=days&search=map&rid=54219&rt=6&listright=true&isMapSearch=1&zoom=10'));
echo "<BR>START RESULTS<BR>";
        print_r($response);
        echo "<BR>END RESULTS<BR>";
        //print_r(json_encode($results));
    }
}