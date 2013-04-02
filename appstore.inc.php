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
	public function APPSTORE($appID) {
		/*
		
		Initialize the class
		
		*/
		
		$this->_appID = $appID;
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
 		
 		$url = "http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/ws/RSS/top".$type."applications/sf=143441/limit=100/genre=".$categoryID."/xml";
	 	$ch = curl_init();
	    curl_setopt( $ch, CURLOPT_USERAGENT, "iTunes/10.5 (Macintosh; U; Mac OS X 10.6)");
	    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('X-Apple-Store-Front: 143441-1'));
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
	    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('X-Apple-Store-Front: 143441-1'));
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
	private function parseVersionDate($string) {
		/*
		
		Parses out the version and date strings and returns them
		
		*/
		
		$arrValues = explode("-", $string);
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
	private function throwException($message) {
		/*
		
			Throw an exception
			
		*/
		
		throw new Exception($message); 
	}
}



?>
