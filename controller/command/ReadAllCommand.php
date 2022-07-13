<?php
require_once "./controller/Command.php";
require_once "./util/HtmlPageWriter.php";
require_once "./service/factory/FactoryService.php";

class ReadAllCommand implements Command
{
    public function execute():void
    {
        $usersArray = FactoryService::getInstance()->getUserService()->showAll();
        HtmlPageWriter::writeAllUsers($usersArray);
    }
}