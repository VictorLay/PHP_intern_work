<?php

class PageNotFoundController implements Controller
{
    public function execute():void
    {
        HtmlPageWriter::write404ErrorPage();
    }
}