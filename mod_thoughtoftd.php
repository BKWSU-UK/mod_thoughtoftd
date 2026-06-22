<?php
// No direct access to this file
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Log\Log;
use Joomla\Module\Thoughtoftd\Site\Helper\ThoughtoftdHelper;

$orgids = $params->get ( 'orgids' );
$lang = $params->get ( 'lang' );
$specificday = $params->get ( 'specificday' );
$show_topic = $params->get ( 'show_topic', '' );
$readMore = $params->get("read_more", 0);
$collapsedHeight = $params->get('collapsed_height', 120);
$show_button = $params->get ( 'show_button', '' );
$showImage = $params->get ( 'show_image', 'none' );
$thoughtImage = '';
$imagePlacement = $params->get ( 'image_placement', 'afterTopic' );
$subscribe_title = $params->get ( 'subscribetitle', '' );
$subscribe_link = $params->get ( 'subscribelink', '' );
$is_database_link = $params->get ( 'link_from_database', '' );
$base_url = $params->get ( 'base_url', 'https://thoughts.brahmakumaris.org/' );
$defaulImage = $params->get('default_img_link');
$debug = (bool) $params->get('debug', 0);
// Normalise the base URL so a trailing slash (or its absence) never produces a
// malformed endpoint such as ".../thoughtstotd".
$url = rtrim($base_url, '/') . '/totd?orgIds=' . urlencode($orgids)
    . '&lang=' . urlencode($lang)
    . '&dateFormat=ISO8601&specificDay=' . urlencode($specificday);
$answ = ThoughtoftdHelper::getth2 ( $url, $debug );

// Verbose diagnostics only when the Debug Logging parameter is enabled.
if ($debug) {
    Log::add('Thought of the Day - Request URL: ' . $url, Log::INFO, 'mod_thoughtoftd');
    Log::add('Thought of the Day - Response type: ' . gettype($answ), Log::INFO, 'mod_thoughtoftd');
    if (is_object($answ)) {
        Log::add('Thought of the Day - Response data: ' . json_encode($answ), Log::INFO, 'mod_thoughtoftd');
    } else {
        Log::add('Thought of the Day - Response is not an object: ' . var_export($answ, true), Log::WARNING, 'mod_thoughtoftd');
    }
}

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx', ''));
require ModuleHelper::getLayoutPath('mod_thoughtoftd', $params->get('layout', 'default'));
