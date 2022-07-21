<?php

require_once "../config/routes.php";
require_once "../app/users/entities/AuthorizationInfo.php";
require_once "../app/core/entities/Entity.php";
require_once "../app/users/entities/User.php";

require_once "../app/core/utils/logger/Logger.php";
require_once "../app-resources/CustomConstants.php";
require_once "../app-resources/conf_const.php";
require_once "../app/core/utils/validator/UserValidator.php";

require_once "../app/core/routers/Router.php";
require_once "../app/core/routers/impl/RouterImpl.php";
require_once "../app/core/controllers/Controller.php";

require_once "../app/users/views/html/ErrorHtml.php";
require_once "../app/users/views/html/AuthenticationHtml.php";
require_once "../app/users/views/html/DeleteHtml.php";
require_once "../app/users/views/html/HomeHtml.php";
require_once "../app/users/views/html/ProfileHtml.php";
require_once "../app/users/views/html/ShowUsersHtml.php";
require_once "../app/users/views/HtmlPageWriter.php";

define("DB_PROPERTY", require "../config/database.php");
require_once "../app/core/models/Transaction.php";
require_once "../app/core/models/connection/ModelConnection.php";
require_once "../app/core/models/TransactionImpl.php";
require_once "../app/courses/models/CourseModel.php";
require_once "../app/users/models/UserModel.php";
require_once "../app/courses/models/impl/CourseModelImpl.php";
require_once "../app/users/models/impl/UserModelImpl.php";




require_once "../app/core/services/factory/ServiceFactory.php";
require_once "../app/core/models/factory/ModelsFactory.php";

require_once "../app/core/utils/Redirection.php";
require_once "../app/core/utils/permission/PermissionCtrl.php";
require_once "../app/core/controllers/impl/PageNotFoundController.php";
require_once "../app/users/controllers/impl/CreateAdminController.php";
require_once "../app/users/controllers/impl/CreatePageController.php";
require_once "../app/users/controllers/impl/DeleteUserByIdPageController.php";
require_once "../app/users/controllers/impl/HomePageController.php";
require_once "../app/users/controllers/impl/ProfilePageController.php";
require_once "../app/users/controllers/impl/ShowAllUsersPageController.php";
require_once "../app/users/controllers/impl/ShowUserProfileController.php";
require_once "../app/users/controllers/impl/SignInPageController.php";
require_once "../app/users/controllers/impl/SignOutPageController.php";
require_once "../app/users/controllers/impl/UpdateSignedUserPageController.php";
require_once "../app/users/controllers/impl/UserUpdatePageController.php";


require_once "../app/users/services/UserService.php";
require_once "../app/users/services/impl/UserServiceImpl.php";

require_once "../app/courses/services/CourseService.php";
require_once "../app/courses/services/impl/CourseServiceImpl.php";


require_once "../app/core/exceptions/ServiceException.php";
require_once "../app/core/exceptions/ModelException.php";