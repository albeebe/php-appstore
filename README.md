php-appstore
===================

PHP class with a bunch of functions to retrieve app ratings from the App Store

<h1>Uses </h1>

I created this script so i could keep up to date on my apps reviews.  You can use this code in conjunction with a cron job to text new reviews to your phone (telapi.com).

<h1>Example </h1>

<UL>
	<LI>include ("appstore.inc.php");</LI>
	<LI>$appID = "577499909"</LI>
	<LI>$_APPSTORE = new APPSTORE($appID);</LI>
	<LI>print_r($_APPSTORE->reviewsForPage(0));</LI>
</UL>
