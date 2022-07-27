<?php

class ShowUsersHtml extends ProfileHtml
{


    public static function writeAllUsersForAdmin(array $users, int $pageQuantity, User $userFromSession): void
    {

//        $HOME_PAGE = HOME_PAGE;
        $SHOW_ALL_USERS_PAGE = SHOW_ALL_USERS_PAGE;
        $FIRST_PAGE = 1;
        $page = key_exists('page', $_GET) ? $_GET['page'] : $FIRST_PAGE;
        $usersWrite = self::prepareUserRowsForAdminTable($users, $userFromSession);

        echo
        "<head>
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
                <h2>HTML Table</h2>
                <table>
                  <tr>
                    <th>avatar</th>
                    <th>id</th>
                    <th>email</th>
                    <th>country</th>
                    <th>name</th>
                    <th>role</th>
                    <th>update</th>
                    <th>delete</th>
                  </tr>
                  $usersWrite
                </table>
                <form action='$SHOW_ALL_USERS_PAGE' method='get'>
                    <a href='?page=1'>1</a> ...
                    <a href='?page=$pageQuantity'>$pageQuantity</a>
                    <input type='text' name='page' placeholder='$page'/>
                    <input type='submit' value='перейти'/>
                </form>
            </body>";
    }

    public static function writeAllUsersForUser(array $users, int $pageQuantity): void
    {
        $SHOW_ALL_USERS_PAGE = SHOW_ALL_USERS_PAGE;
        $firstPage = 1;
        $page = key_exists('page', $_GET) ? $_GET['page'] : $firstPage;
        $usersWrite = "";
        /** @var User $userInfo */
        foreach ($users as $userInfo) {
            $usersWrite .= "<tr>";
            $usersWrite .= $userInfo . "</tr>";
        }

        echo "<head>
                
                <!-- table -->
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
                    <h2>HTML Table</h2>
                    <table>
                      <tr>
                        <th>avatar</th>
                        <th>id</th>
                        <th>email</th>
                        <th>country</th>
                        <th>name</th>
                        <th>role</th>
                      </tr>" . $usersWrite . "
                    </table> 
                    <form action='$SHOW_ALL_USERS_PAGE' method='get'>
                        <a href='?page=$firstPage'>1</a> ...
                        <a href='?page=$pageQuantity '>$pageQuantity</a>
                        <input type='text' name='page' placeholder='$page'/>
                        <input type='submit' value='перейти'/>
                    </form>
                </body>";
    }

    private static function prepareUserRowsForAdminTable(array $users, User $userFromSession): string
    {
        $usersWrite = "";
        /** @var User $user */
        foreach ($users as $user) {
            $userRole = $user->getRole();
            $userId = $user->getId();
            $usersWrite .= self::parseUserToTable($user);

            $updateUserPage = SHOW_ALL_USERS_PAGE . "/$userId". UPDATE_URN;
            if ($userRole != ADMIN || $userFromSession->getId() == $userId) {
                $usersWrite .= "<td>
                                    <form action='$updateUserPage' method='get'>
                                        <input type='submit' value='update'>
                                    </form>
                                </td>";
            } else {
                $usersWrite .= "<td></td>";
            }

            $deleteUserPage = SHOW_ALL_USERS_PAGE. "/$userId".DELETE_URN;
            if ($userId != $userFromSession->getId() && $userRole != ADMIN) {
                $usersWrite .= "<td>
                                        <form action='$deleteUserPage' method='get'>
                                            <input type='submit' value='delete'>
                                        </form>
                                    </td>
                                </tr>";
            } else {
                $usersWrite .= "<td></td></tr>";
            }
        }
        return $usersWrite;
    }

    private static function parseUserToTable(User $user): string
    {
        $userAvatarPath = stristr($user->getAvatarPath(), "/");
        $userId = $user->getId();
        $userEmail = $user->getEmail();
        $userCountry = $user->getCountry();
        $userName = $user->getName();
        $userRole = $user->getRole();
        $SHOW_USER_PAGE = "SHOW_USER_PAGE";

        return
            "<td><img src='$userAvatarPath' width='70' height='70' ></td> \n
            <td>$userId</td> \n
            <td><a href='".SHOW_ALL_USERS_PAGE."/".$userId."'>$userEmail</a></td> \n
            <td>$userCountry</td> \n
            <td>$userName</td> \n
            <td>$userRole</td>\n";
    }
}