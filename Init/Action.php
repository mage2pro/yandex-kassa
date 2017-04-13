<?php
namespace Dfe\YandexKassa\Init;
// 2017-04-13
/** @method \Dfe\YandexKassa\Method m() */
final class Action extends \Df\PaypalClone\Init\Action {
	/**
	 * 2017-04-13
	 * @override
	 * @see \Df\Payment\Init\Action::redirectUrl()
	 * @used-by \Df\Payment\Init\Action::action()
	 * @return string
	 */
	protected function redirectUrl() {return '';}
}