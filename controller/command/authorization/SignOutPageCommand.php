<?php

class SignOutPageCommand implements Command
{

    public function execute(): void
    {
        HtmlPageWriter::writeSignOutWarning();
    }
}