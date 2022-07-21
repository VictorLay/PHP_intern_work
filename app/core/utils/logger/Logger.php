<?php

class Logger
{
    private static string $PATH;
    private static array $loggers = array();

    private string $name;
    private $fp;
    private string $logLevel;

    private function __construct($name, $file = null)
    {
        $this->name = $name;
        $this->logLevel = INFO_LEVEL;
        $this->open();
    }

    /**
     * @param int|string $logLevel
     */
    public function setLogLevel(int|string $logLevel): void
    {
        $this->logLevel = $logLevel;
    }


    private function open(): void
    {
        self::$PATH = "/var/www/html/app-resources/";
        $this->fp = fopen(self::$PATH . 'logs.log', 'a+');
    }

    public static function getLogger($name = 'root', $file = null)
    {
        if (!isset(self::$loggers[$name])) {
            self::$loggers[$name] = new Logger($name, $file);
        }

        return self::$loggers[$name];
    }

    public function log($message, int|string $level = INFO_LEVEL, string $className = null): void
    {
        if ($level <= $this->logLevel) {
            $log = '|' . $this->name . '| ' . $this->getLogLevel($level) . ' [' . date('D M d H:i:s Y', time()) .
                '] ' . debug_backtrace()[0]['file'] . $className . ': ';
            $log .= $message;
            $log .= "\n";
            $this->_write($log);
        }
    }

    private function getLogLevel(int|string $logLevel): string
    {
        return match ($logLevel) {
            1 => "[FATAL.LEVEL]",
            2 => "[ERROR.LEVEL]",
            3 => "[DEBUG.LEVEL]",
            4 => "[WARN.LEVEL]",
            5 => "[INFO.LEVEL]",
            default => "[NAN]",
        };
    }

    protected function _write(string $string): void
    {
        fwrite($this->fp, $string);
    }

    public function __destruct()
    {
        fclose($this->fp);
    }
}