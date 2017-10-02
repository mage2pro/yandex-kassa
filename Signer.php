<?php
namespace Dfe\YandexKassa;
/**
 * 2017-09-25
 * Note 1.
 * «HTTP notifications about payments»
 * MD5 hashing is applied to a text
 * that is formed as a sequence of values for a set of request parameters separated by semicolons (;).
 * The hash result is converted to uppercase.
 * Note.
 * Make sure the `customerNumber` value doesn't have any spaces at the beginning or at the end.
 * Order of parameters:
 * action;orderSumAmount;orderSumCurrencyPaycash;orderSumBankPaycash;shopId;invoiceId;customerNumber;shopPassword
 * https://tech.yandex.com/money/doc/payment-solution/payment-notifications/payment-notifications-http-docpage
 *
 * 1.1. In Russian:
 * «HTTP-уведомления о переводах»
 * «MD5-хэширование применяется к тексту,
 * который формируется как последовательность значений ряда параметров запроса,
 * разделенных символом «точка с запятой» (;).
 * Результат хэширования приводится к верхнему регистру.
 * Примечание.
 * Проверьте, что в значении `customerNumber` нет пробелов в конце или в начале.
 * Порядок следования параметров:
 * action;orderSumAmount;orderSumCurrencyPaycash;orderSumBankPaycash;shopId;invoiceId;customerNumber;shopPassword»
 * https://tech.yandex.ru/money/doc/payment-solution/payment-notifications/payment-notifications-http-docpage
 * Note 2.
 * The Yandex.Kassa charge requests do not use a signature:
 * @see \Dfe\YandexKassa\Charge::k_Signature()
 * https://tech.yandex.com/money/doc/payment-solution/payment-form/payment-form-http-docpage
 * @method Settings s()
 */
final class Signer extends \Df\PaypalClone\Signer {
	/**
	 * 2017-09-25
	 * @override
	 * @see \Df\PaypalClone\Signer::sign()
	 * @used-by \Df\PaypalClone\Signer::_sign()
	 * @return string
	 */
	protected function sign() {$s = $this->s(); return strtoupper(md5(implode(';', array_merge(
		$this->v(['action', 'orderSumAmount', 'orderSumCurrencyPaycash', 'orderSumBankPaycash'])
		,[$s->merchantID()], $this->v(['invoiceId', 'customerNumber']), [$s->privateKey()]
	))));}
}