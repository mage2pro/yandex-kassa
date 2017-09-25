<?php
namespace Dfe\YandexKassa\Init;
// 2017-09-16
/** @method \Dfe\YandexKassa\Method m() */
final class Action extends \Df\PaypalClone\Init\Action {
	/**
	 * 2017-09-16
	 * 2.1. In English:
	 * 2.1.1. The production mode:
	 * «When the user clicks the `Pay` button,
	 * a set of payment parameters is sent to Yandex.Checkout at https://money.yandex.ru/eshop.xml»
	 * «Payment solution protocol for merchants» → «Payment form» → «Form for HTTP notifications»
	 * → «Form parameters»:
	 * https://tech.yandex.com/money/doc/payment-solution/payment-form/payment-form-docpage
	 * 2.1.2. The test mode:
	 * «Address for sending parameters in testing mode: https://demomoney.yandex.ru/eshop.xml»
	 * «Payment solution protocol for merchants» → «Usage examples» → «Test data»:
	 * https://tech.yandex.com/money/doc/payment-solution/examples/examples-test-data-docpage
	 * 2.2 In Russian:
	 * 2.2.1. Промышленный режим:
	 * «Адрес для отправки формы: https://money.yandex.ru/eshop.xml»
	 * «Протокол приема платежей для магазинов» → «Платежная форма» → «Форма для HTTP-уведомлений»
	 * → «Параметры формы»:
	 * https://tech.yandex.ru/money/doc/payment-solution/payment-form/payment-form-http-docpage
	 * 2.2.2. Тестовый режим:
	 * «Адрес для отправки параметров в тестовом режиме: https://demomoney.yandex.ru/eshop.xml»
	 * «Протокол приема платежей для магазинов» → «Примеры реализации» → «Тестовые данные»:
	 * https://tech.yandex.ru/money/doc/payment-solution/examples/examples-test-data-docpage
	 * @override
	 * @see \Df\Payment\Init\Action::redirectUrl()
	 * @used-by \Df\Payment\Init\Action::action()
	 * @return string
	 */
	protected function redirectUrl() {return 'https://{stage}money.yandex.ru/eshop.xml';}
}