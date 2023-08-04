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
	 * 2023-08-03 "Treat `\Throwable` similar to `\Exception`": https://github.com/mage2pro/core/issues/311
	 * @override
	 * @see \Df\Payment\W\Responder::error()
	 * @used-by \Df\Payment\W\Responder::setError()
	 * @param \Throwable|string $t
	 */
	protected function error($t):Result {df_assert(df_is_th($t)); return Result::i($this->e(), $t);}

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