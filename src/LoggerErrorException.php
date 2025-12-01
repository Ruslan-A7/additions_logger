<?php

namespace RA7\Framework\Additions\Logger;

use RA7\Framework\System\Exception\Exception;
use Throwable;
use RA7\Framework\System\Exception\ExceptionDetails;
use RA7\Framework\System\Enums\EventInitiatorsEnum;
use RA7\Framework\System\Enums\TypesEventsEnum;

/**
 * Помилка реєстратора (логувальника).
 * Призначено для помилок пов'язаних з реєстратором (логуванням).
 *
 * @author Ruslan_A7 (RA7) <https://ra7.iuid.cc>
 * Код може містити деякі частини, що були створені за допомогою ChatGPT.
 * @license RA7 Open Free License <https://ra7.iuid.cc/LICENSE>
 * @github <https://github.com/Ruslan-A7>
 */
class LoggerErrorException extends Exception {

    /**
     * Створити помилку конфігурації.
     *
     * @param string $message опис помилки
     * @param int $code код винятку
     * @param null|Throwable $previous попередній виняток (використовується для відстеження ланцюжків винятків)
     */
    public function __construct(string $message, int $code = 0, ?Throwable $previous = null) {
        $this->details = new ExceptionDetails(EventInitiatorsEnum::Logger, TypesEventsEnum::Error);

        parent::__construct($message, $this->details, $code, $previous);
    }

}