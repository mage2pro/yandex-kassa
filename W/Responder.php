<?php
namespace Dfe\YandexKassa\W;
use Dfe\YandexKassa\Response;
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
	 * @return Response
	 */
	protected function error(\Exception $e) {return Response::i($this->e(), $e);}

	/**
	 * 2017-10-02
	 * @override
	 * @see \Df\Payment\W\Responder::notForUs()
	 * @used-by \Df\Payment\W\Responder::setNotForUs()
	 * @param string|null $message [optional]
	 * @return Response
	 */
	protected function notForUs($message = null) {return $this->success();}

	/**
	 * 2017-10-02
	 * @override
	 * @see \Df\Payment\W\Responder::success()
	 * @used-by notForUs()
	 * @used-by \Df\Payment\W\Responder::get()
	 * @return Response
	 */
	protected function success() {return Response::i($this->e());}
}