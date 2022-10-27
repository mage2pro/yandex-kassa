<?php
namespace Dfe\YandexKassa\W;
use Magento\Sales\Model\Order\Payment\Transaction as T;
/**
 * 2017-09-24
 * 1) Description of the payment process:
 * 1.1) In English:
 * 1.1.1) Real-time payments:
 * https://tech.yandex.com/money/doc/payment-solution/payment-process/payment-process-intro-docpage
 * 1.1.2) Cash payment via payment kiosks:
 * https://tech.yandex.com/money/doc/payment-solution/payment-process/payments-cash-docpage
 * 1.1.3) Payment via external payment systems:
 * https://tech.yandex.com/money/doc/payment-solution/payment-process/payments-invoicing-docpage
 * 1.1.4) Payment by credit:
 * https://tech.yandex.com/money/doc/payment-solution/payment-process/payments-credit-docpage
 * 1.1.5) Payment from an account in an SMS message:
 * https://tech.yandex.com/money/doc/payment-solution/payment-process/sms-payments-docpage
 * 1.1.6) Payment via Sberbank's mobile app:
 * https://tech.yandex.com/money/doc/payment-solution/payment-process/sbol-payments-docpage
 * 1.1.7) Deferred payment:
 * https://tech.yandex.com/money/doc/payment-solution/payment-process/payments-hold-docpage
 * 1.1.8) Payment via mobile terminal:
 * https://tech.yandex.com/money/doc/payment-solution/payment-process/payments-mpos-docpage
 * 1.1.9) Payment by QR code:
 * https://tech.yandex.com/money/doc/payment-solution/payment-process/payments-qr-docpage
 *
 * 1.2) In Russian:
 * 1.2.1) Оплата в реальном времени:
 * https://tech.yandex.ru/money/doc/payment-solution/payment-process/payment-process-intro-docpage
 * 1.2.2) Оплата наличными через терминалы:
 * https://tech.yandex.ru/money/doc/payment-solution/payment-process/payments-cash-docpage
 * 1.2.3) Оплата через внешние платежные системы:
 * https://tech.yandex.ru/money/doc/payment-solution/payment-process/payments-invoicing-docpage
 * 1.2.4) Оплата в кредит
 * https://tech.yandex.ru/money/doc/payment-solution/payment-process/payments-credit-docpage
 * 1.2.5) Оплата по счету в смс
 * https://tech.yandex.ru/money/doc/payment-solution/payment-process/sms-payments-docpage
 * 1.2.6) Оплата через мобильное приложение Сбербанка
 * https://tech.yandex.ru/money/doc/payment-solution/payment-process/sbol-payments-docpage
 * 1.2.7) Отложенная оплата
 * https://tech.yandex.ru/money/doc/payment-solution/payment-process/payments-hold-docpage
 * 1.2.8) Оплата через мобильный терминал
 * https://tech.yandex.ru/money/doc/payment-solution/payment-process/payments-mpos-docpage
 * 1.2.9) Оплата по QR-коду
 * https://tech.yandex.ru/money/doc/payment-solution/payment-process/payments-qr-docpage
 *
 * 2) There are 3 event types:
 * 2.1) `checkOrder`
 * 2.1.1) In English: Order verification
 * https://tech.yandex.com/money/doc/payment-solution/payment-notifications/payment-notifications-check-docpage
 *
 * This request allows the merchant to check the validity of transfer parameters before the user pays for the order
 * (see step 5 in the general payment flow:
 * https://tech.yandex.com/money/doc/payment-solution/payment-process/payment-process-intro-docpage).
 * It means that the buyer is prepared to pay, but it doesn't guarantee that payment will be completed successfully,
 * and it isn't the final condition for product delivery.
 * After successful payment, the merchant receives a different request: Notification of payment (paymentAviso).
 * Note.
 * The `checkOrder` request is usually formed before funds are debited from the customer's account.
 * At this stage, the merchant can refuse to accept the payment (if, for example, the product is not in stock).
 * If the merchant reserves the product after `checkOrder`,
 * they should keep in mind that funds have not been debited yet: the payer may not confirm the payment.
 * You can use the invoice expiration
 * (https://tech.yandex.com/money/doc/payment-solution/reference/payment-type-codes-docpage)
 * as a measure and un-reserve the product upon expiration.
 * When paying with a bank card, payment is authorized when the `checkOrder` request is formed.
 * If the store refuses to process the payment after verification, the money is automatically refunded to the card.
 * If the user is paying with something other than a Yandex.Money Wallet,
 * external payment systems may take an additional commission.
 * In this case, if the store refused the payment,
 * the amount of money minus this commission fee is returned to the user.
 * For more information about using a `checkOrder` request for various payment methods,
 * see the section Payment process description:
 * https://tech.yandex.com/money/doc/payment-solution/payment-process/payment-process-intro-docpage/
 *
 * 2.1.2) In Russian: Проверка заказа
 * https://tech.yandex.ru/money/doc/payment-solution/payment-notifications/payment-notifications-check-docpage
 * 
 * Этот запрос позволяет магазину проверить корректность параметров перевода до того, как пользователь оплатит заказ
 * (см. шаг 5 в общем сценарии оплаты:
 * https://tech.yandex.ru/money/doc/payment-solution/payment-process/payment-process-intro-docpage).
 * Он означает, что покупатель собирается заплатить, но не гарантирует, что оплата пройдет успешно,
 * и не является окончательным условием для отгрузки товара.
 * После успешной оплаты магазину придет другой запрос: Уведомление о переводе (`paymentAviso`).
 * Примечание.
 * Формирование запроса `checkOrder` чаще всего происходит до списания денег со счета плательщика.
 * На этом шаге магазин может отказаться от приема перевода (например, если товара нет в наличии).
 * Если магазин резервирует товар после `checkOrder`, нужно учитывать, что деньги еще не списаны:
 * плательщик может не подтвердить оплату.
 * Можно ориентироваться на срок действия счета
 * (https://tech.yandex.ru/money/doc/payment-solution/reference/payment-type-codes-docpage)
 * и после его окончания снимать резерв.
 * При оплате с банковской карты авторизация платежа производится до формирования запроса `checkOrder`.
 * Если магазин после проверки отказывает в проведении платежа, деньги автоматически возвращаются на карту.
 * Если пользователь платит не из кошелька в Яндекс.Деньгах,
 * то внешние платежные системы могут брать с него дополнительную комиссию.
 * Тогда при отказе магазина от приема платежа деньги возвращаются плательщику за вычетом этой комиссии.
 * Особенности использования запроса `checkOrder` для различных способов оплаты более подробно описаны в разделе
 * «Описание процесса оплаты»:
 * (https://tech.yandex.ru/money/doc/payment-solution/payment-process/payment-process-intro-docpage)
 *
 * 2.2) `cancelOrder`
 * 2.2.1) In English: Payment cancellation notification
 * https://tech.yandex.com/money/doc/payment-solution/payment-notifications/payment-notifications-cancel-docpage
 * The notification about the canceled order is sent to the merchant.
 * Used for payment with funds the user is requesting a loan for (`paymentType`=`KV`).
 * An order may be canceled only before the money has been transferred to the merchant's address.
 * Note.
 * If the user couldn't get a loan to pay for the item,
 * the store gets a Payment cancellation notification (cancelOrder).
 * The order won't be paid, and the hold on the item can be removed.
 *
 * 2.2.2) In Russian: Уведомление об отмене заказа
 * Уведомление об отмененном заказе отправляется магазину.
 * Используется при платеже средствами, которые пользователь берет в кредит (`paymentType`=`KV`).
 * Заказ может быть отменен только до перевода денег в адрес магазина.
 * Примечание.
 * Если пользователю не удалось оформить кредит для оплаты товара,
 * магазин получит Уведомление об отмене заказа (`cancelOrder`).
 * Заказ не будет оплачен, товар можно снимать с резерва.
 * https://tech.yandex.ru/money/doc/payment-solution/payment-notifications/payment-notifications-cancel-docpage
 *
 * 3) `paymentAviso`:
 * 3.1) In English: Payment notification
 * Yandex.Checkout uses this request to tell the merchant
 * that the user's money was successfully transferred to the merchant's address.
 * This means that the merchant is obligated to provide the user with the product or service that was paid for.
 * https://tech.yandex.com/money/doc/payment-solution/payment-notifications/payment-notifications-aviso-docpage
 *
 * 3.2) In Russian: Уведомление о переводе
 * Этим запросом Яндекс.Касса сообщает магазину, что перевод денег пользователя в адрес магазина прошел успешно.
 * Это значит, что магазин обязан выдать пользователю товар или оказать оплаченную услугу.
 * https://tech.yandex.ru/money/doc/payment-solution/payment-notifications/payment-notifications-aviso-docpage
 *
 * 2017-10-02 `[Yandex.Kassa] An example of a «checkOrder» notification`: https://mage2.pro/t/4607
 */
