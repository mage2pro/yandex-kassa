<?php
namespace Dfe\YandexKassa;
use Df\Payment\Settings\Options as O;
use Dfe\YandexKassa\Source\Option as OptionSource;
// 2017-09-16
/** @method static Settings s() */
final class Settings extends \Df\Payment\Settings {
	/**
	 * 2017-09-17
	 * @used-by \Dfe\YandexKassa\ConfigProvider::config()
	 * @return O
	 */
	function options() {return $this->_options(OptionSource::class);}

	/**
	 * 2017-09-17 «Where to ask for a payment option?»
	 * @used-by \Dfe\YandexKassa\ConfigProvider::config()
	 * @return string
	 */
	function optionsLocation() {return $this->v();}

	/**
	 * 2017-09-16 «scid».
	 * [Yandex.Kassa] Where to find my «scid»? https://mage2.pro/t/4520
	 * @used-by @used-by \Dfe\YandexKassa\Charge::pCharge()
	 * @return int
	 */
	function scid() {return $this->i();}
}