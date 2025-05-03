<?php

namespace RA7\Framework\Additions\Logger\Logs;

use RA7\Framework\System\Enums\InitiatorsEnum;

/**
 * Інтерфейс журналу реєстратора.
 *
 * @author Ruslan_A7 (RA7) <https://ra7.iuid.cc>
 * Код може містити деякі частини, що були створені за допомогою ChatGPT.
 * @license RA7 Open Free License
 * @github <https://github.com/Ruslan-A7>
 */
interface LogInterface {

    /** Опції журналу реєстратора */
    public LogOptions $options {get;}

    /** Отримати всі дані для запису в цей журнал */
    public function getAll(): array;

    /** Додати запис в цей журнал */
    public function add(string $message = '', ?InitiatorsEnum $initiator = null, ?RecordTypesEnum $type = null): void;
    
    /** Зберегти всі дані в журнал */
    public function save(): bool;
    
    /** Видалити журнал (всі дані з нього буде втрачено) */
    public function delete(): bool;

}