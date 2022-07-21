<?php

abstract class TransactionImpl implements Transaction
{
    protected PDO $connection;
    protected Logger $logger;

    public function __construct()
    {
        $this->logger = Logger::getLogger();
        $this->connection = ModelConnection::getConnection();
//        $this->connection = new PDO('mysql:host=localhost;dbname=my_db_test;charset=utf8', 'root', 'mynewpassword');
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