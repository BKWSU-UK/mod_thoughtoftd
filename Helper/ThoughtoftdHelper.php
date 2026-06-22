<?php

namespace Joomla\Module\Thoughtoftd\Site\Helper;

// No direct access to this file
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;
use Joomla\String\StringHelper;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Http\HttpFactory;
use Throwable;
use stdClass;

class ThoughtoftdHelper
{
	/**
	 * Number of seconds to wait for the remote service before giving up.
	 */
	const REQUEST_TIMEOUT = 10;

	/**
	 * Fetches and decodes the thought for today from the remote service.
	 *
	 * @param   string  $url    fully-qualified API endpoint
	 * @param   bool    $debug  when true, emit verbose INFO diagnostics to the log
	 *
	 * @return  mixed   decoded response object, or false on any failure
	 */
	public static function getth2($url, $debug = false)
	{
	    try {
	        if ($debug) {
	            Log::add('Fetching thought from URL: ' . $url, Log::INFO, 'mod_thoughtoftd');
	        }

	        // Use Joomla's HTTP client with an explicit timeout so a slow or
	        // unreachable endpoint fails cleanly instead of blocking the page
	        // load and emitting a raw PHP warning.
	        $http     = HttpFactory::getHttp();
	        $response = $http->get($url, [], self::REQUEST_TIMEOUT);

	        if ((int) $response->code !== 200) {
	            Log::add('Failed to fetch thought: HTTP status ' . $response->code, Log::ERROR, 'mod_thoughtoftd');
	            return false;
	        }

	        $jsonString = (string) $response->body;

	        if ($debug) {
	            Log::add('Raw response: ' . substr($jsonString, 0, 500) . (strlen($jsonString) > 500 ? '...' : ''), Log::INFO, 'mod_thoughtoftd');
	        }

	        $data = json_decode($jsonString);

	        if (json_last_error() !== JSON_ERROR_NONE) {
	            Log::add('JSON decode error: ' . json_last_error_msg(), Log::ERROR, 'mod_thoughtoftd');
	            return false;
	        }

	        return $data;
	    }
	    catch (Throwable $e) {
	        // Covers connection timeouts, DNS failures, transport errors, etc.
	        Log::add('Could not retrieve the thought for today: ' . $e->getMessage(), Log::ERROR, 'mod_thoughtoftd');
	        return false;
	    }
	}

	/**
	 * Whether the API returned a usable thought.
	 *
	 * @param   mixed  $answ  decoded API response
	 *
	 * @return  bool
	 */
	public static function isValidResponse($answ)
	{
	    return $answ && is_object($answ) && isset($answ->statusCode) && (int) $answ->statusCode === 0;
	}

	/**
	 * Registers the module's CSS and (optionally) the read-more script with the
	 * Web Asset Manager. Centralised so every layout loads assets identically.
	 *
	 * @param   bool  $readMore  whether the collapsible read-more behaviour is enabled
	 *
	 * @return  void
	 */
	public static function loadAssets($readMore)
	{
	    $wa = Factory::getApplication()->getDocument()->getWebAssetManager();

	    $wa->registerAndUseStyle('mod_thoughtoftd', 'mod_thoughtoftd/thoughtoftd.css');

	    if ($readMore) {
	        $wa->useScript('bootstrap.collapse');
	        $wa->registerAndUseScript('mod_thoughtoftd', 'mod_thoughtoftd/thoughtoftd.js', [], ['defer' => true]);
	    }
	}