final class Event extends \Df\PaypalClone\W\Event {
	/**
	 * 2017-10-03
	 * @override
	 * @see \Df\PaypalClone\W\Event::isSuccessful()
	 * @used-by self::ttCurrent()
	 * @used-by \Df\Payment\W\Strategy\ConfirmPending::_handle()
	 * @return bool
	 */
	function isSuccessful() {return 'cancelOrder' !== $this->status();}

	/**
	 * 2017-09-14 The type of the current transaction.
	 * «Operation Statuses»:
	 * https://github.com/QIWI-API/pull-payments-docs/blob/40d48cf0/_statuses_en.html.md#operation-statuses
	 * «Статусы операций»:
	 * https://github.com/QIWI-API/pull-payments-docs/blob/40d48cf0/_statuses_ru.html.md#Статусы-операций
	 * @override
	 * @see \Df\PaypalClone\W\Event::ttCurrent()
	 * @used-by \Df\Payment\W\Strategy\ConfirmPending::_handle()
	 * @used-by \Df\PaypalClone\W\Nav::id()
	 * @used-by \Dfe\Qiwi\W\Handler::strategyC()
	 */
	function ttCurrent() {return !$this->isSuccessful() ? parent::ttCurrent() : dfa([
		'checkOrder' => self::T_INFO, 'paymentAviso' => self::T_CAPTURE
	], $this->status());}

