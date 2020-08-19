<?php
namespace Dfe\YandexKassa;
use Df\Payment\Settings\Options as O;
use Dfe\YandexKassa\Source\Option as OptionSource;
# 2017-09-16
/** @method static Settings s() */
final class Settings extends \Df\Payment\Settings {
	/**
	 * 2017-09-17
	 * @used-by \Dfe\YandexKassa\ConfigProvider::options()
	 * @return O
	 */
	function options() {return $this->_options(OptionSource::class);}

	/**
	 * 2017-09-16 «scid».
	 * [Yandex.Kassa] Where to find my «scid»? https://mage2.pro/t/4520
	 * @used-by \Dfe\YandexKassa\Charge::pCharge()
	 * @return int
	 */
	function scid() {return $this->i();}
}