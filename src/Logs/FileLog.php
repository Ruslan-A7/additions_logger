<?php

namespace RA7\Framework\Additions\Logger\Logs;

use DateTime;
use DateTimeZone;

/**
 * Файловий журнал реєстратора.
 *
 * @author Ruslan_A7 (RA7) <https://ra7.iuid.cc>
 * Код може містити деякі частини, що були створені за допомогою ChatGPT.
 * @license RA7 Open Free License
 * @github <https://github.com/Ruslan-A7>
 */
class FileLog extends LogAbstract implements FileLogInterface {

    /** Шлях до файлу журналу */
    public protected(set) string $path {
        get => $this->path;
    }



    /**
     * Створити файловий журнал.
     *
     * Важливо! Шлях вже має бути нормалізованим згідно роздільника директорій для поточної ОС
     * (для цього доступні наступні функції: dsNormalize, pathNormalize, pathNormalizePlus з пакету ra7/utils_path-normalize).
     *
     * @param string $path шлях до файлу журналу
     * @param LogOptions $options опції журналу
     */
    public function __construct(string $path, LogOptions $options = new LogOptions()) {
        parent::__construct($options);
        $this->path = $path;
    }



    public function save(): bool {
        createEmptyDirsToFile($this->path);
        return file_put_contents($this->path, implode("\n", $this->data), FILE_APPEND) !== false;
    }

    public function delete(): bool {
        $this->data = [];
        return deleteFile($this->path);
    }

    protected function createLog(): bool {
        createEmptyDirsToFile($this->path);
        return false;
    }

    protected function autoLoggingInitialization(): void {
        $this->data[0] = "\n";
        $this->data[1] =
            "[{$this->options->initiator->name}][{$this->options->type->name}][" .
            new DateTime(timezone: new DateTimeZone('Europe/Kyiv'))->format('Y-m-d H:i:s.u') . '] >> LOGGING START >>';
    }

}