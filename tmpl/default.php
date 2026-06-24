<?php
defined ( '_JEXEC' ) or die ();

use Joomla\CMS\Language\Text;
use Joomla\Module\Thoughtoftd\Site\Helper\ThoughtoftdHelper;

ThoughtoftdHelper::loadAssets($readMore == 1);

$thoughtImage = '';
$msgtext      = '';
$topicid      = '';

if (ThoughtoftdHelper::isValidResponse($answ)) {
    $thoughtImage = ThoughtoftdHelper::getThoughtImage($params, $answ, 'thought-img img-fluid');
    $msgtext      = isset($answ->text) ? $answ->text : '';
    $topicid      = isset($answ->topic) ? $answ->topic : '';

    if (!empty($thoughtImage)) {
        echo $thoughtImage;
    }

    if ($show_topic != 0 && !empty($topicid)) {
        echo '<h4>' . htmlspecialchars($topicid) . '</h4>';
    }
} else {
    $msgtext = ThoughtoftdHelper::getDefaultMessage($params);
}

if (!empty($msgtext)) {
    $thoughtClass   = 'thought-text';
    $dataAttributes = '';

    if ($readMore == 1) {
        $thoughtClass  .= ' thought-text-collapsible';
        $dataAttributes = ThoughtoftdHelper::getReadMoreAttributes($collapsedHeight);
    }

    echo '<p class="' . $thoughtClass . '"' . $dataAttributes . '>' . $msgtext . '</p>';
}

if (trim($subscribe_link) === '') {
    $subscribe_link = '#';
}

if ($show_button != 0) {
    echo '<a class="btn btn-primary" href="' . htmlspecialchars($subscribe_link) . '">' . htmlspecialchars($subscribe_title) . '</a>';
}