	/**
	 * 2017-09-25
	 * «Unique transaction number in Yandex.Checkout» / «Уникальный номер транзакции в Яндекс.Кассе»
	 * Type: long.
	 * @override
	 * @see \Df\PaypalClone\W\Event::k_idE()
	 * @used-by \Df\PaypalClone\W\Event::idE()
	 * @return string
	 */
	protected function k_idE() {return 'invoiceId';}

	/**
	 * 2017-09-25 «The order number in the merchant's system» / «Номер заказа в системе магазина»
	 * Type: normalizedString, maximum 64 characters.
	 * @override
	 * @see \Df\Payment\W\Event::k_pid()
	 * @used-by \Df\Payment\W\Event::pid()
	 * @return string
	 */
	protected function k_pid() {return 'orderNumber';}

	/**
	 * 2017-09-25 «MD5 hash of the payment form parameters» / «MD5-хэш параметров платежной формы»
	 * Type: normalizedString, exactly 32 uppercase hexadecimal characters.
	 * @override
	 * @see \Df\PaypalClone\W\Event::k_signature()
	 * @used-by \Df\PaypalClone\W\Event::signatureProvided()
	 * @return string
	 */
	protected function k_signature() {return 'md5';}

	/**
	 * 2017-10-03
	 * @override
	 * @see \Df\PaypalClone\W\Event::k_status()
	 * @used-by \Df\PaypalClone\W\Event::status()
	 * @return string|null
	 */
	protected function k_status() {return 'action';}
}