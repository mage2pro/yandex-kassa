<?php
namespace Dfe\YandexKassa\Signer;
// 2017-04-13
final class Request extends \Dfe\YandexKassa\Signer {
	/**
	 * 2017-04-13
	 * @override
	 * @see \Dfe\YandexKassa\Signer::values()
	 * @used-by \Dfe\YandexKassa\Signer::sign()
	 * @return string[]
	 */
	protected function values() {return dfa_select_ordered($this->v(), []);}
}