<?php
namespace Dfe\YandexKassa;
# 2017-09-17
final class Method extends \Df\PaypalClone\Method {
	/**
	 * 2017-09-17
	 * The «sum» parameter has the «CurrencyAmount»:
	 * https://tech.yandex.com/money/doc/payment-solution/payment-form/payment-form-http-docpage
	 * https://tech.yandex.ru/money/doc/payment-solution/payment-form/payment-form-http-docpage
	 * The «CurrencyAmount» type description:
	 * In English: «Amount. Fixed-point decimal number with 2-digit precision.»
	 * https://tech.yandex.com/money/doc/payment-solution/reference/datatypes-docpage
	 * In Russian: «Сумма. Число с фиксированной точкой, две цифры после точки.»
	 * https://tech.yandex.ru/money/doc/payment-solution/reference/datatypes-docpage
	 * @override
	 * @see \Df\Payment\Method::amountFormat()
	 * @used-by \Df\Payment\Operation::amountFormat()
	 * @param float|int $a
	 * @return string
	 */
	function amountFormat($a) {return dff_2($a);}

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
	 * @used-by self::iiaKeys()
	 * @used-by self::option()
	 */
	private static $II_OPTION = 'option';
}