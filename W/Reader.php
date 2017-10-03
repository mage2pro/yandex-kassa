<?php
namespace Dfe\YandexKassa\W;
// 2017-10-02
final class Reader extends \Df\Payment\W\Reader {
	/**             
	 * 2017-10-02 `[Yandex.Kassa] An example of a «checkOrder» notification`: https://mage2.pro/t/4607
	 *	{
	 *		"action": "checkOrder",
	 *		<...>
	 *	}
	 * @override
	 * @see \Df\Payment\W\Reader::kt()
	 * @used-by \Df\Payment\W\Reader::tRaw()
	 * @return string
	 */
	protected function kt() {return 'action';}
}