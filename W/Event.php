<?php
namespace Dfe\YandexKassa\W;
use Magento\Sales\Model\Order\Payment\Transaction as T;
/**
 * 2017-09-24
 * Description of the payment process:
 * https://tech.yandex.com/money/doc/payment-solution/payment-process/payment-process-intro-docpage
 *
 * Описание процесса оплаты:
 * https://tech.yandex.ru/money/doc/payment-solution/payment-process/payment-process-intro-docpage
 *
 * There are 3 event types:
 * 1) `checkOrder`
 * 1.1) In English: Order verification
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
 * 1.2) In Russian: Проверка заказа
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
 * 2) `cancelOrder`
 * 2.1) In English: Payment cancellation notification
 * https://tech.yandex.com/money/doc/payment-solution/payment-notifications/payment-notifications-cancel-docpage
 * The notification about the canceled order is sent to the merchant.
 * Used for payment with funds the user is requesting a loan for (`paymentType`=`KV`).
 * An order may be canceled only before the money has been transferred to the merchant's address.
 * Note.
 * If the user couldn't get a loan to pay for the item,
 * the store gets a Payment cancellation notification (cancelOrder).
 * The order won't be paid, and the hold on the item can be removed.
 *
 * 2.2) In Russian: Уведомление об отмене заказа
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
 */
final class Event extends \Df\PaypalClone\W\Event {
	/**
	 * 2017-09-24
	 * @override
	 * @see \Df\PaypalClone\W\Event::k_idE()
	 * @used-by \Df\PaypalClone\W\Event::idE()
	 * @return string
	 */
	protected function k_idE() {return null;}

	/**
	 * 2017-09-24
	 * @override
	 * @see \Df\Payment\W\Event::k_pid()
	 * @used-by \Df\Payment\W\Event::pid()
	 * @return string
	 */
	protected function k_pid() {return '';}

	/**
	 * 2017-09-24
	 * @override
	 * @see \Df\PaypalClone\W\Event::k_signature()
	 * @used-by \Df\PaypalClone\W\Event::signatureProvided()
	 * @return string
	 */
	protected function k_signature() {return '';}

	/**
	 * 2017-09-24
	 * @override
	 * @see \Df\PaypalClone\W\Event::k_status()
	 * @used-by \Df\PaypalClone\W\Event::status()
	 * @return string|null
	 */
	protected function k_status() {return null;}
}