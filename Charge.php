<?php
namespace Dfe\YandexKassa;
use Dfe\YandexKassa\Source\Option;
use Magento\Sales\Model\Order\Item as OI;
/**
 * 2017-09-16
 * The charge parameters are specified here:
 * 1) in English:
 * «Payment solution protocol for merchants» → «Payment form» → «Form for HTTP notifications»
 * → «Form parameters»
 * https://tech.yandex.com/money/doc/payment-solution/payment-form/payment-form-http-docpage
 * 2) in Russian:
 * «Протокол приема платежей для магазинов» → «Платежная форма» → «Форма для HTTP-уведомлений»
 * → «Параметры формы»:
 * https://tech.yandex.ru/money/doc/payment-solution/payment-form/payment-form-http-docpage
 * @method Method m()
 * @method Settings s()
 */
final class Charge extends \Df\PaypalClone\Charge {
	/**
	 * 2017-09-16 «Order amount» / «Сумма заказа»
	 * @override
	 * @see \Df\PaypalClone\Charge::k_Amount()
	 * @used-by \Df\PaypalClone\Charge::p()
	 * @return string
	 */
	protected function k_Amount() {return 'sum';}

	/**
	 * 2017-09-16
	 * «Payer's email address.
	 * If passed, the corresponding box on the payment confirmation page will be pre-filled
	 * (step 3 in the payment process).»
	 * «Адрес электронной почты плательщика.
	 * Если он передан, то соответствующее поле на странице подтверждения платежа будет предзаполнено
	 * (шаг 3 на схеме платежа).
	 * Допустимо передавать только адрес электронной почты (проверяется соответствие).»
	 * @override
	 * @see \Df\PaypalClone\Charge::k_Email()
	 * @used-by \Df\PaypalClone\Charge::p()
	 * @return string
	 */
	protected function k_Email() {return 'cps_email';}

	/**
	 * 2017-09-16
	 * «The merchant ID issued when activating Yandex.Checkout».
	 * «Идентификатор магазина, выдается при подключении к Яндекс.Кассе».
	 * [Yandex.Kassa] Where to find my «shopId»? https://mage2.pro/t/4495
	 * @override
	 * @see \Df\PaypalClone\Charge::k_MerchantId()
	 * @used-by \Df\PaypalClone\Charge::p()
	 * @return string
	 */
	protected function k_MerchantId() {return 'shopId';}

	/**
	 * 2017-09-16
	 * In English:
	 * «Unique order number in the merchant's system.
	 * Yandex.Checkout ensures that this number is unique in conjunction with the shopId parameter.
	 * If a payment with the same order number was already successfully processed,
	 * Yandex.Checkout will decline repeat payment attempts.»
	 * In Russian:
	 * «Уникальный номер заказа в системе магазина.
	 * Уникальность контролируется Яндекс.Кассой в сочетании с параметром `shopId`.
	 * Если платеж с таким номер заказа уже был успешно проведен,
	 * то повторные попытки оплаты будут отвергнуты Яндекс.Кассой.»
	 * Type: normalizedString, 64 characters.
	 * @override
	 * @see \Df\PaypalClone\Charge::k_RequestId()
	 * @used-by \Df\PaypalClone\Charge::p()
	 * @return string
	 */
	protected function k_RequestId() {return 'orderNumber';}

	/**
	 * 2017-09-25
	 * The Yandex.Kassa charge requests do not use a signature:
	 * @see \Dfe\YandexKassa\Charge::k_Signature()
	 * https://tech.yandex.com/money/doc/payment-solution/payment-form/payment-form-http-docpage
	 * @override
	 * @see \Df\PaypalClone\Charge::k_Signature()
	 * @used-by \Df\PaypalClone\Charge::p()
	 * @return null
	 */
	protected function k_Signature() {return null;}

