<?php

namespace RA7\Framework\Additions\Logger\Logs;

/**
 * Список доступних типів записів в журналі реєстратора.
 *
 * @author Ruslan_A7 (RA7) <https://ra7.iuid.cc>
 * Код може містити деякі частини, що були створені за допомогою ChatGPT.
 * @license RA7 Open Free License
 * @github <https://github.com/Ruslan-A7>
 */
enum RecordTypesEnum {

    /** Налагодження (тільки для тестування) */
    case Debug;

    /** Інформація */
    case Info;

    /** Сповіщення */
    case Notice;

    /** Попередження */
    case Warning;

    /** Сповіщення про застарілий функціонал */
    case Deprecated;

    /** Сповіщення про експериментальний функціонал */
    case Experimental;

    /** Трапилась виняткова ситуація */
    case Exception;

    /** Трапилась критична помилка але її можна обробити */
    case RecoverableError;

    /** Трапилась фатальна помилка без можливості обробки */
    case Error;

    /**
     * Тільки для розробника - призначено для записів не доступних користувачам, а лише розробникам
     * (наприклад, для збереження певної інформації в лог без сповіщення користувачу)
     */
    case DevOnly;

}