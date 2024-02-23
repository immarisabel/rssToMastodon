<?php

include 'config.php';

function fetch_rss_feed($url) {
    $rss = simplexml_load_file($url);
    if ($rss === false) {
        return false;
    }
    return $rss;
}

function strip_html_tags($text) {
    return strip_tags($text);
}

function post_to_mastodon($access_key, $status, $instance) {
    $url = $instance . '/api/v1/statuses'; 
    $data = array(
        'status' => $status,
    );
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer $access_key",
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_code >= 200 && $http_code < 300) {
        return array('success' => true, 'response' => $response, 'http_code' => $http_code);
    } else {
        return array('success' => false, 'response' => $response, 'http_code' => $http_code);
    }
}

$rss_feed = fetch_rss_feed($rss);

if ($rss_feed !== false) {
    $num_items = count($rss_feed->channel->item);
    if ($num_items > 0) {
        $last_item = $rss_feed->channel->item[0];
        $description = $last_item->description;
        $description = strip_html_tags($description);
        $description .= $signature;
        
        $post_result = post_to_mastodon($access_key, $description, $instance);
        
        if ($post_result['success']) {
            echo "Status posted to Mastodon successfully.<br>";
        } else {
            echo "Error posting status to Mastodon. HTTP Error Code: " . $post_result['http_code'] . "<br>";
        }
    } else {
        echo "No items found in the RSS feed.";
    }
} else {
    echo "Error fetching RSS feed.";
}

?>