	/**
	 * 2017-09-16
	 * @override
	 * @see \Df\PaypalClone\Charge::pCharge()
	 * @used-by \Df\PaypalClone\Charge::p()
	 * @return array(string => mixed)
	 */
	protected function pCharge() {$s = $this->s(); $o = $this->m()->option(); return [
		/**
		 * 2017-09-16
		 * Note 1.
		 * In English:
		 * «Payer's mobile phone number.
		 * If passed, the corresponding box on the payment confirmation page will be pre-filled
		 * (step 3 in the payment process).».
		 * In Russian:
		 * «Номер мобильного телефона плательщика.
		 * Если он передан, то соответствующее поле на странице подтверждения платежа будет предзаполнено
		 * (шаг 3 на схеме платежа).».
		 * Type: string, 15 characters, digits only.
		 * Note 2. A regex test: https://3v4l.org/eG04b
		 */
		'cps_phone' => preg_replace("#\D#", '', $this->customerPhone())
		/**
		 * 2017-09-16
		 * In English:
		 * «The customer ID used by the merchant.
		 * The ID can be the customer's contract number, username, or other.
		 * More than one payment can be made using the same customer ID.
		 * Allowed characters:
		 * 		Latin letters.
		 * 		Numbers from 0 to 9.
		 * 		Russian letters.
		 * 		Spaces (spaces are not allowed at the beginning and end).
		 * 		Symbols ~!@#$%^&*()_+{}|:"<>?-=[]\;./!"№;%:?*()_+/
		 * ».
		 * In Russian:
		 * «Идентификатор плательщика в системе магазина.
		 * В качестве идентификатора может использоваться номер договора плательщика,
		 * логин плательщика и т. п.
		 * Допустимы повторные оплаты по одному и тому же идентификатору плательщика.
		 * Допустимые символы:
		 * 		буквы русского алфавита,
		 * 		латинские буквы,
		 * 		пробелы (пробелы в начале и в конце недопустимы).
		 * 		символы ~!@#$%^&*()_+{}|:"<>?-=[]\;./!"№;%:?*()_+/
		 * 		цифры от 0 до 9,
		 * ».
		 * Type: normalizedString, 64 characters. 
		 */
		,'customerNumber' => $this->customerEmail()
		/**
		 * 2017-09-16
		 * In English:
		 * «The payment method.
		 * We recommend passing an empty value in this field
		 * so that the payment method will be selected in Yandex.Checkout.
		 * Examples:
		 * 		PC - Payment from a Yandex.Money Wallet.
		 * 		AC - Payment from any bank card.
		 * Full list of values: https://tech.yandex.com/money/doc/payment-solution/reference/payment-type-codes-docpage
		 * ».
		 * In Russian:
		 * «Способ оплаты.
		 * Рекомендуем передавать в этом поле пустое значение,
		 * в этом случае выбор способа оплаты будет происходить на стороне Яндекс.Кассы.
		 * Примеры:
		 * 		PC - оплата из кошелька в Яндекс.Деньгах;
		 * 		AC - оплата с произвольной банковской карты.
		 * Полный список значений: https://tech.yandex.ru/money/doc/payment-solution/reference/payment-type-codes-docpage
		 * ».
		 * Type: normalizedString, 5 characters.
		 */
		,'paymentType' => $o
		/**
		 * 2017-09-16
		 * «ID of the payment form, issued during activation of Yandex.Checkout».
		 * «Идентификатор витрины магазина, выдается при подключении к Яндекс.Кассе».
		 * Type: long.
		 * [Yandex.Kassa] Where to find my «scid»? https://mage2.pro/t/4520
		 */
		,'scid' => $s->scid()
	]
	/**
	 * 2017-09-16
	 * 1. Notes for `shopFailUrl` and `shopSuccessUrl`.
	 * Note 1.1
	 * [Yandex.Kassa] What is the maximum length of «shopSuccessURL» and «shopFailURL»?
	 * https://mage2.pro/t/4519
	 * «Maximum of 200 characters»:
	 * https://tech.yandex.com/money/doc/payment-solution/shop-config/parameters-docpage
	 * «250 characters»:
	 * https://tech.yandex.com/money/doc/payment-solution/payment-form/payment-form-http-docpage
	 *
	 * Note 1.2
	 * In English.
	 * «URL of the page the user returns to after payment by clicking the Back to store link.
	 * <...> If you want these URLs to change dynamically (for every payment),
	 * you must add the following parameters to the payment form:
	 * 		`shopSuccessUrl` — For the successful payment page.
	 *		`shopFailUrl` — For the payment error page.
	 * You must pass both addresses.
	 * Note.
	 * *) When a user clicks the link, Yandex.Checkout adds the `action` parameter
	 * with the value `PaymentSuccess` or `PaymentFail` to the store's URL
	 * (depending on the payment result), along with all payment form parameters.
	 * The click-through uses the GET method
	 * (the exception is for an unsuccessful payment from a Yandex.Money Wallet,
	 * which uses a POST request).
	 * *) When the payment status is unknown, the link goes to the store's website address
	 * (the URL is taken from the `Site address` parameter in settings).
	 * In this case, the additional parameters are not appended to the link.
	 * <...>
	 * *) For cash payments via a payment kiosk or payments from a mobile phone balance,
	 * the link goes to the store's home page, and the additional parameters are not passed to the URL.
	 * *) For payments from a WebMoney purse,
	 * the user goes to the store's website directly from the WebMoney system.
	 * In addition, WebMoney can append its own custom parameters to the URL.
	 * *) When a user pays through Sberbank: payment via SMS or Sberbank online,
	 * Alfa-Click, Promsvyazbank online banking, QIWI Wallet, or KupiVkredit (Tinkoff Bank),
	 * they don't see a link to the store's site.».
	 * «Payment solution protocol for merchants» → «Activating a store» → «Activation parameters»
	 * → «General parameters»:
	 * https://tech.yandex.com/money/doc/payment-solution/shop-config/parameters-docpage
	 *
	 * In Russian
	 * «URL страницы, на которую пользователь может перейти после платежа по ссылке `Вернуться в магазин`.
	 * <...>
	 * Чтобы изменять эти URL динамически (для каждого платежа), необходимо:
	 * Добавить в платежную форму параметры:
	 * 		`shopSuccessUrl` — для страницы успешного платежа;
	 * 		`shopFailUrl` — для страницы ошибки при платеже.
	 * В личном кабинете Яндекс.Кассы поставть галочку
	 * `Использовать страницы успеха и ошибки с динамическими адресами`
	 * (раздел `Настройки`, блок `Параметры для платежей`).
	 * Необходимо передавать оба адреса.
	 * Примечание.
	 * *) При переходе Яндекс.Касса добавляет к URL магазина параметр `action`
	 * со значением `PaymentSuccess` или `PaymentFail` (в зависимости от результата платежа),
	 * а также все параметры платежной формы.
	 * Переход происходит методом GET
	 * (исключение — неуспех оплаты из кошелька в Яндекс.Деньгах,
	 * в этом случае переход происходит методом POST).
	 * *) При неопределенном статусе платежа ссылка ведет на адрес сайта магазина
	 * (URL берется из настроек, параметр `Адрес сайта`).
	 * В этом случае дополнительные параметры к ссылке не добавляются.
	 * <...>
	 * *) При оплате наличными через терминал и при платеже со счета мобильного телефона
	 * ссылка ведет на главную страницу сайта магазина, дополнительные параметры в URL не передаются.
	 * *) При оплате из кошелька в системе WebMoney
	 * пользователь переходит на сайт магазина прямо из системы WebMoney.
	 * При этом WebMoney могут добавлять в URL для перехода собственные дополнительные параметры.
	 * *) При оплате через Сбербанк: оплата по смс или Сбербанк Онлайн, Альфа-Клик,
	 * интернет-банк Промсвязьбанка, QIWI Wallet, КупиВкредит (Тинькофф Банк)
	 * пользователь не видит ссылку на сайт магазина.»
	 * «Протокол приема платежей для магазинов» → «Подключение магазина» → «Параметры подключения»
	 * → «Общие параметры»:
	 * https://tech.yandex.com/money/doc/payment-solution/shop-config/parameters-docpage
	 */
	+ array_fill_keys([
		/**
		 * 2017-09-16
		 * In English
		 * «The URL for the `Back to store` link
		 * when the Yandex.Checkout part of the payment process has concluded,
		 * but the user still has additional steps to complete in order to finish the payment.
		 * Pages that show this link:
		 * *) The page with the payment code for cash payments.
		 * *) The page with payment confirmation instructions when paying with an SMS message.
		 * If this parameter is set,
		 * the same URL is used for the `Back to store` link on the payment confirmation page.»
		 * «Payment solution protocol for merchants» → «Payment form» → «Form for HTTP notifications»
		 * → «Form parameters»
		 * https://tech.yandex.com/money/doc/payment-solution/payment-form/payment-form-http-docpage
		 *
		 * In Russian
		 * «URL, на который будет вести ссылка `Вернуться в магазин`,
		 * когда процесс платежа на стороне Яндекс.Кассы завершен,
		 * но для завершения оплаты необходимы дополнительные действия пользователя.
		 * Страницы, на которых отображается эта ссылка:
		 * *) страница с кодом платежа при оплате наличными;
		 * *) страница с инструкцией подтверждения платежа при оплате по смс.
		 * Если этот параметр задан,
		 * то на этот же URL будет вести ссылка `Вернуться в магазин` со страницы подтверждения оплаты.»
		 * «Протокол приема платежей для магазинов» → «Платежная форма» → «Форма для HTTP-уведомлений»
		 * → «Параметры формы»:
		 * https://tech.yandex.ru/money/doc/payment-solution/payment-form/payment-form-http-docpage
		 *
		 * Type: string, URL path, 250 characters.
		 */			
		'shopDefaultUrl'
		/**
		 * 2017-09-16
		 * In English
		 * «The URL for the `Back to store` link on the payment error page».
		 * «Payment solution protocol for merchants» → «Payment form» → «Form for HTTP notifications»
		 * → «Form parameters»
		 * https://tech.yandex.com/money/doc/payment-solution/payment-form/payment-form-http-docpage
		 *
		 * In Russian
		 * «URL, на который будет вести ссылка `Вернуться в магазин` со страницы ошибки платежа».
		 * «Протокол приема платежей для магазинов» → «Платежная форма» → «Форма для HTTP-уведомлений»
		 * → «Параметры формы»:
		 * https://tech.yandex.ru/money/doc/payment-solution/payment-form/payment-form-http-docpage
		 */
		,'shopFailUrl'
		/**
		 * 2017-09-16
		 * In English
		 * «The URL for the `Back to store` link on the successful payment page».
		 * «Payment solution protocol for merchants» → «Payment form» → «Form for HTTP notifications»
		 * → «Form parameters»
		 * https://tech.yandex.com/money/doc/payment-solution/payment-form/payment-form-http-docpage
		 * In Russian
		 * «URL, на который будет вести ссылка `Вернуться в магазин` со страницы успешного платежа».
		 * «Протокол приема платежей для магазинов» → «Платежная форма» → «Форма для HTTP-уведомлений»
		 * → «Параметры формы»:
		 * https://tech.yandex.ru/money/doc/payment-solution/payment-form/payment-form-http-docpage
		 */
		,'shopSuccessUrl'
	], $this->customerReturnRemote())
	+ ($o && Option::LOAN !== $o ? [] : $this->pLoan());}

