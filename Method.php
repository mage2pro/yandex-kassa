<?php
namespace Dfe\YandexKassa;
// 2017-09-17
final class Method extends \Df\PaypalClone\Method {
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
}