	/**
	 * Resolves the thought image HTML for the configured image mode.
	 *
	 * @param   \Joomla\Registry\Registry  $params    module parameters object
	 * @param   mixed                      $answ      decoded API response
	 * @param   string                     $cssClass  CSS class(es) to apply to the <img>
	 *
	 * @return  string  rendered <img> markup, or an empty string when no image applies
	 */
	public static function getThoughtImage($params, $answ, $cssClass)
	{
	    $showImage  = $params->get('show_image', 'none');
	    $defaultImg = $params->get('default_img_link', '');
	    $alt        = Text::_('MOD_THOUGHTOFTD_IMAGE_ALT');
	    $attribs    = ['class' => $cssClass];

	    switch ($showImage) {
	        case 'random':
	            $images = self::getImages($params, self::getFolder($params));
	            $image  = self::getImageOfTheDay($images);

	            if (!empty($image)) {
	                return HTMLHelper::_('image', $image->folder . '/' . $image->name, $alt, $attribs);
	            }
	            break;

	        case 'static':
	            if (!empty($defaultImg)) {
	                return HTMLHelper::_('image', $defaultImg, $alt, $attribs);
	            }
	            break;

	        case 'database':
	            if (is_object($answ) && !empty($answ->image)) {
	                return HTMLHelper::_('image', $answ->image, $alt, $attribs);
	            }

	            if (!empty($defaultImg)) {
	                return HTMLHelper::_('image', $defaultImg, $alt, $attribs);
	            }
	            break;
	    }

	    return '';
	}

	/**
	 * Builds the data-* attribute string used by the read-more script.
	 *
	 * @param   int  $collapsedHeight  collapsed height in pixels
	 *
	 * @return  string
	 */
	public static function getReadMoreAttributes($collapsedHeight)
	{
	    return ' data-collapsed-height="' . (int) $collapsedHeight . '"'
	        . ' data-more-text="' . htmlspecialchars(Text::_('COM_CONTENT_READ_MORE')) . '"'
	        . ' data-less-text="' . htmlspecialchars(Text::_('JLIB_HTML_BEHAVIOR_CLOSE')) . '"';
	}

	/**
	 * Retrieves a random image
	 *
	 * @param   array  $images  list of images
	 *
	 * @return  mixed
	 */
	public static function getRandomImage($images)
	{
	    $i      = count($images);
	    $random = mt_rand(0, $i - 1);
	    $image  = $images[$random];
	    $image->folder	= str_replace('\\', '/', $image->folder);

	    return $image;
	}

	public static function getImageOfTheDay($images)
	{
	    $i = count($images);
	    $currentDay = date('z') + 1;
        if ($i != 0) {
	        $image = $images[$currentDay%$i];
	        $image->folder	= str_replace('\\', '/', $image->folder);
	        return $image;
        }
        return '';
	}

	/**
	 * Retrieves images from a specific folder
	 *
	 * @param   \Joomla\Registry\Registry  &$params  module params
	 * @param   string                     $folder   folder to get the images from
	 *
	 * @return array
	 */
	public static function getImages($params, $folder)
	{
	    $type		= $params->get('type', 'jpg');

	    $files	= array();
	    $images	= array();

	    $dir = JPATH_BASE . '/' . $folder;

	    // Check if directory exists
	    if (is_dir($dir))
	    {
	        if ($handle = opendir($dir))
	        {
	            while (false !== ($file = readdir($handle)))
	            {
	                if ($file != '.' && $file != '..' && $file != 'CVS' && $file != 'index.html')
	                {
	                    $files[] = $file;
	                }
	            }
	        }

	        closedir($handle);

	        $i = 0;

	        foreach ($files as $img)
	        {
	            if (!is_dir($dir . '/' . $img))
	            {
	                if (preg_match('/' . $type . '/', $img))
	                {
	                    $images[$i] = new stdClass;

	                    $images[$i]->name	= $img;
	                    $images[$i]->folder	= $folder;
	                    $i++;
	                }
	            }
	        }
	    }

	    return $images;
	}

	/**
	 * Get sanitized folder
	 *
	 * @param   \Joomla\Registry\Registry  &$params  module params objects
	 *
	 * @return  mixed
	 */
	public static function getFolder($params)
	{
	    $folder	= $params->get('folder');

	    $LiveSite	= Uri::base();

	    // If folder includes livesite info, remove
	    if (StringHelper::strpos($folder, $LiveSite) === 0)
	    {
	        $folder = str_replace($LiveSite, '', $folder);
	    }

	    // If folder includes absolute path, remove
	    if (StringHelper::strpos($folder, JPATH_SITE) === 0)
	    {
	        $folder = str_replace(JPATH_BASE, '', $folder);
	    }

	    $folder = str_replace('\\', DIRECTORY_SEPARATOR, $folder);
	    $folder = str_replace('/', DIRECTORY_SEPARATOR, $folder);

	    return $folder;
	}
}
