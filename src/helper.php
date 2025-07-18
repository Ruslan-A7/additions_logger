<?php

use RA7\Framework\Additions\Logger\LoggerInterface;
use RA7\Framework\Additions\Logger\Logger;

/** Отримати екземпляр (Singleton) реєстратора (створивши його за відсутності) */
function logger(): LoggerInterface {
    return Logger::instance();
}