# rssToMastodon
a simple PHP script to send your RSS feed to Mastodon as you publish


You can add this script to your website. Anywhere really, but I sugest it's own folder.

Modify the config as needed:

```php
$rss = 'RSS_FEED_URL';
$instance = 'URL_OF_INSTANCE_NOT_PROFILE';
$access_key = 'SEE_README';
$signature = ' ADJUST AS NEEDED SUCH AS "via URL_OF_ORIGIN" ';

```

For the `access key`, look into your profile and settings. Under developer you can create an access key. You only need Write status rights.

The `signature` is in case you wish to make sure you end each status with reference to your website or some info. You can also leave it empty.

To execute upon posting an entry anywhere, you can add `<? php include 'rssToMastodon.php' ?>` anywhere on the script which sends the post to your blog.
