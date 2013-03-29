php-appstore
===================

PHP class with a bunch of functions to retrieve app ratings from the App Store

<h1>Uses </h1>

I created this script so i could keep up to date on my apps reviews.  You can use this code in conjunction with a cron job to text new reviews to your phone (telapi.com).

<h1>Example </h1>

include ("appstore.inc.php");
$appID = "577499909"
$_APPSTORE = new APPSTORE($appID);
print_r($_APPSTORE->reviewsForPage(0));
