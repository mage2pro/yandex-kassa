<?php
namespace Dfe\YandexKassa;
/**
 * 2017-09-16
 * @method Method m()
 * @method Settings s()
 */
final class Charge extends \Df\PaypalClone\Charge {
	/**
	 * 2017-09-16
	 * @override
	 * @see \Df\PaypalClone\Charge::k_Amount()
	 * @used-by \Df\PaypalClone\Charge::p()
	 * @return string
	 */
	protected function k_Amount() {return '';}

	/**
	 * 2017-09-16
	 * @override
	 * @see \Df\PaypalClone\Charge::k_MerchantId()
	 * @used-by \Df\PaypalClone\Charge::p()
	 * @return string
	 */
	protected function k_MerchantId() {return '';}

	/**
	 * 2017-09-16
	 * @override
	 * @see \Df\PaypalClone\Charge::k_RequestId()
	 * @used-by \Df\PaypalClone\Charge::p()
	 * @return string
	 */
	protected function k_RequestId() {return '';}

	/**
	 * 2017-09-16
	 * @override
	 * @see \Df\PaypalClone\Charge::k_Signature()
	 * @used-by \Df\PaypalClone\Charge::p()
	 * @return string
	 */
	protected function k_Signature() {return '';}

	/**
	 * 2017-09-16
	 * @override
	 * @see \Df\PaypalClone\Charge::pCharge()
	 * @used-by \Df\PaypalClone\Charge::p()
	 * @return array(string => mixed)
	 */
	protected function pCharge() {$s = $this->s(); return [
		/**
		 * 2017-09-16
		 * Note 1.
		 * [Yandex.Kassa] What is the maximum length of «shopSuccessURL» and «shopFailURL»?
		 * https://mage2.pro/t/4519
		 * «Maximum of 200 characters»:
		 * https://tech.yandex.com/money/doc/payment-solution/shop-config/parameters-docpage
		 * «250 characters»:
		 * https://tech.yandex.com/money/doc/payment-solution/payment-form/payment-form-http-docpage
		 *
		 * Note 2.
		 * 2.1. In English
		 * 2.1.1. «The URL for the `Back to store` link on the payment error page».
		 * «Payment solution protocol for merchants» → «Payment form» → «Form for HTTP notifications»
		 * https://tech.yandex.com/money/doc/payment-solution/payment-form/payment-form-http-docpage
		 * 2.1.2. See the 2.1.2. comment for the `shopSuccessUrl` parameter.
		 *
		 * 2.2. In Russian
		 * 2.2.1. «URL, на который будет вести ссылка `Вернуться в магазин` со страницы ошибки платежа».
		 * «Протокол приема платежей для магазинов» → «Платежная форма» → «Форма для HTTP-уведомлений»:
		 * https://tech.yandex.ru/money/doc/payment-solution/payment-form/payment-form-http-docpage
		 * 2.2.2. Смотрите комментарий 2.2.2. к параметру `shopSuccessUrl`.
		 */
		'shopFailUrl' => $this->customerReturnRemote()
		/**
		 * 2017-09-16
		 * Note 1.
		 * [Yandex.Kassa] What is the maximum length of «shopSuccessURL» and «shopFailURL»?
		 * https://mage2.pro/t/4519
		 * «Maximum of 200 characters»:
		 * https://tech.yandex.com/money/doc/payment-solution/shop-config/parameters-docpage
		 * «250 characters»:
		 * https://tech.yandex.com/money/doc/payment-solution/payment-form/payment-form-http-docpage
		 *
		 * Note 2.
		 * 2.1. In English
		 * 2.1.1. «The URL for the `Back to store` link on the successful payment page».
		 * «Payment solution protocol for merchants» → «Payment form» → «Form for HTTP notifications»
		 * https://tech.yandex.com/money/doc/payment-solution/payment-form/payment-form-http-docpage
		 * 2.1.2.
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
		 * 2.2. In Russian
		 * 2.2.1. «URL, на который будет вести ссылка `Вернуться в магазин` со страницы успешного платежа».
		 * «Протокол приема платежей для магазинов» → «Платежная форма» → «Форма для HTTP-уведомлений»:
		 * https://tech.yandex.ru/money/doc/payment-solution/payment-form/payment-form-http-docpage
		 * 2.2.2.
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
		,'shopSuccessUrl' => $this->customerReturnRemote()
	];}
}