<?php
namespace Dfe\YandexKassa;
// 2017-09-16
final class Url extends \Df\Payment\Url {
	/**
	 * 2017-09-16
	 * The method returns a 2-tuple:
	 * the first element is for the test mode, the second is for the production mode.
	 * @override
	 * @see \Df\Payment\Url::stageNames()
	 * @used-by \Df\Payment\Url::url()
	 * @return string[]
	 */
	protected function stageNames() {return ['demo', ''];}
}