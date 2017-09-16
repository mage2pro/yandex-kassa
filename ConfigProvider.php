<?php
namespace Dfe\YandexKassa;
use Df\Payment\Settings\Options as O;
// 2017-09-17
final class ConfigProvider extends \Df\Payment\ConfigProvider {
	/**
	 * 2017-09-17
	 * @override
	 * @see \Df\Payment\ConfigProvider::config()
	 * @used-by \Df\Payment\ConfigProvider::getConfig()
	 * @return array(string => mixed)
	 */
	protected function config() {
		$s = $this->s(); /** @var Settings $s */
		$o = $s->options();	/** @var O $o */
		return [
			'needShowOptions' => $o->needShow()
			// 2017-09-17
			// @used-by Df_Payments/withOptions::options()
			// https://github.com/mage2pro/core/blob/2.0.36/Payment/view/frontend/web/withOptions.js?ts=4#L55
			,'options' => $o->o(true)
		] + parent::config();
	}
}