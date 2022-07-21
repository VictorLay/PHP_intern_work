<?php

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
                            <img src='http://localhost/resources/error404.jpg' width=1080 height=500>
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
                           <img src='http://localhost/resources/error403.jpg' width=1080 height=500>
                        <p>please don't fire the developer. © 2022</p>
                    </div>
                </body>";
    }

    public static function writeGetFormForIncorrectUserId(): void
    {
        $SHOW_ALL_USERS_PAGE = SHOW_ALL_USERS_PAGE;
        //предупреждение, что пользовтель с данным ид не найден
        echo "<h3>Пользователя с таким ID не существует</h3>
                    <h3>
                        Пожалуйста введите id другого пользователья.
                    </h3><br>
                    <a href='$SHOW_ALL_USERS_PAGE'>Вернуться к списку пользователей</a>            
                    <form method='get'>
                        <input type='text' name='user_id'>
                        <input type='submit' value='Посмотреть'>                        
                    </form>";
    }
}