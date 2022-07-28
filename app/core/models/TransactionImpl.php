<?php

namespace app\core\models;

use PDO;
use app\core\utils\logger\Logger;
use app\core\models\connection\ModelConnection;

abstract class TransactionImpl implements Transaction
{
    protected PDO $connection;
    protected Logger $logger;

    public function __construct()
    {
        $this->logger = Logger::getLogger();
        $this->connection = ModelConnection::getConnection();
    }

    public function beginTransaction(): void
    {
        $this->connection->beginTransaction();
    }

    public function commit(): void
    {
        $this->connection->commit();
    }

    public function rollback(): void
    {
        $this->connection->rollBack();
    }
}