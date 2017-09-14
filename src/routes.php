<?php
/**
 * Routing Define File
 * ルーティング
 */

use App\Middleware\AuthMiddleware;
use App\Middleware\PathMiddleware;
use App\Middleware\CorsMiddleware;

// Middleware
$authMw = AuthMiddleware::getInstance();
$authMw->init($app->getContainer());

$pathMw = PathMiddleware::getInstance();
$pathMw->init($app->getContainer());

$corsMw = CorsMiddleware::getInstance();
$corsMw->init($app->getContainer());

// Application Middleware
$app->add($pathMw);

// public path
// FIXME: グローバル変数で public_pathを求める方法があれば即座にそちらへ変更する
$app->any(__DIR__ . '/../public/', function(){})->setName('public_path');

// Login Process
$app->get('/', '\App\Controller\AuthController:getLogin')->setName('root');
$app->post('/login', '\App\Controller\AuthController:postLogin')->setName('login');
$app->post('/logout', '\App\Controller\AuthController:postLogout')->setName('logout');

// Top
$app->get('/top', '\App\Controller\TopController:index')
    ->setName('top')->add($authMw);

// Disaster Management
$app->group('/disasters', function(){
    // Disaster Management System
    $this->get('', '\App\Controller\DisastersController:index')->setName('disaster_index');
    // Select Disaster's list
    $this->get('/selects', '\App\Controller\DisastersController:select')->setName('disaster_select');
    $this->get('/create', '\App\Controller\DisastersController:create')->setName('disaster_create');
    $this->post('', '\App\Controller\DisastersController:store')->setName('disaster_store');
    $this->group('/{disasterId}', function(){
        $this->get('', '\App\Controller\DisastersController:show')->setName('disaster_show');
        $this->get('/edit', '\App\Controller\DisastersController:edit')->setName('disaster_edit');
        $this->map(['PATCH', 'PUT'], '', '\App\Controller\DisastersController:update')->setName('disaster_update');
        $this->delete('', '\App\Controller\DisastersController:delete')->setName('disaster_delete');

        // Disaster DisasterCorrespond Management System
        $this->group('/corresponds', function(){
            $this->get('', '\App\Controller\DisasterCorrespondsController:index')->setName('correspond_index');
            $this->get('/create', '\App\Controller\DisasterCorrespondsController:create')->setName('correspond_create');
            $this->post('', '\App\Controller\DisasterCorrespondsController:store')->setName('correspond_store');

            $this->group('/{correspondId}', function() {
                $this->get('', '\App\Controller\DisasterCorrespondsController:show')->setName('correspond_show');
                $this->get('/edit', '\App\Controller\DisasterCorrespondsController:edit')->setName('correspond_edit');
                $this->map(['PATCH', 'PUT'], '', '\App\Controller\DisasterCorrespondsController:update')->setName('correspond_update');
                $this->delete('', '\App\Controller\DisasterCorrespondsController:delete')->setName('correspond_delete');
            });
        });
    });
})->add($authMw);

// Disaster Prevention PreventionPlan Management System
$app->group('/plans', function(){
    $this->get('', '\App\Controller\PreventionPlansController:index')->setName('plan_index');
    $this->get('/create', '\App\Controller\PreventionPlansController:create')->setName('plan_create');
    $this->post('', '\App\Controller\PreventionPlansController:store')->setName('plan_store');
    $this->group('/{planId}', function(){
        $this->get('', '\App\Controller\PreventionPlansController:show')->setName('plan_show');
        $this->get('/edit', '\App\Controller\PreventionPlansController:edit')->setName('plan_edit');
        $this->map(['PATCH', 'PUT'], '', '\App\Controller\PreventionPlansController:update')->setName('plan_update');
        $this->delete('', '\App\Controller\PreventionPlansController:delete')->setName('plan_delete');
    });
})->add($authMw);

// TodoList Management System
$app->group('/lists', function(){
    $this->get('', '\App\Controller\TodoListsController:index')->setName('list_index');
    $this->get('/create', '\App\Controller\TodoListsController:create')->setName('list_create');
    $this->post('', '\App\Controller\TodoListsController:store')->setName('list_store');
    $this->group('/{listId}', function(){
        $this->get('', '\App\Controller\TodoListsController:show')->setName('list_show');
        $this->get('/edit', '\App\Controller\TodoListsController:edit')->setName('list_edit');
        $this->map(['PATCH', 'PUT'], '', '\App\Controller\TodoListsController:update')->setName('list_update');
        $this->delete('', '\App\Controller\TodoListsController:delete')->setName('list_delete');
    });
})->add($authMw);

// User Management System
$app->group('/users', function(){
    $this->get('', '\App\Controller\UsersController:index')->setName('user_index');
    $this->get('/create', '\App\Controller\UsersController:create')->setName('user_create');
    $this->post('', '\App\Controller\UsersController:store')->setName('user_store');
    $this->group('/{userId}', function(){
        $this->get('', '\App\Controller\UsersController:show')->setName('user_show');
        $this->get('/edit', '\App\Controller\UsersController:edit')->setName('user_edit');
        $this->map(['PATCH', 'PUT'], '', '\App\Controller\UsersController:update')->setName('user_update');
        $this->delete('', '\App\Controller\UsersController:delete')->setName('user_delete');
    });
})->add($authMw);

/* Web API */
$app->get('/getDisaster', '\App\Controller\JsonController:getDisaster')->setName('get_disaster')->add($corsMw);
$app->get('/getDisasters', '\App\Controller\JsonController:getDisasters')->setName('get_disasters')->add($corsMw);
$app->get('/getPlan', '\App\Controller\JsonController:getPlans')->setName('get_plan')->add($corsMw);
$app->get('/getPlans', '\App\Controller\JsonController:getPlans')->setName('get_plans')->add($corsMw);
$app->get('/getList', '\App\Controller\JsonController:getLists')->setName('get_list')->add($corsMw);
$app->get('/getLists', '\App\Controller\JsonController:getLists')->setName('get_lists')->add($corsMw);
$app->get('/getUsers', '\App\Controller\JsonController:getUsers')->setName('get_users')->add($corsMw);
