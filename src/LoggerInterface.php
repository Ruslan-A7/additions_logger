<?php

namespace RA7\Framework\Additions\Logger;

use RA7\Framework\Structure\Singleton\SingletonInterface;
use RA7\Framework\Additions\Logger\Logs\LogInterface;

/**
 * Інтерфейс універсального реєстратора, що може вести різні типи журналів у будь-якій кількості.
 *
 * @author Ruslan_A7 (RA7) <https://ra7.iuid.cc>
 * Код може містити деякі частини, що були створені за допомогою ChatGPT.
 * @license RA7 Open Free License <https://ra7.iuid.cc/LICENSE>
 * @github <https://github.com/Ruslan-A7>
 */
interface LoggerInterface extends SingletonInterface {

    /**
     * Масив журналів логувальника
     * @var array<string, LogInterface>
     */
    public array $logs {get;}

    /** Ідентифікатор (порядковий номер) останнього запису реєстратора (рахує всі записи в усі журнали) в межах поточного запиту */
    public int $lastId {get;}



    /** Отримати новий ідентифікатор (порядковий номер) запису в журналі цього реєстратора */
    public function getNewId(): int;

    /** Додати новий журнал логувальника */
    public function addLog(string $name, LogInterface $log): void;

    /**
     *  Зберегти всі записи в усіх журналах.
     *
     * @return true якщо було додано хоча б один журнал і всі вони змогли зберегти свої записи
     * @return false якщо жоден журнал не було додано або один з них не зміг зберегти свої записи
     */
    public function saveAll(): bool;

    /** Видалити журнал логувальника */
    public function deleteLog(string $name): void;

    /** Очистити список журналів логувальника */
    public function clearLogs(): void;

}