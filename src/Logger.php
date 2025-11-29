<?php

namespace RA7\Framework\Additions\Logger;

use RA7\Framework\Structure\Singleton\SingletonTrait;
use RA7\Framework\Additions\Logger\Logs\LogInterface;

/**
 * Універсальний реєстратор, що може вести різні типи журналів у будь-якій кількості.
 *
 * @author Ruslan_A7 (RA7) <https://ra7.iuid.cc>
 * Код може містити деякі частини, що були створені за допомогою ChatGPT.
 * @license RA7 Open Free License <https://ra7.iuid.cc/LICENSE>
 * @github <https://github.com/Ruslan-A7>
 */
class Logger implements LoggerInterface {

    use SingletonTrait;

    /** Версія цього класу */
    const VERSION = '1.0.0';

    /**
     * Масив журналів логувальника
     * @var array<string, LogInterface>
     */
    public protected(set) array $logs = [];

    /** Ідентифікатор (порядковий номер) останнього запису реєстратора (рахує всі записи в усі журнали) в межах поточного запиту */
    public protected(set) int $lastId = 0;



    private function __construct() {
        // $this->add('Start Logging: ' . date('d.m.Y H:i:s', time()));
    }



    public function getNewId(): int {
        return $this->lastId++;
    }

    public function addLog(string $id, LogInterface $log): void {
        $this->logs[$id] = $log;
    }

    public function saveAll(): bool {
        if (empty($this->logs)) {
            return false;
        }
        foreach ($this->logs as $id => $log) {
            if ($log->saveAll()) {
                continue;
            } else {
                return false;
            }
        }
        return true;
    }

    public function deleteLog(string $id): void {
        unset($this->logs[$id]);
    }

    public function clearLogs(): void {
        $this->logs = [];
    }

}