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

    /** Статус завантаження цього журналу */
    public bool $loaded {get;}

    /** Опції журналу реєстратора */
    public LogOptions $options {get;}



    /** Отримати масив з усіма збереженими записами цього журналу (за потреби завантажує їх з файлу/БД) */
    public function load(): array;

    /** Отримати масив з усіма збереженими записами цього журналу з перезавантаженням існуючого масиву */
    public function reload(): array;



    /** Отримати всі дані для запису в цей журнал */
    public function getAll(): array;

    /**
     * Додати запис в цей журнал.
     * Важливо! Для реального збереження записів після їх додавання потрібно викликати метод saveAll
     * (якщо в опціях журналу не вказано необхідність автоматичного збереження журналу при завершенні роботи),
     * або додавати запис через метод addWithSaving (що автоматично зберігає запис після додавання) - інакше записи буде втрачено!
     *
     * Щоб переглянути всі додані записи - скористайтесь методом getAll.
     */
    public function add(string $message = '', ?InitiatorsEnum $initiator = null, ?RecordTypesEnum $type = null): void;

    /**
     * Додати запис в цей журнал з його автоматичним збереженням.
     * Важливо! При цьому, для уникнення дублювань записів, збережені та додані і поки не збережні записи знаходяться в окремих масивах!
     *
     * Щоб переглянути всі збережені записи - скористайтесь методом load або reload.
     *
     * @return true якщо запис вдалося зберегти
     * @return false якщо запис не вдалося зберегти
     */
    public function addWithSaving(string $message = '', ?InitiatorsEnum $initiator = null, ?RecordTypesEnum $type = null): bool;

    /** Зберегти всі записи в журнал */
    public function saveAll(): bool;

    /** Зберегти один запис в журнал */
    public function saveOne(string $message): bool;

    /** Видалити журнал (всі дані з нього буде втрачено) */
    public function delete(): bool;

}