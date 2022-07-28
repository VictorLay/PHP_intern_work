<?php

namespace app\users\views\html;


use app\users\entities\User;

class HomeHtml extends DeleteHtml
{

    public static function writeHomePage(User $user = null): void
    {
        $createNewCourseUrl = SHOW_USER_COURSES . CREATE_URN;
        $showUserCourses = SHOW_USER_COURSES;
        $showAllCourses = SHOW_ALL_COURSES;
        $searchCourses = SEARCH_COURSES;

        $LOGOUT_PAGE = LOGOUT_PAGE;
        $LOGIN_PAGE = LOGIN_PAGE;
        $SHOW_ALL_USERS_PAGE = SHOW_ALL_USERS_PAGE;
        $showUserLink = "";
        $showProfileLink = "";
        $showUserCreateLink = "";
        $createNewCourseLink = "";
        $showUserCoursesLink = "";
        $showAllCoursesLink = "";
        $searchCoursesLink = "";
        $recoverCoursesLink = "";
        if (is_null($user)) {
            $authenticationNotice = "<a class= 'btn btn-lg btn-light ' href= '$LOGIN_PAGE'>Login</a>";
        } else {
            $showMyProfilePage = $SHOW_ALL_USERS_PAGE . "/{$user->getId()}";
            $showCreatePage = CREATE_USER_PAGE;

            $authenticationNotice = "<a class= 'btn btn-lg btn-light ' href= '$LOGOUT_PAGE'>logout</a>";
            $showUserLink = "<li class= 'nav-item '><a class= 'nav-link ' href= '$SHOW_ALL_USERS_PAGE'>Show users</a></li>";
            $showProfileLink = "<a class= 'navbar-brand ' href= '$showMyProfilePage'>My profile</a>";
            $createNewCourseLink = "<a class= 'navbar-brand ' href= '$createNewCourseUrl'>Create course</a>";
            $showUserCoursesLink = "<a class= 'navbar-brand ' href= '$showUserCourses'>My courses</a>";
            $showAllCoursesLink = "<a class= 'navbar-brand ' href= '$showAllCourses'>All courses</a>";
            $searchCoursesLink = "<a class= 'navbar-brand ' href= '$searchCourses'>Search courses</a>";
            $recoverCoursesLink = "<a class= 'navbar-brand ' href= '/courses/recover'>My deleted courses</a>";
            if ($user->getRole() == ADMIN) {
                $showUserCreateLink = "<li class= 'nav-item '><a class= 'nav-link ' href= '$showCreatePage'>Add new user</a></li>";
            }

        }
        echo "
        <head>
            <meta charset= 'utf-8 ' />
            <meta name= 'viewport ' content= 'width=device-width, initial-scale=1, shrink-to-fit=no ' />
            <meta name= 'description ' content= ' ' />
            <meta name= 'author ' content= ' ' />
            <title>Scrolling Nav - Start Bootstrap Template</title>
            <link rel= 'icon ' type= 'image/x-icon ' href= 'users/assets/favicon.ico ' />
            <!-- Core theme CSS (includes Bootstrap)-->
            <link href= 'users/css/styles.css ' rel= 'stylesheet ' />
            <link rel= 'stylesheet ' href= 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css ' integrity= 'sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm ' crossorigin= 'anonymous '>
            <script src= 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js ' integrity= 'sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl ' crossorigin= 'anonymous '></script>
            <script src= 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js '></script>
            <script src= 'users/js/scripts.js '></script>
        </head>
        <body id= 'page-top '>
            <!-- Navigation-->
            <nav class= 'navbar navbar-expand-lg navbar-dark bg-dark fixed-top ' id= 'mainNav '>
                <div class= 'container px-4 '>
                    $showProfileLink
        <button class= 'navbar-toggler ' type= 'button ' data-bs-toggle= 'collapse ' data-bs-target= '#navbarResponsive ' aria-controls= 'navbarResponsive ' aria-expanded= 'false ' aria-label= 'Toggle navigation '><span class= 'navbar-toggler-icon '></span></button>
                    <div class= 'collapse navbar-collapse ' id= 'navbarResponsive '>
                        <ul class= 'navbar-nav ms-auto '>
                            $showUserLink
                            $showUserCreateLink
                            $createNewCourseLink
                            $showUserCoursesLink
                            $showAllCoursesLink 
                            $searchCoursesLink
                            $recoverCoursesLink
                        </ul>
                    </div>
                </div>
            </nav>
            <br><br>
            <!-- Header-->
            <header class= 'bg-primary bg-gradient text-white '>
                <div class= 'container px-4 text-center '>
                    <h1 class= 'fw-bolder '>Welcome to VicLay</h1>
                    <p class= 'lead '>A functional Bootstrap 5 boilerplate for one page scrolling websites</p>
                    $authenticationNotice
                </div>
            </header>
        </body>";

    }
}