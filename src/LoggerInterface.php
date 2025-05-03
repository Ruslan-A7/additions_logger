<?php

namespace RA7\Framework\Additions\Logger;

use RA7\Framework\Structure\Singleton\SingletonInterface;
use RA7\Framework\Additions\Logger\Logs\LogInterface;

/**
 * Інтерфейс універсального реєстратора, що може вести різні типи журналів у будь-якій кількості.
 *
 * @author Ruslan_A7 (RA7) <https://ra7.iuid.cc>
 * Код може містити деякі частини, що були створені за допомогою ChatGPT.
 * @license RA7 Open Free License
 * @github <https://github.com/Ruslan-A7>
 */
interface LoggerInterface extends SingletonInterface {

    /**
     * Масив журналів логувальника
     * @var array<string, LogInterface>
     */
    public array $logs {get;}



    /** Додати новий журнал логувальника */
    public function addLog(string $name, LogInterface $log): void;

    /** Видалити журнал логувальника */
    public function deleteLog(string $name): void;

    /** Очистити список журналів логувальника */
    public function clearLogs(): void;

}