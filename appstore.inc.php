<?php
/*

Copyright (c) 2013 Alan Beebe

Permission is hereby granted, free of charge, to any person obtaining a copy of this
software and associated documentation files (the "Software"), to deal in the Software
without restriction, including without limitation the rights to use, copy, modify, merge,
publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons
to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or
substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE
FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
DEALINGS IN THE SOFTWARE.

*/

class APPSTORE {

	protected $_country;
	protected $_appID;
	protected $_appName;
	protected $_appIcon;
	protected $_appDeveloper;
	protected $_appTotalStars;
	protected $_appTotalRatings;
	protected $_appCurrentStars;
	protected $_appCurrentRatings;
	protected $_appCategoryName;
	protected $_appCategoryID;
	protected $_appRankCategory;
	protected $_appRankCategoryGrossing;
	
/* ------------------------------------------------------------------- */
	public function APPSTORE($appID = "", $country = "US") {
		/*
		
		Initialize the class
		
		*/
		
		$this->_appID = $appID;
		$this->_country = $country;
	}




/* ------------------------------------------------------------------- */
	public function appName() {
		/*
		
		Returns the apps name
		
		*/
		
		if (strlen($this->_appName) == 0) {
			$this->reviewsForPage(0);
		}
		return $this->_appName;
	}




/* ------------------------------------------------------------------- */
	public function appIcon() {
		/*
		
		Returns the apps icon URL
		
		*/
		
		if (strlen($this->_appIcon) == 0) {
			$this->reviewsForPage(0);
		}
		return $this->_appIcon;
	}




/* ------------------------------------------------------------------- */
	public function appAvailableCountries() {
		/*
		
		Searches all the international App Stores and returns an array of countries where the app is available
		
		*/
		

		// Array of countries that have an App Store
		$arrCountries = array("AL","DZ","AO","AI","AG","AR","AM","AU","AT","AZ","BS","BH","BD","BB",
							  "BY","BE","BZ","BJ","BM","BT","BO","BW","BR","BN","BG","BF","KH","CM",
							  "CA","CV","KY","TD","CL","CN","CO","CG","CR","CI","HR","CY","CZ","DK",
							  "DM","DO","EC","EG","SV","EE","ET","FJ","FI","FR","GM","DE","GH","GR",
							  "GD","GT","GW","GY","HN","HK","HU","IS","IN","ID","IE","IL","IT","JM",
							  "JP","JO","KZ","KE","KR","KW","KG","LA","LV","LB","LR","LY","LI","LT",
							  "LU","MO","MK","MG","MW","MY","MV","ML","MT","MR","MU","MX","FM","MD",
							  "MN","MS","MZ","MM","NA","NP","NL","NZ","NI","NE","NG","NO","OM","PK",
							  "PW","PS","PA","PG","PY","PE","PH","PL","PT","QA","RO","RU","KN","LC",
							  "VC","ST","SA","SN","RS","SC","SL","SG","SK","SI","SB","ZA","ES","LK",
							  "SR","SZ","SE","CH","TW","TJ","TZ","TH","TT","TN","TR","TM","TC","UG",
							  "UA","AE","GB","US","UY","UZ","VE","VN","VG","YE","ZW");


		// Generate the API URLs
		$arrAppStores = array();
		foreach ($arrCountries as $country) {
			array_push($arrAppStores, array("country"=>$country, "url"=>"http://itunes.apple.com/lookup?id=".$this->_appID."&country=".$country));
		}
		
		// Query all the App Store URLs
		$curl_array = array();
		$ch = curl_multi_init();
		foreach($arrAppStores as $index=>$appStore) {
			$curl_array[$index] = curl_init($appStore["url"]);
			curl_setopt($curl_array[$index], CURLOPT_RETURNTRANSFER, 1);
			curl_multi_add_handle($ch, $curl_array[$index]);
		}
		do { curl_multi_exec($ch, $exec); } while($exec > 0);
		
		// Process the responses
		$arrAvailableCountries = array();
		foreach($arrAppStores as $index => $appStore) {
			$response = curl_multi_getcontent($curl_array[$index]);
			$arrResponse = json_decode($response, true);
			if ($arrResponse["resultCount"] > 0) {
				array_push($arrAvailableCountries, $appStore["country"]);
			}
		}

		return $arrAvailableCountries;
	}
	
	
	
	
/* ------------------------------------------------------------------- */
	public function appDeveloper() {
		/*
		
		Returns the apps developer
		
		*/
		
		if (strlen($this->_appDeveloper) == 0) {
			$this->reviewsForPage(0);
		}
		return $this->_appDeveloper;
	}




/* ------------------------------------------------------------------- */
	public function appTotalStars() {
		/*
		
		Returns the apps total number of stars
		
		*/
		
		if (strlen($this->_appTotalStars) == 0) {
			$this->reviewsForPage(0);
		}
		return $this->_appTotalStars;
	}




/* ------------------------------------------------------------------- */
	public function appTotalRatings() {
		/*
		
		Returns the apps total number of ratings
		
		*/
		
		if (strlen($this->_appTotalRatings) == 0) {
			$this->reviewsForPage(0);
		}
		return $this->_appTotalRatings;
	}




/* ------------------------------------------------------------------- */
	public function appCurrentStars() {
		/*
		
		Returns the apps current number of stars
		
		*/
		
		if (strlen($this->_appCurrentStars) == 0) {
			$this->reviewsForPage(0);
		}
		return $this->_appCurrentStars;
	}




/* ------------------------------------------------------------------- */
	public function appCurrentRatings() {
		/*
		
		Returns the apps current number of ratings
		
		*/
		
		if (strlen($this->_appCurrentRatings) == 0) {
			$this->reviewsForPage(0);
		}
		return $this->_appCurrentRatings;
	}




/* ------------------------------------------------------------------- */
	public function appCategoryName() {
		/*
		
		Returns the apps category name
		
		*/
		
		if (strlen($this->_appCategoryName) == 0) {
			$this->reviewsForPage(0);
		}
		
		switch ($this->_appCategoryID) {
			case 1:
				return "";
				break;
				
			default:
				return ucwords($this->_appCategoryName);
		}
	}




/* ------------------------------------------------------------------- */
	public function appCategoryID() {
		/*
		
		Returns the apps category ID
		
		*/
		
		if (strlen($this->_appCategoryID) == 0) {
			$this->reviewsForPage(0);
		}
		return $this->_appCategoryID;
	}




/* ------------------------------------------------------------------- */
	public function appRankCategory() {
		/*
		
		Returns the apps rank in its category
		
		*/
		
		if (strlen($this->_appRankCategory) == 0) {
			$this->ranksForCategory($this->_appCategoryID);
		}
		
		if ($this->_appRankCategory == "") {
			return "100+";
		} else {
			return $this->_appRankCategory;
		}
	}




/* ------------------------------------------------------------------- */
	public function appRankCategoryGrossing() {
		/*
		
		Returns the apps grossing rank in its category
		
		*/
		
		if (strlen($this->_appRankCategoryGrossing) == 0) {
			$this->ranksForCategory($this->_appCategoryID);
		}
		
		if ($this->_appRankCategoryGrossing == "") {
			return "100+";
		} else {
			return $this->_appRankCategoryGrossing;
		}
	}




/* ------------------------------------------------------------------- */
	public function reviewsForPage($page) {
		/*
		
		Returns the reviews for the specified page.  The first page is 0
		
		*/
		

		$xmlContent = $this->downloadContentForPage($page);		
		$this->_appDeveloper = (string)$xmlContent->Path->PathElement[1]["displayName"];
		$this->_appName = (string)$xmlContent->Path->PathElement[2]["displayName"];
		$this->_appIcon = (string)$xmlContent->View->ScrollView->VBoxView->View->MatrixView->VBoxView[0]->HBoxView[0]->VBoxView[0]->VBoxView->MatrixView->GotoURL->View->PictureView["url"];
		$this->_appTotalStars = $this->parseStars((string)$xmlContent->View->ScrollView->VBoxView->View->MatrixView->VBoxView[0]->HBoxView[0]->VBoxView[1]->VBoxView->View->View->View->VBoxView->Test->VBoxView[0]->HBoxView->VBoxView[1]->HBoxView["alt"]);
		$this->_appTotalRatings = $this->parseRatings((string)$xmlContent->View->ScrollView->VBoxView->View->MatrixView->VBoxView[0]->HBoxView[0]->VBoxView[1]->VBoxView->View->View->View->VBoxView->Test[0]->VBoxView[0]->HBoxView->VBoxView[2]->TextView->SetFontStyle);
		$this->_appCurrentStars = $this->parseStars((string)$xmlContent->View->ScrollView->VBoxView->View->MatrixView->VBoxView[0]->HBoxView[0]->VBoxView[1]->VBoxView->View->View->View->VBoxView->Test[1]->VBoxView[0]->HBoxView->VBoxView[2]->HBoxView["alt"]);
		$this->_appCurrentRatings = $this->parseRatings((string)$xmlContent->View->ScrollView->VBoxView->View->MatrixView->VBoxView[0]->HBoxView[0]->VBoxView[1]->VBoxView->View->View->View->VBoxView->Test[1]->VBoxView[1]->HBoxView->VBoxView[2]->TextView->SetFontStyle);
		list ($this->_appCategoryName, $this->_appCategoryID) = $this->parseCategory((string)$xmlContent->Path->PathElement[0]);
		return $this->generateReviews($xmlContent->View->ScrollView->VBoxView->View->MatrixView->VBoxView[0]->VBoxView);
	}
	
	
	

/* ------------------------------------------------------------------- */
	public function userReviewsForPage($userID, $page = 0) {
		/*
		
		Returns the reviews a user has left for a specified page.  The first page is 0
		
		*/
		
		// Download the users reviews
		$page++;
		$url = "http://itunes.apple.com//WebObjects/MZStore.woa/wa/allUserReviewsForReviewerFragment?userProfileId=".$userID."&page=".$page."&sort=14";
		$ch = curl_init();
	    curl_setopt( $ch, CURLOPT_USERAGENT, "iTunes/10.5 (Macintosh; U; Mac OS X 10.6)");
	    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('X-Apple-Store-Front: '.$this->storefrontForCountry($this->_country)));
	    curl_setopt( $ch, CURLOPT_URL, $url);
	    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt( $ch, CURLOPT_ENCODING, "");
	    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt( $ch, CURLOPT_AUTOREFERER, true);
	    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 30);
	    curl_setopt( $ch, CURLOPT_TIMEOUT, 30);
	    curl_setopt( $ch, CURLOPT_MAXREDIRS, 10);
	    $response = curl_exec($ch); 
	    curl_close ($ch);
	    
	    // Parse the users reviews
	    $domdocument = new DOMDocument();
	    @$domdocument->loadHTML($response);
	    $domPath = new DOMXPath($domdocument);
	    $domReviews = $domPath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' customer-review ')]");
		$arrReviews = array();
		foreach ($domReviews as $domReview) {
			$arrReview = array();
			$arrReview["app_name"] = trim($domReview->getElementsByTagName('div')->item(2)->getAttribute("aria-label"));
			$arrReview["app_id"] = trim($domReview->getElementsByTagName('button')->item(0)->getAttribute("adam-id"));
			$arrReview["app_icon"] = trim($domReview->getElementsByTagName('img')->item(0)->getAttribute("src-swap-high-dpi"));
			$arrReview["developer_name"] = trim($domReview->getElementsByTagName('a')->item(2)->nodeValue);
			$arrReview["developer_id"] = $this->parseDeveloperID($domReview->getElementsByTagName('a')->item(2)->getAttribute("href"));
			$arrReview["review"] = trim($domReview->getElementsByTagName('p')->item(0)->nodeValue);
			$arrReview["title"] = trim($domReview->getElementsByTagName('div')->item(9)->nodeValue);
			if ($domReview->getElementsByTagName('div')->length == 15) {
				$arrReview["stars"] = $this->parseStars($domReview->getElementsByTagName('div')->item(11)->getAttribute("aria-label"));
				$arrReview["date_string"] = trim($domReview->getElementsByTagName('div')->item(13)->nodeValue, " \n\r\t");
			} else {
				$arrReview["stars"] = $this->parseStars($domReview->getElementsByTagName('div')->item(12)->getAttribute("aria-label"));
				$arrReview["date_string"] = trim($domReview->getElementsByTagName('div')->item(14)->nodeValue, " \n\r\t");
			}
			$arrReview["date_epoch"] = strtotime($arrReview["date_string"]);
			array_push($arrReviews, $arrReview);
/*
			$x = 0;
			foreach ($domReview->getElementsByTagName('a') as $blah) {
				$x++;
				print $x." = ".$blah->getAttribute("href")."\n";
				//print $x." = ".$blah->nodeValue."\n";
			}
*/
		}

	    return $arrReviews;
	}
	
	
	
	
