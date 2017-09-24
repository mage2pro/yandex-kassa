<?php
namespace Dfe\YandexKassa;
// 2017-09-17
final class Method extends \Df\PaypalClone\Method {
	/**
	 * 2017-09-24
	 * @used-by \Dfe\YandexKassa\Charge::pCharge()
	 * @return string|null
	 */
	function option() {return $this->iia(self::$II_OPTION);}

	/**
	 * 2017-09-17
	 * [Yandex.Kassa] What are the minimum and maximum payment amount limitations for each payment option?
	 * https://mage2.pro/t/4522
	 * @override
	 * @see \Df\Payment\Method::amountLimits()
	 * @used-by \Df\Payment\Method::isAvailable()
	 * @return null
	 */
	protected function amountLimits() {return null;}

	/**
	 * 2017-09-24
	 * @override
	 * @see \Df\Payment\Method::iiaKeys()
	 * @used-by \Df\Payment\Method::assignData()
	 * @return string[]
	 */
	protected function iiaKeys() {return [self::$II_OPTION];}

	/**
	 * 2017-09-24 https://github.com/mage2pro/core/blob/2.12.17/Payment/view/frontend/web/withOptions.js#L56-L72
	 * @used-by iiaKeys()
	 * @used-by option()
	 */
	private static $II_OPTION = 'option';
}