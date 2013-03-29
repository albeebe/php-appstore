<?php
	// Set the timezone to Apples servers so the dates are correct
	date_default_timezone_set("America/Los_Angeles"); 

	// Includes
	include ("appstore.inc.php");
	
	// Set the APP ID we want to get reviews for
	$appID = $_GET["id"];
	if (strlen($appID) == 0) $appID = "577499909";
	
	// Download the most recent reviews
	$_APPSTORE = new APPSTORE($appID);
	$arrReviews = $_APPSTORE->reviewsForPage(0);
	$appName = $_APPSTORE->appName();
	$appIcon = $_APPSTORE->appIcon();
	$appDeveloper = $_APPSTORE->appDeveloper();
	$appTotalStars = $_APPSTORE->appTotalStars();
	$appTotalRatings = $_APPSTORE->appTotalRatings();
	$appCurrentStars = $_APPSTORE->appCurrentStars();
	$appCurrentRatings = $_APPSTORE->appCurrentRatings();
	
	$appName = htmlentities($appName);
	$appDeveloper = htmlentities($appDeveloper);
?>
<HTML>
	<HEAD>
		<TITLE><?= $appName; ?></TITLE>
		<META name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<meta name="apple-mobile-web-app-capable" content="yes">
		<STYLE media="screen" type="text/css">

			body {
				margin: 0px;
				max-width: 320px;
				font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
			}
			
			div.app-header {
				padding: 15px; 
				background-color: #f5f5f5;
			}
			
			div.app-header-shadow {
				height: 4px;
				background: -moz-linear-gradient(top,  rgba(0,0,0,0.65) 0%, rgba(0,0,0,0) 100%); /* FF3.6+ */
				background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0.65)), color-stop(100%,rgba(0,0,0,0))); /* Chrome,Safari4+ */
				background: -webkit-linear-gradient(top,  rgba(0,0,0,0.65) 0%,rgba(0,0,0,0) 100%); /* Chrome10+,Safari5.1+ */
				background: -o-linear-gradient(top,  rgba(0,0,0,0.65) 0%,rgba(0,0,0,0) 100%); /* Opera 11.10+ */
				background: -ms-linear-gradient(top,  rgba(0,0,0,0.65) 0%,rgba(0,0,0,0) 100%); /* IE10+ */
				background: linear-gradient(to bottom,  rgba(0,0,0,0.65) 0%,rgba(0,0,0,0) 100%); /* W3C */
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a6000000', endColorstr='#00000000',GradientType=0 ); /* IE6-9 */
			}
			
			img.app-icon {
				width: 77px;
				height: 77px;
				border-radius: 15px;
				-webkit-border-radius: 15px;
				-moz-border-radius: 15px;
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
			
			div.app-rating {
				margin-top: 10px;
				color: #6a6a6a;
				font-weight: bold;
				font-size: 11px;
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
			
			div.comment-box-title {
				color: #4c4c4c;
				font-size: 13;
				font-weight: bold;
				margin-bottom: 10px;
				text-shadow: 0px 1px #ffffff;
			}
			
			div.comment-box-details {
				color: #4c4c4c;
				font-size: 13;
				text-shadow: 0px 1px #ffffff;
			}
			
			div.comment-box-review {
				color: #4c4c4c;
				font-size: 13;
				margin-top: 10px;
				text-shadow: 0px 1px #ffffff;
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
			
			div.version {
				color: #b0b0b0;
				font-size: 13;
				font-weight: 700;
				position: absolute;
				top: 5px;
				right: 5px;
				text-shadow: 0px 1px #ffffff;
			}
			
		</STYLE>
	</HEAD>
	<BODY>
		<DIV class="app-header">
			<TABLE WIDTH="100%" cellpadding="0" cellspacing="0">
				<TR>
					<TD ALIGN="center" WIDTH="77">
						<IMG class="app-icon" src="<?= $appIcon; ?>">
					</TD>
					<TD WIDTH="10"></TD>
					<TD VALIGN="top">
						<DIV class="app-title"><?= $appName; ?></DIV>
						<DIV class="app-developer"><?= $appDeveloper; ?></DIV>
						<DIV class="app-rating"><?= htmlForStars($appCurrentStars, true); ?> (<?= $appCurrentRatings; ?>)</DIV>
						
					</TD>
				</TR>
			</TABLE>
		</DIV>
		<DIV class="app-header-shadow"></DIV>
	
<?php
for ($x = 0; $x < sizeof($arrReviews); $x++) {
	$review = $arrReviews[$x];
	if ($x % 2 == 0) {
		$boxType = "comment-box-even";
	} else {
		$boxType = "comment-box-odd";
	}
	$commentNumber = $x + 1;
	$reviewComment = str_replace("\n", "<BR>", htmlentities($review["review"]));
	$htmlStars = htmlForStars($review["stars"]);
	
$HTML = <<<HTML
	<DIV CLASS="comment-box">
		<DIV CLASS="version">
			v{$review["version"]}
		</DIV>
		<DIV CLASS="{$boxType}">
			<DIV CLASS="comment-box-title">
				{$commentNumber}. {$review["title"]}
			</DIV>
			<DIV CLASS="comment-box-details">
				{$htmlStars} by {$review["user_name"]} - {$review["date_string"]}
			</DIV>
			<DIV CLASS="comment-box-review">
				{$reviewComment}
			</DIV>		
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