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

	header('Content-Type: text/html; charset=UTF-8');

	// Set the timezone to Apples servers so the dates are correct
	date_default_timezone_set("America/Los_Angeles"); 

	// Includes
	include ("appstore.inc.php");
	
	// Set the USER ID we want to get reviews for
	$userID = $_GET["id"];
	
	// Download the users most recent reviews
	$_APPSTORE = new APPSTORE();
	$arrReviews = array();
	for ($x = 0; $x < 5; $x++) {
		$arrReviewPage = $_APPSTORE->userReviewsForPage($userID, $x);
		if (sizeof($arrReviewPage) == 0) {
			break;
		} else {
			$arrReviews = array_merge($arrReviews, $arrReviewPage);
		}
	}
?>
<HTML>
	<HEAD>
		<TITLE><?= htmlentities($_GET["username"]); ?></TITLE>
		<META name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<STYLE media="screen" type="text/css">

			body {
				margin: 0px;
				font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
			}
			
			div.app-title {
				color: #3d3d3d;
				font-size: 13px;
				font-weight: bold;
				text-shadow: 0px 1px #ffffff;
			}
			
			div.app-developer {
				color: #646464;
				font-size: 13px;
				text-shadow: 0px 1px #ffffff;
			}
				
			div.comment-box-title {
				color: #4c4c4c;
				font-size: 13;
				font-weight: bold;
				margin-bottom: 10px;
				text-shadow: 0px 1px #ffffff;
			}
			
			div.comment-box-review {
				color: #4c4c4c;
				font-size: 13;
				margin-top: 10px;
				text-shadow: 0px 1px #ffffff;
			}
			
			div.comment-box {	
				position: relative;
			}
			
			div.comment-box-odd {
				padding: 15px;
				background-color: #ebebeb;
			}
			
			div.comment-box-even {
				padding: 15px;
				background-color: #f5f5f5;
			}
			
			div.comment-box-stars {
				margin: 20px 0px 10px 0px;
				color: #4c4c4c;
				font-size: 12;
				text-shadow: 0px 1px #ffffff;
			}
			
			img.app-icon {
				width: 38px;
				height: 38px;
				border-radius: 7px;
				-webkit-border-radius: 7px;
				-moz-border-radius: 7px;
			}			

			img.star-full {
				width: 12px;
				height: 13px;
				vertical-align:text-bottom;
				margin-right: 1px;
			}
			
			img.star-empty {
				width: 12px;
				height: 13px;
				vertical-align: text-bottom;
				margin-right: 1px;
			}
			
			img.star-full-small {
				width: 12px;
				height: 13px;
				vertical-align:text-bottom;
				margin-right: 1px;
			}
			
			img.star-half-small {
				width: 12px;
				height: 13px;
				vertical-align: text-bottom;
				margin-right: 1px;
			}
			
			img.star-empty-small {
				width: 12px;
				height: 13px;
				vertical-align: text-bottom;
				margin-right: 1px;
			}

			
		</STYLE>
	</HEAD>
	<BODY>

	
<?php
$userName = htmlentities($_GET["username"]);
for ($x = 0; $x < sizeof($arrReviews); $x++) {
	$review = $arrReviews[$x];
	if ($x % 2 == 0) {
		$boxType = "comment-box-even";
	} else {
		$boxType = "comment-box-odd";
	}
	$commentNumber = $x + 1;
	$appName = htmlentities($review["app_name"]);
	$title = htmlentities($review["title"]);
	$reviewComment = htmlentities($review["review"]);
	$appIcon = $review["app_icon"];
	$appDeveloper = htmlentities($review["developer_name"]);
	$reviewDate = htmlentities($review["date_string"]);
	$reviewComment = str_replace("\n", "<BR>", htmlentities($review["review"]));
	$reviewUserName = htmlentities($_GET["username"]);
	$reviewUserNameEncoded = urlencode($review["user_name"]);
	$urlAPP = "example.php?id=".urlencode($review["app_id"]);
	$htmlStars = htmlForStars($review["stars"]);
	
$HTML = <<<HTML
	<DIV CLASS="comment-box">
		<DIV CLASS="{$boxType}">
			<TABLE width="100%" cellpadding="0" cellspacing="0">
				<TR>
					<TD width="38" valign="top">
						<A href="{$urlAPP}" border="0"><IMG class="app-icon" src="{$appIcon}"></a>
					</TD>
					<TD width="10"></TD>
					<TD valign="top">
						<DIV class="app-title">{$appName}</DIV>
						<DIV class="app-developer">{$appDeveloper}</DIV>
					</TD>
				</TR>
			</TABLE>
			<DIV class="comment-box-stars">
			{$htmlStars} by {$userName} - {$reviewDate}
			</DIV>
			<DIV class="comment-box-title">{$title}</DIV>
			<DIV class="comment-box-review">{$reviewComment}</DIV>
		</DIV>
	</DIV>
	<DIV STYLE="height: 1px; background-color: #d2d2d2"></DIV>
	<DIV STYLE="height: 1px; background-color: #ffffff"></DIV>
HTML;

print $HTML;

}


function htmlForStars($stars, $isSmall = false) {
	$html = "";
	$hasHalfStar = (floor($stars) == $stars) ? false : true;
	$stars = floor($stars);
	if ($isSmall) $small = "-small";
	for ($x = 0; $x < 5; $x++) {
		if ($x < $stars) {
			$html .= '<IMG class="star-full'.$small.'" SRC="star_full.png">';
		} else {
			if ($hasHalfStar) {
				$hasHalfStar = false;
				$html .= '<IMG class="star-half'.$small.'" SRC="star_half.png">';
			} else {
				$html .= '<IMG class="star-empty'.$small.'" SRC="star_empty.png">';
			}
		}
	}
	return $html;
}

	
?>
	</BODY>
</HTML>