/* ------------------------------------------------------------------- */
	public function ranksForCategory($categoryID = null) {
		/*
		
		Download and process the how the app ranks in its category (paid, free, grossing)
		
		*/
		
		if (!$categoryID) $categoryID = $this->appCategoryID();
		
		// Download the paid ranking
		$xmlContentPaid = $this->downloadRanksForCategory("paid", $categoryID);
		$rankCategory = "";
		for ($x = 0; $x < sizeof($xmlContentPaid->entry); $x++) {
			$xmlApp = $xmlContentPaid->entry[$x];
			if(stristr((string)$xmlApp->id, "id".$this->_appID)) {
				$rankCategory = ($x+1);
				break;
			}
		}
		
		// Download the free ranking if no paid ranking was found
		if ($rankCategory == "") {
			$xmlContentPaid = $this->downloadRanksForCategory("free", $categoryID);
			for ($x = 0; $x < sizeof($xmlContentPaid->entry); $x++) {
				$xmlApp = $xmlContentPaid->entry[$x];
				if(stristr((string)$xmlApp->id, "id".$this->_appID)) {
					$rankCategory = ($x+1);
					break;
				}
			}
		}
		
		// Download the grossing ranking
		$xmlContentPaid = $this->downloadRanksForCategory("grossing", $categoryID);
		$rankGrossing = "";
		for ($x = 0; $x < sizeof($xmlContentPaid->entry); $x++) {
			$xmlApp = $xmlContentPaid->entry[$x];
			if(stristr((string)$xmlApp->id, "id".$this->_appID)) {
				$rankGrossing = ($x+1);
				break;
			}
		}
		
		// Store the rankings
		if ($categoryID == $this->appCategoryID()) {
			$this->_appRankCategory = $rankCategory;
			$this->_appRankCategoryGrossing = $rankGrossing;
		}
		
		return array("category"=>$rankCategory, "grossing"=>$rankGrossing);
	}
	
	
	
	
