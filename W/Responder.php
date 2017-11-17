<?php
namespace Dfe\YandexKassa\W;
use Dfe\YandexKassa\Result;
/**
 * 2017-10-02
 * @method Event e()
 */
final class Responder extends \Df\Payment\W\Responder {
	/**
	 * 2017-10-02
	 * @override
	 * @see \Df\Payment\W\Responder::error()
	 * @used-by \Df\Payment\W\Responder::setError()
	 * @param \Exception $e
	 * @return Result
	 */
	protected function error(\Exception $e) {return Result::i($this->e(), $e);}

	/**
	 * 2017-10-02
	 * @override
	 * @see \Df\Payment\W\Responder::notForUs()
	 * @used-by \Df\Payment\W\Responder::setNotForUs()
	 * @param string|null $message [optional]
	 * @return Result
	 */
	protected function notForUs($message = null) {return $this->success();}

	/**
	 * 2017-10-02
	 * @override
	 * @see \Df\Payment\W\Responder::success()
	 * @used-by notForUs()
	 * @used-by \Df\Payment\W\Responder::get()
	 * @return Result
	 */
	protected function success() {return Result::i($this->e());}
}