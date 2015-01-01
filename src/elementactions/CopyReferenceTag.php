<?php
namespace craft\app\elementactions;

use craft\app\Craft;
use craft\app\helpers\JsonHelper;

/**
 * Copy Reference Tag Element Action
 *
 * @author    Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @copyright Copyright (c) 2014, Pixel & Tonic, Inc.
 * @license   http://buildwithcraft.com/license Craft License Agreement
 * @link      http://buildwithcraft.com
 * @package   craft.app.elementactions
 * @since     2.3
 */
class CopyReferenceTag extends BaseElementAction
{
	// Public Methods
	// =========================================================================

	/**
	 * @inheritDoc ComponentTypeInterface::getName()
	 *
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Copy reference tag');
	}

	/**
	 * @inheritDoc ElementActionInterface::getTriggerHtml()
	 *
	 * @return string|null
	 */
	public function getTriggerHtml()
	{
		$prompt = JsonHelper::encode(Craft::t('{ctrl}C to copy.'));
		$elementType = lcfirst($this->getParams()->elementType);

		$js = <<<EOT
(function()
{
	var trigger = new Craft.ElementActionTrigger({
		handle: 'CopyReferenceTag',
		batch: false,
		activate: function(\$selectedItems)
		{
			var message = Craft.t({$prompt}, {
				ctrl: (navigator.appVersion.indexOf('Mac') ? '⌘' : 'Ctrl-')
			});

			prompt(message, '{{$elementType}:'+\$selectedItems.find('.element').data('id')+'}');
		}
	});
})();
EOT;

		craft()->templates->includeJs($js);
	}

	// Protected Methods
	// =========================================================================

	/**
	 * @inheritDoc BaseElementAction::defineParams()
	 *
	 * @return array
	 */
	protected function defineParams()
	{
		return array(
			'elementType' => AttributeType::String,
		);
	}
}