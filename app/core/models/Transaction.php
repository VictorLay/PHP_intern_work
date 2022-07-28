<?php

namespace app\core\models;

interface Transaction
{
    public function beginTransaction(): void;

    public function commit(): void;

    public function rollback(): void;
}