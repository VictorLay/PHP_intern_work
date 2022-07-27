<?php


class DeleteHtml extends AuthenticationHtml
{
    public static function writeDeleteUserHtmlForm(int $id): void
    {
        $deleteUrl = SHOW_ALL_USERS_PAGE . "/$id" . DELETE_URN;
        $homePageUrl = HOME_PAGE;
        echo "<h2>Do you want to delete user with id $id</h2>
       <form action='$deleteUrl' method='post'><br/>
            <input type='submit' value='delete user'/><br/><br/>      
       </form>
       <form action='$homePageUrl' method='post'><br/>
            <input type='submit' value='cancel'/><br/><br/>
       </form>";
    }

    public static function writeSuccessDeletingMessage(User $user): void
    {
        {
            $homePageUrl = HOME_PAGE;
            $userWrite = $user;
            $userWrite .= "<td></td>";

            echo "<head>
                
                <style>
                table {
                  font-family: arial, sans-serif;
                  border-collapse: collapse;
                  width: 100%;
                }
                
                td, th {
                  border: 1px solid #dddddd;
                  text-align: left;
                  padding: 8px;
                }
                
                tr:nth-child(even) {
                  background-color: #dddddd;
                }
                </style>
                </head>
                <body>
                
                    <h2>Пользователь {$user->getEmail()} с ID {$user->getId()} успешно удалён</h2>
                    <a href='$homePageUrl'>HOME</a>
                    <table>
                      <tr>
                        <th>avatar</th>
                        <th>id</th>
                        <th>email</th>
                        <th>country</th>
                        <th>name</th>
                        <th>role</th>
                        <th>Update</th>
                      </tr>
                      <tr>
                        $userWrite 
                      </tr>  
                    </table>
                </body>";
        }

    }
}