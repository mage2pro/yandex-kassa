<?php
namespace Dfe\YandexKassa;
// 2017-09-16
/** @method static Settings s() */
final class Settings extends \Df\Payment\Settings {
	/**
	 * 2017-09-16 «scid».
	 * @used-by @used-by \Dfe\YandexKassa\Charge::pCharge()
	 * @return int
	 */
	function scid() {return $this->i();}
}