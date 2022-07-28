<?php

namespace app\courses\views\html;

class SearchHtml
{
    public static function writeSearchPage(): void
    {
        echo "
<form method='get'>
    <input type='text' name='search' placeholder='Введите название курса'/>
    <input type='submit' value='Найти...'>
</form>
";
    }
}