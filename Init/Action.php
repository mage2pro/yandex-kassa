<?php
namespace Dfe\YandexKassa\Init;
// 2017-09-16
/** @method \Dfe\YandexKassa\Method m() */
final class Action extends \Df\PaypalClone\Init\Action {
	/**
	 * 2017-09-16
	 * @override
	 * @see \Df\Payment\Init\Action::redirectUrl()
	 * @used-by \Df\Payment\Init\Action::action()
	 * @return string
	 */
	protected function redirectUrl() {return 'https://{stage}money.yandex.ru/eshop.xml';}
}