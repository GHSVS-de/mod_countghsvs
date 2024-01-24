<?php

namespace GHSVS\Module\CountGhsvs\Site\Helper;

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\Registry\Registry;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Application\CMSApplication;

class CountGhsvsHelper
{
	public function getDisplayData(Registry $params, Object $module, CMSApplication $app): array
	{
		$modId = $module->module . '_modId-' . $module->id;
		$items = $this->getItems($params, $modId);
		$wa = $this->getWa($app, $module->module);

		if ($items !== false)
		{
			$this->loadScripts($wa, $module->module, $items, $modId);
		}

		return [
			'moduleclass_sfx' => $this->getModuleclass_sfx($params),
			'module' => $this->prepareModule($params, $module),
			'modId' => $modId,
			'wa' => $wa,
			'items' => $items,
		];
	}

	private function getModuleclass_sfx(Registry $moduleParams) : string
	{
		return $this->clean($moduleParams->get('moduleclass_sfx', ''));
	}

	private function prepareModule(Registry $moduleParams, Object $module) : object
	{
		if ($moduleParams->get('prepare_content', 1) && !empty($module->content))
		{
			$module->content = HTMLHelper::_(
				'content.prepare',
				$module->content,
				'',
				'mod_countghsvs.content'
			);
		}

		$module->title = Text::_($module->title);
		return $module;
	}

	private function clean(String $string) : string
	{
		return empty($string) ? '' : htmlspecialchars(Text::_($string), ENT_QUOTES,
			'UTF-8');
	}

	private function getWa(CMSApplication $app, String $moduleName)
	{
		$wa = $app->getDocument()->getWebAssetManager();
		// Searches in media/
		$wa->getRegistry()->addExtensionRegistryFile($moduleName);
		return $wa;
	}

	private function getItems(&$params, $modId)
	{
		$items = $params->get('items');
		$timeGlobal = (int) $params->get('timeGlobal', 5000);

		if (\is_object($items) && \count(get_object_vars($items)))
		{
			foreach ($items as $key => $item)
			{
				if ($item->active !== 1)
				{
					unset($items->$key);
					continue;
				}

				$item->text = trim($item->text);
				$item->end = (int) $item->end;
				$item->start = (int) $item->start;
				$item->time = (int) $item->time;
				$item->time = $item->time ?: $timeGlobal;

				if ($item->end <= $item->start || $item->time === 0)
				{
					unset($items->$key);
					continue;
				}

				$item->class = join('_', ['item', $item->start, $item->end, $item->time]);
			}

			if (\is_object($items) && \count(get_object_vars($items)))
			{
				return $items;
			}
			return false;
		}
	}

	private function loadScripts($wa, $moduleName, $items, $modId)
	{
		$wa->usePreset($moduleName . '.framework');

		foreach($items as $key => $item)
		{
			$classCollector[$item->class] = 1;
		}

		$classCollector = array_keys($classCollector);

		$js = ['document.addEventListener("DOMContentLoaded", function () {'];
		$js[] = 'const el = document.querySelector("#' . $modId . '");';
		$js[] = 'new Waypoint({';
		$js[] = 'element: el, handler: function(){';

		foreach ($classCollector as $class)
		{
			list($dummy, $from, $to, $speed) = explode('_', $class);
			$js[] = 'jQuery(".' . $class . '").countTo({';
			$js[] = "from:$from,to:$to,speed:$speed";
			$js[] = '});';
		}

		$js[] = 'this.destroy()}, offset: "bottom-in-view",';
		$js[] = '})'; // Waypoint

		$js[] = '});'; // addEventListener
		$js = implode("\n", $js);
		$wa->addInlineScript($js);
	}
}