/* ------------------------------------------------------------------- */
 	private function downloadRanksForCategory($type, $categoryID) {
 		/*
 		
 		Returns the ranks for the specificied category type and ID
 		
 		*/
 		
 		$url = "http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/ws/RSS/top".$type."applications/sf=".$this->storefrontForCountry($this->_country)."/limit=100/genre=".$categoryID."/xml";
	 	$ch = curl_init();
	    curl_setopt( $ch, CURLOPT_USERAGENT, "iTunes/10.5 (Macintosh; U; Mac OS X 10.6)");
	    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('X-Apple-Store-Front: '.$this->storefrontForCountry($this->_country)));
	    curl_setopt( $ch, CURLOPT_URL, $url);
	    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt( $ch, CURLOPT_ENCODING, "");
	    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt( $ch, CURLOPT_AUTOREFERER, true);
	    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 30);
	    curl_setopt( $ch, CURLOPT_TIMEOUT, 30);
	    curl_setopt( $ch, CURLOPT_MAXREDIRS, 10);
	    $response = curl_exec($ch); 
	    curl_close ($ch);
	    return new SimpleXMLElement($response);
	}
	
	
	
	
/* ------------------------------------------------------------------- */
	private function downloadContentForPage($pageNumber) {
		/*
		
		Download the content
		
		*/
	
		$url = "http://ax.phobos.apple.com.edgesuite.net/WebObjects/MZStore.woa/wa/viewContentsUserReviews?id=".$this->_appID."&pageNumber=".$pageNumber."&sortOrdering=4&type=Purple+Software";
		$ch = curl_init();
	    curl_setopt( $ch, CURLOPT_USERAGENT, "iTunes/10.5 (Macintosh; U; Mac OS X 10.6)");
	    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('X-Apple-Store-Front: '.$this->storefrontForCountry($this->_country)));
	    curl_setopt( $ch, CURLOPT_URL, $url);
	    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt( $ch, CURLOPT_ENCODING, "");
	    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt( $ch, CURLOPT_AUTOREFERER, true);
	    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 30);
	    curl_setopt( $ch, CURLOPT_TIMEOUT, 30);
	    curl_setopt( $ch, CURLOPT_MAXREDIRS, 10);
	    $response = curl_exec($ch); 
	    curl_close ($ch);
	    return new SimpleXMLElement($response);
	}	




