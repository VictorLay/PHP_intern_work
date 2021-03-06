<?php
require_once "./controller/Command.php";
require_once "./util/HtmlPageWriter.php";
require_once "./service/factory/FactoryService.php";

class PageNotFoundCommand implements Command
{
    public function execute():void
    {
        HtmlPageWriter::write404ErrorPage();
    }
}