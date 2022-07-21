<?php

interface Router
{
    public static function getController($uri): Controller;
}