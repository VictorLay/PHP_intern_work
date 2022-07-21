<?php

class ProfileHtml extends HomeHtml
{


    public static function writeUserProfile(User $user): void
    {
        $HOME_PAGE = HOME_PAGE;
        $UPDATE_ANOTHER_USER_PAGE = UPDATE_ANOTHER_USER_PAGE;
        $userId = $user->getId();
        $userWrite = $user;
        if ($user->getRole() != ADMIN) {
            $userWrite .= "<td>
                         <form action='$UPDATE_ANOTHER_USER_PAGE' method='get'>
                           <input type='hidden' value='$userId' name='user_id'>
                           <input type='submit' value='update'>
                         </form>
                       </td>";
        } else {
            $userWrite .= "<td></td>";
        }
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
                
                    <h2>Profile</h2>
                    <a href='$HOME_PAGE'>HOME</a>
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

    public static function writeSignedUserProfile(User $user): void
    {
        $HOME_PAGE = HOME_PAGE;
        $UPDATE_USER_PAGE = UPDATE_USER_PAGE;
        $userWrite = $user;
        $userWrite .= "<td>
                         <form action='$UPDATE_USER_PAGE' method='post'>
                           <input type='submit' value='update'>
                         </form>
                       </td>";

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
                
                    <h2>Profile</h2>
                    <a href='$HOME_PAGE'>HOME</a>
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

    public static function writeProfileButton(): void
    {
        echo "<h2><a href='" . PROFILE_PAGE . "'>Your profile</a></h2>";
    }
}