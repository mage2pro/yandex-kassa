<?php
namespace Dfe\YandexKassa;
use Df\Payment\ConfigProvider\IOptions;
# 2017-09-17
/** @method Settings s() */
final class ConfigProvider extends \Df\Payment\ConfigProvider implements IOptions {
	/**
	 * 2017-09-18
	 * @override
	 * @see \Df\Payment\ConfigProvider\IOptions::options()
	 * @used-by \Df\Payment\ConfigProvider::configOptions()
	 * @return array(<value> => <label>)
	 */
	function options() {return $this->s()->options()->o(true);}

	/**
	 * 2017-09-17
	 * @override
	 * @see \Df\Payment\ConfigProvider::config()
	 * @used-by \Df\Payment\ConfigProvider::getConfig()
	 * @return array(string => mixed)
	 */
	protected function config() {return self::configOptions($this) + parent::config();}
}