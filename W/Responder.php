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
	 * @param \Exception|string $e
	 */
	protected function error($e):Result {df_assert($e instanceof \Exception); return Result::i($this->e(), $e);}

	/**
	 * 2017-10-02
	 * @override
	 * @see \Df\Payment\W\Responder::notForUs()
	 * @used-by \Df\Payment\W\Responder::setNotForUs()
	 */
	protected function notForUs(string $m):Result {return $this->success();}

	/**
	 * 2017-10-02
	 * @override
	 * @see \Df\Payment\W\Responder::success()
	 * @used-by self::notForUs()
	 * @used-by \Df\Payment\W\Responder::get()
	 */
	protected function success():Result {return Result::i($this->e());}
}