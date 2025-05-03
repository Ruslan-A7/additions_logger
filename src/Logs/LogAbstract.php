<?php

namespace RA7\Framework\Additions\Logger\Logs;

use RA7\Framework\System\Enums\InitiatorsEnum;

/**
 * Абстрактний журналу реєстратора.
 *
 * @author Ruslan_A7 (RA7) <https://ra7.iuid.cc>
 * Код може містити деякі частини, що були створені за допомогою ChatGPT.
 * @license RA7 Open Free License
 * @github <https://github.com/Ruslan-A7>
 */
abstract class LogAbstract implements LogInterface {

    /** Опції журналу */
    public protected(set) LogOptions $options {
        get => $this->options;
    }

    /** Дані для запису лише в цей журнал */
    protected array $data = [];



    /**
     * Створити журнал.
     *
     * @param LogOptions $options опції журналу
     */
    public function __construct(LogOptions $options = new LogOptions()) {
        $this->options = $options;
        !$this->options->autoLoggingInitialization ? /* skip */ : $this->autoLoggingInitialization();
    }

    /**
     * Видалити об'єкт журналу (не видаляє сам журнал, а лише завершує його роботу).
     * ВАЖЛИВО! При видаленні автоматично зберігає журнал якщо в нього попали якісь дані,
     * а в опціях визначено необхідність автоматичного збереження журналу при завершенні роботи!
     */
    public function __destruct() {
        if ($this->options->autoSaveOnDestructionRequired) {
            empty($this->data) ? /* skip */ : $this->save();
        }
    }



    public function getAll(): array {
        return $this->data;
    }

    public function add(string $message = '', ?InitiatorsEnum $initiator = null, ?RecordTypesEnum $type = null): void {
        if (empty($message) || $message === "\n") {
            $this->data[array_key_last($this->data)+1] = '';
        } else {
            $type ?? $type = $this->options->type;
            $initiator ?? $initiator = $this->options->initiator;
            $this->data[array_key_last($this->data)+1] = "[{$initiator->name}][{$type->name}] >> $message";
        }
    }

    /**
     * Створити порожній журнал реєстратора згідно його типу.
     * Призначено на випадок якщо журнал не знайдено при ініціалізації,
     * а в опціях зазначено необхідність автоматичного створення журналу в таких випадках!
     */
    protected abstract function createLog(): bool;

    /** Додати автоматичний запис в журнал при його ініціалізації */
    protected abstract function autoLoggingInitialization(): void;

}