/**
 * A jQuery plugin to display counter.
 * @author: Akhtar Husain <dev.akhtarhusain@gmail.com>
 * @version: 1.0-ghsvs-edited
 * @copyright Modifications by GHSVS will no longer reflect the original work of its authors.
 */
(function($)
{
	$.fn.countTo = function(options)
	{
		options = $.extend({}, $.fn.countTo.defaults, options || {});
		var loops = Math.ceil(options.speed / options.refreshInterval),
			increment = (options.from - options.to) / loops;

		return $(this).each(function()
		{
			var _this = this,
			loopCount = 0,
			value = options.from,
			interval = setInterval(updateTimer, options.refreshInterval);

			function updateTimer()
			{
				value -= increment;
				loopCount++;
				// GHSVS 2023-01: Das war Bullshit.
				//var newVal = value.formatMoney(options.decimals, options.separator) + '%';
				// GHSVS 2023-01: Fix.
				var newVal = parseInt(value);

				$(_this).html(newVal);

				if (typeof(options.onUpdate) == 'function')
				{
					options.onUpdate.call(_this, value);
				}

				if (loopCount >= loops)
				{
					clearInterval(interval);
					value = options.to;

					if (typeof(options.onComplete) == 'function')
					{
						options.onComplete.call(_this, value);
					}
				}
			}
		});
	};

	$.fn.countTo.defaults = {
		from: 100,
		to: 10,
		speed: 500,
		refreshInterval: 100,
		decimals: 0,
		onUpdate: null,
		onComplete: null,
		separator: '.'
	};
})(jQuery);
