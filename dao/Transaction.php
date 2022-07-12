<?php

interface Transaction
{
    public function beginTransaction(): void;

    public function commit(): void;

    public function rollback(): void;
}