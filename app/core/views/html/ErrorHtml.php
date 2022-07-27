<?php

namespace app\core\views\html;


class ErrorHtml
{

    public static function write404ErrorPage(): void
    {
        $HOME_PAGE = HOME_PAGE;
        echo "<head>
                    <meta name='robots' content='noindex,nofollow'>
                    <meta charset='utf-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                    <title>404 Page Not Found</title>
                    <link href='/templates/Default/css/styles.css' rel='stylesheet'>
                    <style>
                        body {align-items: center;background-color: #f5f5f5;display: flex;height: 100vh;justify-content: center;margin: 0;}
                        .container {text-align: center;}
                        .container h1 {font-size: 8rem;letter-spacing: 10px;margin: 0;}
                        .container h4 {font-size: 1.25rem;font-weight: 300;}
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <h1>404</h1>
                        <h2>Мы не можем найти страницу, которую вы ищете.</h2>
                        <h4>Страница, которую вы запросили, не найдена в базе данных.<br> Скорее всего вы попали на битую ссылку или опечатались при вводе URL</h4>
                        <p class='box_in'><a href='$HOME_PAGE'>Перейти на главную страницу</a></p>
                            <img src='http://localhost/img/errors/error404.jpg' width=1080 height=500>
                        <p>please don't fire the developer. © 2022</p>
                    </div>
                </body>";
    }

    public static function write403ErrorPage(): void
    {
        $HOME_PAGE = HOME_PAGE;
        echo "<head>
                    <meta name='robots' content='noindex,nofollow'>
                    <meta charset='utf-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                    <title>404 Page Not Found</title>
                    <link href='/templates/Default/css/styles.css' rel='stylesheet'>
                    <style>
                        body {align-items: center;background-color: #f5f5f5;display: flex;height: 100vh;justify-content: center;margin: 0;}
                        .container {text-align: center;}
                        .container h1 {font-size: 8rem;letter-spacing: 10px;margin: 0;}
                        .container h4 {font-size: 1.25rem;font-weight: 300;}
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <h1>403</h1>
                        <h2>Ограничен или отсутствует доступ к материалу на странице.</h2>
    
                        <h4>
                            Страница, которую вы запросили, не доступна.<br> 
                            Скорее всего вы не авторизированы или не имеете прав доступа к странице.
                        </h4>
                        <p class='box_in'><a href='$HOME_PAGE'>Перейти на главную страницу</a></p>
                           <img src='http://localhost/img/errors/error403.jpg' width=1080 height=500>
                        <p>please don't fire the developer. © 2022</p>
                    </div>
                </body>";
    }

    public static function write405ErrorPage(): void
    {
        $HOME_PAGE = HOME_PAGE;
        echo "<head>
                    <meta name='robots' content='noindex,nofollow'>
                    <meta charset='utf-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                    <title>404 Page Not Found</title>
                    <link href='/templates/Default/css/styles.css' rel='stylesheet'>
                    <style>
                        body {align-items: center;background-color: #f5f5f5;display: flex;height: 100vh;justify-content: center;margin: 0;}
                        .container {text-align: center;}
                        .container h1 {font-size: 8rem;letter-spacing: 10px;margin: 0;}
                        .container h4 {font-size: 1.25rem;font-weight: 300;}
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <h1>405</h1>
                        <h2>Cервер получил определенный запрос с заданным HTTP-методом, смог его распознать, <br>
                        но не дает добро на его реализацию.</h2>
    
                        <h4>
                            Запрашиваемая страница существует и функционирует. <br>
                            Cтоит изменить используемый в HTTP-запросе метод. Иначе ничего не выйдет. 
                        </h4>
                        <p class='box_in'><a href='$HOME_PAGE'>Перейти на главную страницу</a></p>
                           <img src='http://localhost/img/errors/error405.jpg' width=1080 height=500>
                        <p>please don't fire the developer. © 2022</p>
                    </div>
                </body>";
    }
    public static function write422ErrorPage(): void
    {
        $HOME_PAGE = HOME_PAGE;
        echo "<head>
                    <meta name='robots' content='noindex,nofollow'>
                    <meta charset='utf-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
                    <title>404 Page Not Found</title>
                    <link href='/templates/Default/css/styles.css' rel='stylesheet'>
                    <style>
                        body {align-items: center;background-color: #f5f5f5;display: flex;height: 100vh;justify-content: center;margin: 0;}
                        .container {text-align: center;}
                        .container h1 {font-size: 8rem;letter-spacing: 10px;margin: 0;}
                        .container h4 {font-size: 1.25rem;font-weight: 300;}
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <h1>422</h1>
                        <h2>Брат, ты отправил не хороший запрос</h2>
    
                        <h4>
                            Запрос распознан, но обработке не подлежит.<br> 
                            Скорее всего вы отправили данные используя не надлежащуу форму.
                        </h4>
                        <p class='box_in'><a href='$HOME_PAGE'>Перейти на главную страницу</a></p>
                           <img src='http://localhost/img/errors/error422.png' width=1080 height=500>
                        <p>please don't fire the developer. © 2022</p>
                    </div>
                </body>";
    }

}