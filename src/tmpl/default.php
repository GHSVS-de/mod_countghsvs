<?php
defined('_JEXEC') or die;

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
?>
<div class="container" id="<?php echo $modId; ?>">
	<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
		<?php foreach($items as $key => $item)
		{
			$classCollector[$item->class] = 1;
		?>
			<div class="card">
				<div class="card-body">
					<p class="<?php echo $item->class;?>"><?php echo $item->end;?></p>
					<p class="card-text"><?php echo $item->text;?></p>
				</div>
			</div>
		<?php
		} ?>
	</div>
</div>
