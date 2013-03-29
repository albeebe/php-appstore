php-appstore
===================

PHP class with a bunch of functions to retrieve app ratings from the App Store

<h1>Uses </h1>

I created this script so i could keep up to date on my apps reviews.<BR><BR>You can also get the apps name, the developer name, stars for the current version, stars for all versions, total number of ratings for the current version, and total number of ratings for all versions.

<h1>Example </h1>

<PRE>
include ("appstore.inc.php");
$appID = "577499909"
$_APPSTORE = new APPSTORE($appID);
print_r($_APPSTORE->reviewsForPage(0));
</PRE>

<h1>License</h1>
The MIT License
<BR>
<BR>Copyright (c) 2013 Alan Beebe
<BR>
<BR>Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
<BR>
<BR>The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
<BR>
<BR>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.