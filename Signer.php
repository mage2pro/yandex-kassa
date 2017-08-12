<?php
namespace Dfe\YandexKassa;
/**
 * 2017-04-13
 * @see \Dfe\YandexKassa\Signer\Request
 * @see \Dfe\YandexKassa\Signer\Response
 * @method Settings s()
 */
abstract class Signer extends \Df\PaypalClone\Signer {
	/**
	 * 2017-04-13
	 * @used-by sign()
	 * @see \Dfe\YandexKassa\Signer\Request::values()
	 * @see \Dfe\YandexKassa\Signer\Response::values()
	 * @return string[]
	 */
	abstract protected function values();

	/**
	 * 2017-04-13
	 * @override
	 * @see \Df\PaypalClone\Signer::sign()
	 * @used-by \Df\PaypalClone\Signer::_sign()
	 * @return string
	 */
	final protected function sign() {return implode($this->values());}
}