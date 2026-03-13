<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {


    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('companies', CompanyController::class);
    $router->resource('clients', ClientController::class);
    $router->resource('employees', EmployeesController::class);
    $router->resource('admin-roles', AdminRoleController::class);
    $router->resource('projects', ProjectController::class);
    $router->resource('project-sections', ProjectSectionController::class);
    $router->resource('daily-tasks', TaskController::class);
    $router->resource('weekly-tasks', TaskController::class);
    $router->resource('montly-tasks', TaskController::class);
    $router->resource('tasks', TaskController::class);
    $router->resource('events', EventController::class);
    $router->resource('focal-points', FocalPointsController::class);
    $router->get('/calendar', 'HomeController@calendar')->name('calendar');
    $router->resource('notifications', NotificationController::class); 


    $router->resource('cases', CaseModelController::class);
    $router->resource('countries', CountryController::class);
    $router->resource('discussion-board-posts', DiscussionBoardPostController::class);
    $router->resource('news-post-categories', NewsPostCategoryController::class);
    $router->resource('news-posts', NewsPostController::class);
    $router->resource('information-requests', InformationRequestController::class);
    $router->resource('offences', OffenceController::class);


    $router->resource('gens', GenController::class);
});
