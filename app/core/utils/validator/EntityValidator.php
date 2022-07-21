<?php

interface EntityValidator
{
    public static function isValid(Entity $entity):bool;
}