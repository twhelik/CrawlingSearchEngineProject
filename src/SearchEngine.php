<?php 
namespace SearchEngine;

include_once __DIR__ . '/simple_html_dom.php';

use simple_html_dom;

class SearchEngine
{
	/**
     * The searchEngine used for fetching data
     *
     * @var string
     */
	public $searchEngine;

	/**
     * The allowedEngines used to store the allowed search engines
     *
     * @var array
     */
	public $allowedEngines = array('google.com','google.ae');

	/**
     * Constructor will set the searchEngine to a default value
     *
     */
    public function __construct()
    {
        $this->searchEngine = 'https://google.com';
    }

	/**
     * Set searchEngine from the parameter passed or use the default one google.com
     *
     * @param  string $engine
     */

	public function setEngine($engine = 'google.com')
	{
		//if non-allowed search engine passed, then it will be skipped here 
		$engin_param   = in_array($engine, $this->allowedEngines) ? $engine : 'google.com';

		$formatted_url = $this->addhttp($engine);

		$this->searchEngine = $formatted_url;
	}

	/**
     * Format the searchEngine provided
     *
     * @param  string $url
     */
	public function addhttp($url) 
	{
	    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
	        $url = "https://" . $url;
	    }
	    return $url;
	}

	/**
     * @param  array $keywords
     * @return instance of ArrayIterator
     * @ignore
     */
    public function search($keywords = array())
    {
    	ini_set('memory_limit', '-1');
    	$result = array();
        if(count($keywords) > 0)
        {
        	$result_flag = false;
        	foreach ($keywords as $key => $keyword) {
        		$records_count = 0;
				$rank = 0;
				//Random User Agent is used to prevent ip blocking
				// $rand_user_agent = $this->RandomUserAgent();
				$rand_user_agent = $_SERVER['HTTP_USER_AGENT'];
        		for ($i=0; $i < 50; $i++) {
        			if($rank >= 50 || ($i > 0 && !$result_flag))
        				break;
        			else
        				$result_flag = false;
        			$page = 10 * $i;
        			$curl = curl_init();   
	                $url = $this->searchEngine . "/search?q=". urlencode($keyword) ."&start=". $page;
	                curl_setopt_array($curl, array(
	                    CURLOPT_URL => $url,
	                    CURLOPT_RETURNTRANSFER => true,
	                    CURLOPT_FOLLOWLOCATION => true,
	                    // CURLOPT_CAINFO => 'cacert.pem',
	                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	                    CURLOPT_USERAGENT => $rand_user_agent,
	                    CURLOPT_SSL_VERIFYPEER => false
	                ));
	                $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	                if (curl_errno($curl)) {
		                curl_close($curl);
		            } else {
		                $response = curl_exec($curl);
		                // print_r($response);
		                $dom      = new simple_html_dom();
		                $dom->load($response);
		                
		                foreach($dom->find('div#tads') as $tg) {
		                	$result_flag = true;
		                	if($rank>=50)
        						break;
		                	foreach($tg->find('div[data-text-ad="1"]') as $stg) {
		                		if($rank>=50)
        							break;
							    $ad_h3 = $stg->find('div[role="heading"]', 0);
							    $ad_a = ($stg !== '') ? $stg->find('a', 0) : '';
							    $link = $ad_a->href;
							    $desc = $stg->find('div.MUxGbd div', 0);
							    $rank++;
				            
					            $result[] = array(
					            	'keyword' => $keyword,
					                'rank' => $rank,
					                'title' => (isset($ad_h3)) ? strip_tags($ad_h3->innertext) : '', 
					                'url' => $link, 
					                'description' => (isset($desc)) ? strip_tags($desc->innertext) : '',
					                'promoted' => 1 
					            );
					        }
					    }

		                foreach($dom->find('div#search') as $g) {
		                	$result_flag = true;
		                	if($rank>=50)
        						break;
		                	foreach($g->find('div.g') as $sg) {
		                		if($rank>=50)
        							break;
							    $h3 = $sg->find('a h3', 0);
							    $a = ($sg !== '') ? $sg->find('a', 0) : '';
							    $link = $a->href;
							    $desc = $sg->find('div.VwiC3b.yXK7lf', 0);
							    $rank++;
				            
					            $result[] = array(
					            	'keyword' => $keyword,
					                'rank' => $rank,
					                'title' => (isset($h3)) ? strip_tags($h3->innertext)  : '', 
					                'url' => $link, 
					                'description' => (isset($desc)) ? strip_tags($desc->innertext) : '',
					                'promoted' => 0 
					            );
					        }
					    }
		                curl_close($curl);
		            }
        		}
            }
        }
        return $result;
    }
    public function RandomUserAgent()
    {
        $user_agent_list = [
		  'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_5) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.1 Safari/605.1.15',
		  'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:77.0) Gecko/20100101 Firefox/77.0',
		  'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.97 Safari/537.36',
		  'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:77.0) Gecko/20100101 Firefox/77.0',
		  'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.97 Safari/537.36',
		];
        $random_keys=array_rand($user_agent_list);
        return $user_agent_list[$random_keys];
    }
}
?>