<?php

namespace RA7\Framework\Additions\Logger\Logs;

use RA7\Framework\System\Enums\InitiatorsEnum;
use Exception;

/**
 * Опції журналу реєстратора.
 * Можна використовувати для додаткового налаштування самого журналу.
 *
 * @author Ruslan_A7 (RA7) <https://ra7.iuid.cc>
 * Код може містити деякі частини, що були створені за допомогою ChatGPT.
 * @license RA7 Open Free License
 * @github <https://github.com/Ruslan-A7>
 */
class LogOptions {

    /** Ініціатор запису в журнал за замовчуванням */
    public protected(set) InitiatorsEnum $initiator {
        get => $this->initiator;
    }

    /** Тип запису в журналі за замовчуванням */
    public protected(set) RecordTypesEnum $type {
        get => $this->type;
    }

    /** Необхідність автоматичного створення порожнього журналу згідно його типу */
    public protected(set) bool $createLogIfNotFound {
        get => $this->createLogIfNotFound;
    }

    /** Необхідність автоматичного запису в журнал при його ініціалізації */
    public protected(set) bool $autoLoggingInitialization {
        get => $this->autoLoggingInitialization;
    }

    /** Необхідність автоматичного збереження журналу при завершенні роботи (ігнорується якщо в журнал нічого не додавалось) */
    public protected(set) bool $autoSaveOnDestructionRequired {
        get => $this->autoSaveOnDestructionRequired;
    }



    /**
     * Створити журнал реєстратора.
     *
     * @param InitiatorsEnum $initiator ініціатор запису в журнал за замовчуванням
     * @param RecordTypesEnum $type тип запису в журналі за замовчуванням
     * @param bool $createLogIfNotFound необхідність автоматичного створення журналу якщо його не знайдено
     * @param bool $autoLoggingInitialization необхідність автоматичного запису в журнал при його ініціалізації
     * @param bool $autoSaveOnDestructionRequired необхідність автоматичного збереження журналу при завершенні роботи
     * (буде ігноруватись якщо в журнал нічого не додавалось)
     */
    public function __construct(
        InitiatorsEnum $initiator = InitiatorsEnum::App,
        RecordTypesEnum $type = RecordTypesEnum::Info,
        bool $createLogIfNotFound = true,
        bool $autoLoggingInitialization = false,
        bool $autoSaveOnDestructionRequired = true) {

        $this->initiator = $initiator;
        $this->type = $type;
        $this->createLogIfNotFound = $createLogIfNotFound;
        $this->autoLoggingInitialization = $autoLoggingInitialization;
        $this->autoSaveOnDestructionRequired = $autoSaveOnDestructionRequired;
    }

    /**
     * Визначити значення вказаної властивості.
     * Тип значення має відповідати типу властивості!
     */
    public function set(string $propName, $value) {
        if (property_exists($this, $propName)) {
            $this->$propName = $value;
        } else {
            throw new Exception('Опції журналу не мають властивості: ' . $propName);
        }
    }

}