/* ------------------------------------------------------------------- */
	private function generateReviews($xmlContent) {
		/*
		
		Generates the reviews
		
		*/
		

		$arrReviews = array();
		for ($x = 0; $x < sizeof($xmlContent->VBoxView); $x++) {
			$arrReview = array();
			$arrReview["id"] = $this->parseReviewID((string)$xmlContent->VBoxView[$x]->HBoxView[0]->HBoxView->HBoxView[1]->VBoxView[0]->GotoURL["url"]);
			$arrReview["title"] = (string)$xmlContent->VBoxView[$x]->HBoxView->TextView->SetFontStyle->b;
			$arrReview["review"] = (string)$xmlContent->VBoxView[$x]->TextView->SetFontStyle;
			$arrReview["stars"] = preg_replace("/[^0-9]/", "", (string)$xmlContent->VBoxView[$x]->HBoxView[0]->HBoxView->HBoxView[0]["alt"]);
			$arrReview["user_name"] = trim((string)$xmlContent->VBoxView[$x]->HBoxView[1]->TextView->SetFontStyle->GotoURL->b);
			$arrReview["user_url"] = (string)$xmlContent->VBoxView[$x]->HBoxView[1]->TextView->SetFontStyle->GotoURL["url"];
			$arrReview["user_id"] = $this->parseUserID($arrReview["user_url"]);
			list($arrReview["version"], $arrReview["date_string"]) = $this->parseVersionDate((string)$xmlContent->VBoxView[$x]->HBoxView[1]->TextView->SetFontStyle);
			$arrReview["date_epoch"] = strtotime($arrReview["date_string"]);
			array_push($arrReviews, $arrReview);
		}
		
		return $arrReviews;
	}
	
	
	

