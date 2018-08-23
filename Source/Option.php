<?php
namespace Dfe\YandexKassa\Source;
/**
 * 2017-09-16
 * 2017-09-25
 * [Yandex.Kassa] The payment options: https://mage2.pro/t/4494
 * https://tech.yandex.com/money/doc/payment-solution/reference/payment-type-codes-docpage
 * https://tech.yandex.ru/money/doc/payment-solution/reference/payment-type-codes-docpage
 *
 * @used-by \Dfe\YandexKassa\Settings::options()
 * @method static Option s()
 */
final class Option extends \Df\Config\Source {
	/**
	 * 2017-09-16
	 * 2017-09-24
	 * I hide the `OP` (Cash (outside of the Russian Federation)) option of the Magento checkout screen
	 * according to the documentation:
	 * 1) In English:
	 * «When a user pays at a payment kiosk (`paymentType`=`GP`),
	 * there are two possible responses from Yandex.Checkout:
	 * 		If a user pays using a payment kiosk located in Russia, the `paymentType`=`GP` response is sent.
	 *		If it is outside of the Russian Federation, the payment method is different: `paymentType`=`OP`.»
	 * https://tech.yandex.com/money/doc/payment-solution/payment-process/payments-cash-docpage
	 * 2) In Russian:
	 * «Если пользователь вносит деньги через терминал на территории России,
	 * в запросах и реестрах переводов Яндекс.Денег будет указан один способ оплаты (`paymentType`=`GP`).
	 * Если за пределами РФ, способ оплаты будет другой (`paymentType`=`OP`).»
	 * https://tech.yandex.ru/money/doc/payment-solution/payment-process/payments-cash-docpage
	 * So, I handle `paymentType`=`OP` only in the webhooks: @see \Dfe\YandexKassa\W\Event
	 * @override
	 * @see \Df\Config\Source::map()
	 * @used-by \Df\Config\Source::toOptionArray()
	 * @return array(string => string)
	 */
	protected function map() {return df_sort_names(df_map(
		function(array $a) {return dfa_deep($a, 'title/' . df_lang_ru_en());}
		,array_filter(df_module_json($this, 'options'), function(array $a) {return !df_bool(
			dfa($a, 'hideOnCheckout')
		);})
	));}

	/**
	 * 2017-09-25
	 * «В Яндекс.Кассе появилось POS-кредитование от Тинькофф Банка»:
	 * https://roem.ru/24-09-2015/207831/yandex-kassa-credit
	 * @used-by \Dfe\YandexKassa\Charge::pCharge()
	 */
	const LOAN = 'KV';
}