	/**
	 * 2017-09-25
	 * @used-by pCharge()
	 * @return array(string => mixed)
	 */
	private function pLoan() {return
		dfa_flatten(df_map_k(
			function($i, array $a) {return dfa_key_transform($a, function($k) use($i) {return "{$k}_{$i}";});}
			,$this->oiLeafs(function(OI $i) {return [
				// 2017-09-25 «Price per product unit» / «Стоимость единицы товара». Optional, CurrencyAmount.
				'goods_cost' => $this->amountFormat(df_oqi_price($i, true))
				// 2017-09-25 «Product description» / «Описание товара». Optional, String(255).
				,'goods_description' => df_oqi_desc($i, 255)
				// 2017-09-25 «Название товара» / «Product name». Optional, String(255).
				,'goods_name' => $i->getName()
				// 2017-09-25 «Number of units of the product» / «Количество единиц товара». Optional, Int.
				,'goods_quantity' => df_oqi_qty($i)
			];})
		))
		/**
		 * 2017-09-25 «Provide the 1 year only loan term?»
		 * In English:
		 * «If this parameter is set to true, the bank is passed a fixed loan term of 12 months.
		 * This is necessary for displaying the monthly loan repayment next to the product price.
		 * For example, "Refrigerator for 3000 rubles a month".
		 * This makes the monthly payment equal to 10% of the price.»
		 * In Russian:
		 * «Если этот параметр равен true, в банк передается фиксированный срок кредита — 12 месяцев.
		 * Это нужно для отображения ежемесячного платежа по кредиту рядом со стоимостью товара.
		 * Например: «Холодильник за 3000 рублей в месяц».
		 * Ежемесячный платеж в таком случае равен 10% от стоимости.»
		 */
		+ ['fixed_term' => $this->s()->b('provide1YearOnlyLoanTerm')]
	;}
}