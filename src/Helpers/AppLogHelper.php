<?php

namespace Vanier\Api\Helpers;

use DateTimeZone;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class AppLogHelper
{
    // -- Various loggers having different Logging chanels
    // private static $logger = null;
    // private static $db_logger = null;

    private $logger = null;
    private $db_logger = null;
    public function __construct()
    {
        $this->initLoggers();
    }

    public function initLoggers()
    {
        // --1 A new Log channel for general message
        $this->logger = new Logger("nobel_prize_log");
        $this->logger->setTimezone(new DateTimeZone('America/Toronto'));
        $log_handler = new StreamHandler(APP_LOG_DIR, Logger::DEBUG);
        $this->logger->pushHandler($log_handler);
        // --2 A new log channel for database
        $this->db_logger = new Logger("database_logs");
        $this->db_logger->pushHandler($log_handler);
    }

    public function getAppLogger()
    {
        return $this->logger;
    }

    public function getDatabaseLogger()
    {
        return $this->db_logger;
    }
}
