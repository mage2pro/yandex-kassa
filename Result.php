<?php
namespace Dfe\YandexKassa;
use \Exception as Ex;
use Df\PaypalClone\W\Exception\InvalidSignature;
use Dfe\YandexKassa\W\Event as Ev;
use Zend_Date as ZD;

/**
 * 2017-10-02
 * 1. In English:
 * 1.1. «HTTP notifications about payments» → «Interaction format» → «Response format»:
 * https://tech.yandex.com/money/doc/payment-solution/payment-notifications/payment-notifications-http-docpage
 * 1.2. «Order verification (checkOrder)»:
 * 		*) «Response parameters»
 * 		*) «Request processing result codes»
 * 		*) «Examples» → «Response example for successful processing»
 * 		*) «Examples» → «Response example with error»
 * https://tech.yandex.com/money/doc/payment-solution/payment-notifications/payment-notifications-check-docpage
 * 1.3. «Payment cancellation notification (cancelOrder)»:
 * https://tech.yandex.com/money/doc/payment-solution/payment-notifications/payment-notifications-cancel-docpage
 * 		*) «Response parameters»
 * 		*) «Examples» → «Response example for successful processing»
 * 1.4. «Payment notification (paymentAviso)»:
 * 		*) «Response parameters»
 * 		*) «Request processing result codes»
 * 		*) «Examples» → «Response example for successful processing»
 * 		*) «Examples» → «Response example with error»
 * https://tech.yandex.com/money/doc/payment-solution/payment-notifications/payment-notifications-aviso-docpage
 *
 * 2. In Russian:
 * 2.1. «HTTP-уведомления о переводах» → «Формат взаимодействия» → «Формат ответа»:
 * https://tech.yandex.ru/money/doc/payment-solution/payment-notifications/payment-notifications-http-docpage
 * 2.2. «Проверка заказа (checkOrder)»:
 * 		*) «Параметры ответа»
 * 		*) «Коды результата обработки запроса»
 * 		*) «Примеры» → «Пример ответа при успехе обработки»
 * 		*) «Примеры» → «Пример ответа при ошибке»
 * https://tech.yandex.ru/money/doc/payment-solution/payment-notifications/payment-notifications-check-docpage
 * 2.3. «Уведомление об отмене заказа (cancelOrder)»:
 * 		*) «Параметры ответа»
 * 		*) «Примеры» → «Пример ответа при успехе обработки»
 * https://tech.yandex.ru/money/doc/payment-solution/payment-notifications/payment-notifications-cancel-docpage
 * 2.4. «Уведомление о переводе (paymentAviso)»:
 * 		*) «Параметры ответа»
 * 		*) «Коды результата обработки запроса»
 * 		*) «Примеры» → «Пример ответа при успехе обработки»
 * 		*) «Примеры» → «Пример ответа при ошибке»
 * https://tech.yandex.ru/money/doc/payment-solution/payment-notifications/payment-notifications-aviso-docpage
 *
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 */
class Result extends \Df\Framework\W\Result\Xml {
	/**
	 * 2021-12-03
	 * @override
	 * @see \Df\Framework\W\Result\Xml::attributes()
	 * @used-by \Df\Framework\W\Result\Xml::__toString()
	 * @return array(string => mixed)
	 */
	final protected function attributes():array {return [
		/**
		 * 2017-10-03
		 * In English:
		 * «Code of the processing result. The table below lists possible values.»
		 *
		 * 0: Successful
		 * The merchant agreed and is ready to accept the transfer.
		 *
		 * 1: Authorization error
		 * The md5 parameter does not match the result of calculating the hash function. Fatal error.
		 *
		 * 100: Refused to accept transfer (it is only for the `checkOrder` notification)
		 * Refusal to accept the transfer with the specified parameters. Fatal error.
		 *
		 * 200: Request parsing error
		 * The merchant is not able to parse the request. Fatal error.
		 *
		 * ------------
		 *
		 * In Russian:
		 * «Код результата обработки. Список допустимых значений приведен в таблице ниже.»
		 *
		 * 0: Успешно
		 * Магазин дал согласие и готов принять перевод.
		 *
		 * 1: Ошибка авторизации
		 * Несовпадение значения параметра md5 с результатом расчета хэш-функции. Окончательная ошибка.
		 *
		 * 100: Отказ в приеме перевода (it is only for the `checkOrder` notification)
		 * Отказ в приеме перевода с заданными параметрами. Окончательная ошибка.
		 *
		 * 200
		 * Ошибка разбора запроса
		 * Магазин не в состоянии разобрать запрос. Окончательная ошибка.
		 */
		'code' => !$this->_ex ? 0 : ($this->_ex instanceof InvalidSignature ? 1 : 200)
		# 2017-10-03
		# «Yandex.Checkout transaction ID. Must match the invoiceId field in the request.»
		# «Идентификатор транзакции в Яндекс.Кассе. Должен дублировать поле invoiceId запроса.»
		,'invoiceId' => $this->_ev->r('invoiceId')
		/**
		 * 2017-10-03
		 * In English:
		 * «Time in merchant's system when request was processed.»
		 * An example: «2011-05-04T20:38:11.000+04:00».
		 * Type: dateTime.
		 * https://tech.yandex.com/money/doc/payment-solution/reference/datatypes-docpage
		 * Temporary tag conforming to the RFC3339 standard in the following format:
		 * 		YYYY-MM-DDThh:mm:ss.fZZZZZ
		 * Format breakdown:
		 * 		YYYY — Year, exactly 4 digits.
		 * 		MM — Month, exactly 2 digits (01 is January, and so on).
		 * 		DD — Day of the month, exactly 2 digits (from 01 to 31).
		 * 		T — Latin uppercase "T" character.
		 * 		hh — Hour, exactly 2 digits (24-hour format, from 00 to 23).
		 * 		mm — Minute, exactly 2 digits (from 00 to 59).
		 * 		ss — Second, exactly 2 digits (from 00 to 59).
		 * 		f — Fraction of a second (from 1 to 6 digits).
		 * 			May be omitted. In this case, omit the dot separator (.).
		 * 		ZZZZZ — Time zone. Acceptable values:
		 * 		Z — UTC, uppercase "Z" character.
		 * 		+ hh: mm or -hh:mm — Offset relative to UTC (GMT).
		 * 			Shows that the local time is used,
		 * 		which is ahead of or behind UTC the given number of hours and minutes.
		 * Example:
		 * 		2011-07-01T19:00:00.000+04:00 —
		 * 		7 p.m. on July 1, 2011 in the time zone Europe/Moscow (UTC+04:00).
		 *
		 * In Russian:
		 * «Момент обработки запроса по часам в системе магазина.»
		 * An example: «2011-05-04T20:38:11.000+04:00».
		 * Type: dateTime.
		 * https://tech.yandex.ru/money/doc/payment-solution/reference/datatypes-docpage
		 * Временная метка согласно стандарту RFC3339 в следующем формате:
		 * YYYY-MM-DDThh:mm:ss.fZZZZZ
		 * Расшифровка формата:
		 * 		YYYY — год, точно 4 цифры;
		 * 		MM — месяц, точно 2 цифры (01 — январь и т. д.);
		 * 		DD — день месяца, точно 2 цифры (от 01 до 31);
		 * 		T — латинский символ «T», должен быть в верхнем регистре;
		 * 		hh — часы, точно 2 цифры (24-часовой формат, от 00 до 23);
		 * 		mm — минуты, точно 2 цифры (от 00 до 59);
		 * 		ss — секунды, точно 2 цифры (от 00 до 59);
		 * 		f — дробная часть секунды (от 1 до 6 цифр).
		 * 			Может отсутствовать, в этом случае следует опускать и разделитель «.» (точку);
		 * 		ZZZZZ — часовой пояс, может принимать значения:
		 * 			Z - UTC, символ «Z» должен быть в верхнем регистре;
		 * 			+ hh: mm или -hh:mm — смещение относительно UTC (GMT)
		 * 			(показывает, что указано локальное время,
		 * 			которое на данное число часов и минут опережает или отстает от UTC).
		 * Пример:
		 * 		2011-07-01T19:00:00.000+04:00 —
		 * 		19 часов 1 июля 2011 года, часовой пояс Europe/Moscow (UTC+04:00).
		 */
		,'performedDatetime' => ZD::now()->toString(ZD::ISO_8601)
		# 2017-10-03
		# «Store ID. Must match the `shopId` field in the request.»
		# «Идентификатор магазина. Должен дублировать поле `shopId` запроса.»
		,'shopId' => $this->_ev->r('shopId')
		# 2017-10-03
		# «Additional text explanation of the merchant's response.
		# This is usually used for more detailed information about errors. Optional field.»
		# «Дополнительное текстовое пояснение ответа магазина.
		# Как правило, используется как дополнительная информация об ошибках. Необязательное поле.»
		# String(64)
		,'techMessage' => 'Author: Dmitrii Fediuk (https://mage2.pro, admin@mage2.pro)'
	] + (!$this->_ex ? [] : [
		# 2017-10-03
		# «Text explanation if the payment is not accepted» / «Текстовое пояснение в случае отказа принять платеж»
		# String(255)
		'message' => df_chop($this->_ex->message(), 255)
	]);}

	/**
	 * 2021-12-03
	 * @override
	 * @see \Df\Framework\W\Result\Xml::tag()
	 * @used-by \Df\Framework\W\Result\Xml::__toString()
	 */
	final protected function tag():string {return "{$this->_ev->t()}Response";}

	/**
	 * 2017-10-02
	 * @used-by self::attributes()
	 * @used-by self::i()
	 * @used-by self::tag()
	 * @var Ev
	 */
	private $_ev;

	/**
	 * 2017-10-02
	 * @used-by self::attributes()
	 * @used-by self::i()
	 * @var Ex|null
	 */
	private $_ex;

	/**
	 * 2017-10-02
	 * @used-by \Dfe\YandexKassa\W\Responder::error()
	 * @used-by \Dfe\YandexKassa\W\Responder::success()
	 * @param Ex|null $ex [optional]
	 * @return self
	 */
	final static function i(Ev $ev, Ex $ex = null) {
		/** @var self $i */ $i = new self; $i->_ev = $ev; $i->_ex = $ex; return $i;
	}
}