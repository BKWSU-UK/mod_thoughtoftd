<?php
defined('_JEXEC') or die();

use Joomla\CMS\Language\Text;
use Joomla\Module\Thoughtoftd\Site\Helper\ThoughtoftdHelper;

ThoughtoftdHelper::loadAssets($readMore == 1);

$thoughtImage = '';
$msgtext      = '';
$topicid      = '';

if (ThoughtoftdHelper::isValidResponse($answ)) {
    $thoughtImage = ThoughtoftdHelper::getThoughtImage($params, $answ, 'card-img');
    $msgtext      = isset($answ->text) ? $answ->text : '';
    $topicid      = isset($answ->topic) ? $answ->topic : '';
} else {
    $msgtext = $params->get('defaultmsg', '');
}

$thoughtClass   = 'card-text';
$dataAttributes = '';

if ($readMore == 1) {
    $thoughtClass  .= ' thought-text-collapsible';
    $dataAttributes = ThoughtoftdHelper::getReadMoreAttributes($collapsedHeight);
}

if (trim($subscribe_link) === '') {
    $subscribe_link = '#';
}
?>

<div class="mod-thoughtoftd card text-bg-dark<?php echo $moduleclass_sfx ? ' ' . $moduleclass_sfx : ''; ?>">
    <?php if ($thoughtImage) : ?>
        <?php echo $thoughtImage; ?>
        <div class="card-img-overlay d-flex flex-column justify-content-end">
    <?php else : ?>
        <div class="card-body">
    <?php endif; ?>

        <?php if ($show_topic != 0 && !empty($topicid)) : ?>
            <h5 class="card-title<?php echo $thoughtImage ? ' text-white' : ''; ?>">
                <?php echo htmlspecialchars($topicid); ?>
            </h5>
        <?php endif; ?>

        <?php if (!empty($msgtext)) : ?>
            <p class="<?php echo $thoughtClass; ?><?php echo $thoughtImage ? ' text-white' : ''; ?>"<?php echo $dataAttributes; ?>>
                <?php echo $msgtext; ?>
            </p>
        <?php else : ?>
            <p class="card-text text-muted">
                <em><?php echo Text::_('MOD_THOUGHTOFTD_CONFIGURE_MSG'); ?></em>
            </p>
        <?php endif; ?>

        <?php if ($show_button != 0) : ?>
            <a class="btn btn-light" href="<?php echo htmlspecialchars($subscribe_link); ?>">
                <?php echo htmlspecialchars($subscribe_title); ?>
            </a>
        <?php endif; ?>
    </div>
</div>