/* ------------------------------------------------------------------- */		
	private function parseCategory($string) {
		/*
		
		Parses out the category name and ID and returns them
		
		*/
		
		
		preg_match("/.*ios-(.*)\/id(.*)\?/i", $string, $results);
		$name = $results[1];
		$id = $results[2];
		return array($name, $id);
	}
	
	
	

/* ------------------------------------------------------------------- */		
	private function parseDeveloperID($string) {
		/*
		
		Parses out the developer ID and returns it
		
		*/
		
		
		preg_match("/id(.*)/i", $string, $results);
		return $results[1];
	}
	
	
	
		
/* ------------------------------------------------------------------- */		
	private function parseVersionDate($string) {
		/*
		
		Parses out the version and date strings and returns them
		
		*/
		
		$arrValues = explode(" - ", $string);
		$version = preg_replace("/[^0-9.]/", "", trim($arrValues[1]));
		$date = trim($arrValues[2]);
		return array($version, $date);
	}
	
	
	

/* ------------------------------------------------------------------- */
	private function parseUserID($url) {
		/*
		
		Parses out the user id from a URL and returns it
		
		*/
		
		$arrURL = parse_url($url);
		parse_str($arrURL["query"], $arrQuery);
		return $arrQuery["userProfileId"];
	}
	
	
	

/* ------------------------------------------------------------------- */
	private function parseStars($string) {
		/*
		
		Parses out the number of stars and returns it
		
		*/
		
		$hasHalfStar = (strripos($string, "half")) ? true : false;
		$stars = preg_replace("/[^0-9]/", "", $string);
		if ($hasHalfStar) $stars .= ".5";
		return $stars;
	}
	
	
	

/* ------------------------------------------------------------------- */
	private function parseRatings($string) {
		/*
		
		Parses out the number of ratings and returns it
		
		*/
		
		return preg_replace("/[^0-9]/", "", $string);
	}
	
	
	

/* ------------------------------------------------------------------- */
	private function parseReviewID($url) {
		/*
		
		Parses out the review id from a URL and returns it
		
		*/
		
		$arrURL = parse_url($url);
		parse_str($arrURL["query"], $arrQuery);
		return $arrQuery["userReviewId"];
	}	
	
	
	

