<?php

namespace RA7\Framework\Additions\Logger\Logs;

use DateTime;
use DateTimeZone;
use Exception;
use RA7\Framework\Additions\Logger\Logger;

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
        $this->path = $path;

        parent::__construct($options);

        if (!file_exists($this->path)) {
            throw new Exception('Файл журналу "' . $this->path . '" не знайдено!
            Створіть його вручну або перевизначіть значення опції createLogIfNotFound на true для його автоматичного створення.');
        }
    }



    public function load(): array {
        if (!$this->loaded) {
            ob_start();
            include $this->path;
            $this->savedData = explode("\n", ob_get_clean());
            $this->loaded = true;
        }
        return $this->savedData;
    }

    public function reload(): array {
        ob_start();
        include $this->path;
        $this->savedData = explode("\n", ob_get_clean());
        $this->loaded = true;
        return $this->savedData;
    }



    public function saveAll(): bool {
        createEmptyDirsToFile($this->path);
        return file_put_contents($this->path, implode("\n", $this->data), FILE_APPEND) !== false;
    }
    public function saveOne(string $message): bool {
        createEmptyDirsToFile($this->path);
        return file_put_contents($this->path, "\n" . $message, FILE_APPEND) !== false;
    }

    public function delete(): bool {
        $this->data = [];
        return deleteFile($this->path);
    }



    protected function createLog(): bool {
        createEmptyDirsToFile($this->path);
        if (!file_exists($this->path)) {
            return file_put_contents($this->path, '') !== false;
        }
        return false;
    }

    protected function autoRecordingOfTheStart(): void {
        $this->data[0] = "\n";
        $this->data[1] =
            '[#' . Logger::instance()->getNewId() . "][{$this->options->initiator->name}][{$this->options->type->name}][" .
            new DateTime(timezone: new DateTimeZone('Europe/Kyiv'))->format('Y-m-d H:i:s.u') . '] >> LOGGING START >>';
    }

    protected function autoRecordingOfTheEnding(): void {
        $this->data[array_key_last($this->data)+1] =
            '[#' . Logger::instance()->getNewId() . "][{$this->options->initiator->name}][{$this->options->type->name}][" .
            new DateTime(timezone: new DateTimeZone('Europe/Kyiv'))->format('Y-m-d H:i:s.u') . '] >> LOGGING END >>';
    }

}