<?php
defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\HTML\HTMLHelper;

/*
From Dispatcher:
$module   Object,
$app,
$input,
$params Registry,
$template,
$modId String,
$moduleclass_sfx String,
$module->title Lang strings translated,
$helper
$wa
$items
*/

if (empty($items))
{
	return '';
}

if ($params->get('backgroundimage', ''))
{
	$wa->addInlineStyle(
'.zaehlers.' . $modId . '{background-image: url("' . Uri::root(true) . '/' . HTMLHelper::_('cleanImageURL', $params->get('backgroundimage'))->url . '");}
', ['name' => $modId]);
}
?>
<div id="<?php echo $modId; ?>" class="container-fluid mod_countghsvs zaehlers <?php echo $modId; ?>">
	<?php if ($module->showtitle)
	{
		echo '<h1 class=moduleHeadline>' . $module->title . '</h1>';
	}?>
	<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
		<?php foreach ($items as $key => $item)
		{ ?>
					<div class="card-bodyCycle mx-auto d-flex align-items-center flex-wrap text-center">
						<div class="<?php echo $item->class;?> zaehlerNumber w-100 align-self-end"><?php echo $item->start;?></div>
						<div class="card-text donthyphenate w-100 align-self-start pt-3"><?php echo nl2br($item->text);?></div>
					</div>
		<?php
		} ?>
	</div>
</div>