/* ------------------------------------------------------------------- */
	public function storefrontForCountry($country) {
		/*
		
		Returns the storefront for the requested country.  Throws an exception if the storefront cannot be found
		
		*/
		
		$country = strtoupper($country);
		$arrCountries = array();
		$arrCountries["CA"] = array("storefront"=>"143455-6,12", "country"=>"Canada");
		$arrCountries["US"] = array("storefront"=>"143441-1,12", "country"=>"United States");
		$arrCountries["BY"] = array("storefront"=>"143565,12", "country"=>"Belarus");
		$arrCountries["BE"] = array("storefront"=>"143446-2,12", "country"=>"Belgium");
		$arrCountries["BG"] = array("storefront"=>"143526,12", "country"=>"Bulgaria");
		$arrCountries["HR"] = array("storefront"=>"143494,12", "country"=>"Croatia");
		$arrCountries["CY"] = array("storefront"=>"143557-2,12", "country"=>"Cyprus");
		$arrCountries["CZ"] = array("storefront"=>"143489,12", "country"=>"Czech Republic");
		$arrCountries["DK"] = array("storefront"=>"143458-2,12", "country"=>"Denmark");
		$arrCountries["DE"] = array("storefront"=>"143443,12", "country"=>"Germany");
		$arrCountries["ES"] = array("storefront"=>"143454-8,12", "country"=>"Spain");
		$arrCountries["EE"] = array("storefront"=>"143518,12", "country"=>"Estonia");
		$arrCountries["FI"] = array("storefront"=>"143447-2,12", "country"=>"Finland");
		$arrCountries["FR"] = array("storefront"=>"143442,12", "country"=>"France");
		$arrCountries["GR"] = array("storefront"=>"143448,12", "country"=>"Greece");
		$arrCountries["HU"] = array("storefront"=>"143482,12", "country"=>"Hungary");
		$arrCountries["IS"] = array("storefront"=>"143558,12", "country"=>"Iceland");
		$arrCountries["IE"] = array("storefront"=>"143449,12", "country"=>"Ireland");
		$arrCountries["IT"] = array("storefront"=>"143450,12", "country"=>"Italy");
		$arrCountries["LV"] = array("storefront"=>"143519,12", "country"=>"Latvia");
		$arrCountries["LT"] = array("storefront"=>"143520,12", "country"=>"Lithuania");
		$arrCountries["LU"] = array("storefront"=>"143451-2,12", "country"=>"Luxembourg");
		$arrCountries["MK"] = array("storefront"=>"143530,12", "country"=>"Macedonia");
		$arrCountries["MT"] = array("storefront"=>"143521,12", "country"=>"Malta");
		$arrCountries["MD"] = array("storefront"=>"143523,12", "country"=>"Moldova");
		$arrCountries["NL"] = array("storefront"=>"143452,12", "country"=>"Nederland");
		$arrCountries["NO"] = array("storefront"=>"143457-2,12", "country"=>"Norway");
		$arrCountries["AT"] = array("storefront"=>"143445,12", "country"=>"Austria");
		$arrCountries["PL"] = array("storefront"=>"143478,12", "country"=>"Poland");
		$arrCountries["PT"] = array("storefront"=>"143453,12", "country"=>"Portugal");
		$arrCountries["RO"] = array("storefront"=>"143487,12", "country"=>"Romania");
		$arrCountries["SK"] = array("storefront"=>"143496,12", "country"=>"Slovakia");
		$arrCountries["SI"] = array("storefront"=>"143499,12", "country"=>"Slovenia");
		$arrCountries["SE"] = array("storefront"=>"143456,12", "country"=>"Sweden");
		$arrCountries["CH"] = array("storefront"=>"143459-2,12", "country"=>"Switzerland");
		$arrCountries["TR"] = array("storefront"=>"143480,12", "country"=>"Turkey");
		$arrCountries["UK"] = array("storefront"=>"143444,12", "country"=>"United Kingdom");
		$arrCountries["RU"] = array("storefront"=>"143469,12", "country"=>"Russia");
		$arrCountries["DZ"] = array("storefront"=>"143563,12", "country"=>"Algeria");
		$arrCountries["AO"] = array("storefront"=>"143564,12", "country"=>"Angola");
		$arrCountries["AM"] = array("storefront"=>"143524,12", "country"=>"Armenia");
		$arrCountries["AZ"] = array("storefront"=>"143568,12", "country"=>"Azerbaijan");
		$arrCountries["BH"] = array("storefront"=>"143559,12", "country"=>"Bahrain");
		$arrCountries["BW"] = array("storefront"=>"143525,12", "country"=>"Botswana");
		$arrCountries["EG"] = array("storefront"=>"143516,12", "country"=>"Egypt");
		$arrCountries["GH"] = array("storefront"=>"143573,12", "country"=>"Ghana");
		$arrCountries["IN"] = array("storefront"=>"143467,12", "country"=>"India");
		$arrCountries["IL"] = array("storefront"=>"143491,12", "country"=>"Israel");
		$arrCountries["JO"] = array("storefront"=>"143528,12", "country"=>"Jordan");
		$arrCountries["KE"] = array("storefront"=>"143529,12", "country"=>"Kenya");
		$arrCountries["KW"] = array("storefront"=>"143493,12", "country"=>"Kuwait");
		$arrCountries["LB"] = array("storefront"=>"143497,12", "country"=>"Lebanon");
		$arrCountries["MG"] = array("storefront"=>"143531,12", "country"=>"Madagascar");
		$arrCountries["ML"] = array("storefront"=>"143532,12", "country"=>"Mali");
		$arrCountries["MU"] = array("storefront"=>"143533,12", "country"=>"Mauritius");
		$arrCountries["NE"] = array("storefront"=>"143534,12", "country"=>"Niger");
		$arrCountries["NG"] = array("storefront"=>"143561,12", "country"=>"Nigeria");
		$arrCountries["OM"] = array("storefront"=>"143562,12", "country"=>"Oman");
		$arrCountries["QA"] = array("storefront"=>"143498,12", "country"=>"Qatar");
		$arrCountries["SA"] = array("storefront"=>"143479,12", "country"=>"Saudi Arabia");
		$arrCountries["SN"] = array("storefront"=>"143535,12", "country"=>"Senegal");
		$arrCountries["ZA"] = array("storefront"=>"143472,12", "country"=>"South Africa");
		$arrCountries["TZ"] = array("storefront"=>"143572,12", "country"=>"Tanzania");
		$arrCountries["TN"] = array("storefront"=>"143536,12", "country"=>"Tunisia");
		$arrCountries["AE"] = array("storefront"=>"143481,12", "country"=>"UAE");
		$arrCountries["UG"] = array("storefront"=>"143537,12", "country"=>"Uganda");
		$arrCountries["YE"] = array("storefront"=>"143571,12", "country"=>"Yemen");
		$arrCountries["AU"] = array("storefront"=>"143460,12", "country"=>"Australia");
		$arrCountries["BN"] = array("storefront"=>"143560,12", "country"=>"Brunei Darussalam");
		$arrCountries["CN"] = array("storefront"=>"143465-2,12", "country"=>"China");
		$arrCountries["HK"] = array("storefront"=>"143463,12", "country"=>"Hong Kong");
		$arrCountries["ID"] = array("storefront"=>"143476,12", "country"=>"Indonesia");
		$arrCountries["JP"] = array("storefront"=>"143462-1,12", "country"=>"Japan");
		$arrCountries["KZ"] = array("storefront"=>"143517,12", "country"=>"Kazakhstan");
		$arrCountries["MO"] = array("storefront"=>"143515,12", "country"=>"Macau");
		$arrCountries["MY"] = array("storefront"=>"143473,12", "country"=>"Malaysia");
		$arrCountries["NZ"] = array("storefront"=>"143461,12", "country"=>"New Zealand");
		$arrCountries["PK"] = array("storefront"=>"143477,12", "country"=>"Pakistan");
		$arrCountries["PH"] = array("storefront"=>"143474,12", "country"=>"Philippines");
		$arrCountries["SG"] = array("storefront"=>"143464,12", "country"=>"Singapore");
		$arrCountries["LK"] = array("storefront"=>"143486,12", "country"=>"Sri Lanka");
		$arrCountries["TW"] = array("storefront"=>"143470,12", "country"=>"Taiwan");
		$arrCountries["TH"] = array("storefront"=>"143475,12", "country"=>"Thailand");
		$arrCountries["UZ"] = array("storefront"=>"143566,12", "country"=>"Uzbekistan");
		$arrCountries["VN"] = array("storefront"=>"143471,12", "country"=>"Vietnam");
		$arrCountries["KR"] = array("storefront"=>"143466,12", "country"=>"South Korea");
		$arrCountries["AI"] = array("storefront"=>"143538,12", "country"=>"Anguilla");
		$arrCountries["AG"] = array("storefront"=>"143540,12", "country"=>"Antigua and Barbuda");
		$arrCountries["AR"] = array("storefront"=>"143505-2,12", "country"=>"Argentina");
		$arrCountries["BS"] = array("storefront"=>"143539,12", "country"=>"Bahamas");
		$arrCountries["BB"] = array("storefront"=>"143541,12", "country"=>"Barbados");
		$arrCountries["BZ"] = array("storefront"=>"143555-2,12", "country"=>"Belize");
		$arrCountries["BM"] = array("storefront"=>"143542,12", "country"=>"Bermuda");
		$arrCountries["BO"] = array("storefront"=>"143556-2,12", "country"=>"Bolivia");
		$arrCountries["BR"] = array("storefront"=>"143503,12", "country"=>"Brasil");
		$arrCountries["VG"] = array("storefront"=>"143543,12", "country"=>"British Virgin Islands");
		$arrCountries["KY"] = array("storefront"=>"143544,12", "country"=>"Cayman Islands");
		$arrCountries["CL"] = array("storefront"=>"143483-2,12", "country"=>"Chile");
		$arrCountries["CO"] = array("storefront"=>"143501-2,12", "country"=>"Colombia");
		$arrCountries["CR"] = array("storefront"=>"143495-2,12", "country"=>"Costa Rica");
		$arrCountries["DM"] = array("storefront"=>"143545,12", "country"=>"Dominica");
		$arrCountries["DO"] = array("storefront"=>"143508-2,12", "country"=>"Dominican Republic");
		$arrCountries["EC"] = array("storefront"=>"143509-2,12", "country"=>"Ecuador");
		$arrCountries["SV"] = array("storefront"=>"143506-2,12", "country"=>"El Salvador");
		$arrCountries["GD"] = array("storefront"=>"143546,12", "country"=>"Grenada");
		$arrCountries["GT"] = array("storefront"=>"143504-2,12", "country"=>"Guatemala");
		$arrCountries["GY"] = array("storefront"=>"143553,12", "country"=>"Guyana");
		$arrCountries["HN"] = array("storefront"=>"143510-2,12", "country"=>"Honduras");
		$arrCountries["JM"] = array("storefront"=>"143511,12", "country"=>"Jamaica");
		$arrCountries["MX"] = array("storefront"=>"143468,12", "country"=>"Mexico");
		$arrCountries["MS"] = array("storefront"=>"143547,12", "country"=>"Montserrat");
		$arrCountries["NI"] = array("storefront"=>"143512-2,12", "country"=>"Nicaragua");
		$arrCountries["PA"] = array("storefront"=>"143485-2,12", "country"=>"Panama");
		$arrCountries["PY"] = array("storefront"=>"143513-2,12", "country"=>"Paraguay");
		$arrCountries["PE"] = array("storefront"=>"143507-2,12", "country"=>"Peru");
		$arrCountries["KN"] = array("storefront"=>"143548,12", "country"=>"St. Kitts and Nevis");
		$arrCountries["LC"] = array("storefront"=>"143549,12", "country"=>"St. Lucia");
		$arrCountries["VC"] = array("storefront"=>"143550,12", "country"=>"St. Vincent & The Grenadines");
		$arrCountries["SR"] = array("storefront"=>"143554-2,12", "country"=>"Suriname");
		$arrCountries["TT"] = array("storefront"=>"143551,12", "country"=>"Trinidad and Tobago");
		$arrCountries["TC"] = array("storefront"=>"143552,12", "country"=>"Turks & Caicos");
		$arrCountries["UY"] = array("storefront"=>"143514-2,12", "country"=>"Uruguay");
		$arrCountries["VE"] = array("storefront"=>"143502-2,12", "country"=>"Venezuela");

		if ($arrCountries[$country]["storefront"]) {
			return $arrCountries[$country]["storefront"];
		} else {
			$this->throwException("Unable to locate storefront for country ".$country);
		}
	}	
	
	
	
	
/* ------------------------------------------------------------------- */	
	private function throwException($message) {
		/*
		
			Throw an exception
			
		*/
		
		throw new Exception($message); 
	}
}



?>
