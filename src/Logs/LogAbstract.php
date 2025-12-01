<?php

namespace RA7\Framework\Additions\Logger\Logs;

use RA7\Framework\System\Enums\EventInitiatorsEnum;
use RA7\Framework\System\Enums\TypesEventsEnum;
use RA7\Framework\Additions\Logger\Logger;

/**
 * Абстрактний журналу реєстратора.
 *
 * @author Ruslan_A7 (RA7) <https://ra7.iuid.cc>
 * Код може містити деякі частини, що були створені за допомогою ChatGPT.
 * @license RA7 Open Free License <https://ra7.iuid.cc/LICENSE>
 * @github <https://github.com/Ruslan-A7>
 */
abstract class LogAbstract implements LogInterface {

    /** Статус завантаження цього журналу */
    public protected(set) bool $loaded = false {
        get => $this->loaded;
    }

    /** Опції журналу */
    public protected(set) LogOptions $options {
        get => $this->options;
    }

    /** Дані для запису лише в цей журнал */
    protected array $data = [];

    /** Масив збережених записів журналу */
    protected array $savedData = [];



    /**
     * Створити журнал.
     *
     * @param LogOptions $options опції журналу
     */
    public function __construct(LogOptions $options = new LogOptions()) {
        $this->options = $options;
        !$this->options->createLogIfNotFound ? /* skip */ : $this->createLog();
        !$this->options->autoRecordingOfTheStart ? /* skip */ : $this->autoRecordingOfTheStart();
    }

    /**
     * Видалити об'єкт журналу (не видаляє сам журнал, а лише завершує його роботу).
     * ВАЖЛИВО! При видаленні автоматично зберігає журнал якщо в нього попали якісь дані,
     * а в опціях визначено необхідність автоматичного збереження журналу при завершенні роботи!
     * Також додається автоматичний запис про завершення якщо в опціях autoRecordingOfTheEnding = true.
     */
    public function __destruct() {
        !$this->options->autoRecordingOfTheEnding ? /* skip */ : $this->autoRecordingOfTheEnding();
        if ($this->options->autoSaveOnDestructionRequired) {
            empty($this->data) ? /* skip */ : $this->saveAll();
        }
    }



    public function getAll(): array {
        return $this->data;
    }

    public function add(string $message = '', ?EventInitiatorsEnum $initiator = null, ?TypesEventsEnum $type = null): void {
        if (empty($message) || $message === "\n" || $message === '\n') {
            $message = '';
        } else {
            $type = $type ? $type->name : $this->options->type->name;
            $initiator = $initiator ? $initiator->name : $this->options->initiator->name;
            $message = '[#' . Logger::instance()->getNewId() . "][{$initiator}][{$type}] >> $message";
        }
        $this->data[array_key_last($this->data)+1] = $message;
    }

    public function addWithSaving(string $message = '', ?EventInitiatorsEnum $initiator = null, ?TypesEventsEnum $type = null): bool {
        if (empty($message) || $message === "\n" || $message === '\n') {
            $message = '';
        } else {
            $type = $type ? $type->name : $this->options->type->name;
            $initiator = $initiator ? $initiator->name : $this->options->initiator->name;
            $message = '[#' . Logger::instance()->getNewId() . "][{$initiator}][{$type}] >> $message";
        }
        $this->savedData[array_key_last($this->savedData)+1] = $message;
        return $this->saveOne($message);
    }

    /**
     * Створити порожній журнал реєстратора згідно його типу.
     * Призначено на випадок якщо журнал не знайдено при ініціалізації,
     * а в опціях зазначено необхідність автоматичного створення журналу в таких випадках!
     */
    protected abstract function createLog(): bool;

    /** Додати автоматичний запис в журнал при його ініціалізації */
    protected abstract function autoRecordingOfTheStart(): void;

    /** Додати автоматичний запис в журнал при завершенні його роботи */
    protected abstract function autoRecordingOfTheEnding(): void;

}