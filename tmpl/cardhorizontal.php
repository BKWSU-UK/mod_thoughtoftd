<?php
defined('_JEXEC') or die();

use Joomla\CMS\Language\Text;
use Joomla\Module\Thoughtoftd\Site\Helper\ThoughtoftdHelper;

ThoughtoftdHelper::loadAssets($readMore == 1);

$thoughtImage = '';
$msgtext      = '';
$topicid      = '';

if (ThoughtoftdHelper::isValidResponse($answ)) {
    $thoughtImage = ThoughtoftdHelper::getThoughtImage($params, $answ, 'img-fluid rounded-start');
    $msgtext      = isset($answ->text) ? $answ->text : '';
    $topicid      = isset($answ->topic) ? $answ->topic : '';
} else {
    $msgtext = ThoughtoftdHelper::getDefaultMessage($params);
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

    <div class="row g-0">
        <?php if ($thoughtImage) : ?>
            <div class="col-md-6">
                <?php echo $thoughtImage; ?>
            </div>
        <?php endif; ?>

        <div class="<?php echo $thoughtImage ? 'col-md-6' : 'col-12'; ?>">
            <div class="card-body">
                <?php if ($show_topic != 0 && !empty($topicid)) : ?>
                    <h5 class="card-title"><?php echo htmlspecialchars($topicid); ?></h5>
                <?php endif; ?>

                <?php if (!empty($msgtext)) : ?>
                    <p class="<?php echo $thoughtClass; ?>"<?php echo $dataAttributes; ?>>
                        <?php echo $msgtext; ?>
                    </p>
                <?php else : ?>
                    <p class="card-text text-muted">
                        <em><?php echo Text::_('MOD_THOUGHTOFTD_CONFIGURE_MSG'); ?></em>
                    </p>
                <?php endif; ?>

                <?php if ($show_button != 0) : ?>
                    <a class="btn btn-primary" href="<?php echo htmlspecialchars($subscribe_link); ?>">
                        <?php echo htmlspecialchars($subscribe_title); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
