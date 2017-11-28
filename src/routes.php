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
//$app->any(__DIR__ . '/../public/', function(){})->setName('public_path');

// Login Process
$app->get('/', '\App\Controller\AuthController:getLogin')->setName('root');
$app->post('/login', '\App\Controller\AuthController:postLogin')->setName('login');
$app->post('/logout', '\App\Controller\AuthController:postLogout')->setName('logout');

// Top
$app->get('/top', '\App\Controller\TopController:index')
    ->setName('top')->add($authMw);

/* ===== Disaster System ===== */
// Disaster Management
$app->group('/disasters', function () {
    // Disaster Management System
    $this->get('', '\App\Controller\DisastersController:index')->setName('disaster_index');
    // Select Disaster's list
    $this->get('/selects', '\App\Controller\DisastersController:select')->setName('disaster_select');
    $this->get('/create', '\App\Controller\DisastersController:create')->setName('disaster_create');
    $this->post('', '\App\Controller\DisastersController:store')->setName('disaster_store');
    $this->group('/{disasterId}', function () {
        $this->get('', '\App\Controller\DisastersController:show')->setName('disaster_show');
        $this->get('/edit', '\App\Controller\DisastersController:edit')->setName('disaster_edit');
        $this->map(['PATCH', 'PUT'], '', '\App\Controller\DisastersController:update')->setName('disaster_update');
        $this->delete('', '\App\Controller\DisastersController:delete')->setName('disaster_delete');

        // Disaster DisasterCorrespond Management System
        $this->group('/corresponds', function () {
            $this->get('', '\App\Controller\DisasterCorrespondsController:index')->setName('correspond_index');
            $this->get('/create', '\App\Controller\DisasterCorrespondsController:create')->setName('correspond_create');
            $this->post('', '\App\Controller\DisasterCorrespondsController:store')->setName('correspond_store');

            $this->group('/{correspondId}', function () {
                $this->get('', '\App\Controller\DisasterCorrespondsController:show')->setName('correspond_show');
                $this->get('/edit', '\App\Controller\DisasterCorrespondsController:edit')->setName('correspond_edit');
                $this->map(['PATCH', 'PUT'], '', '\App\Controller\DisasterCorrespondsController:update')->setName('correspond_update');
                $this->delete('', '\App\Controller\DisasterCorrespondsController:delete')->setName('correspond_delete');
            });
        });
    });
})->add($authMw);

/* ===== Settings ===== */
// User Management System
$app->group('/users', function () {
    $this->get('', '\App\Controller\UsersController:index')->setName('user_index');
    $this->get('/create', '\App\Controller\UsersController:create')->setName('user_create');
    $this->post('', '\App\Controller\UsersController:store')->setName('user_store');
    $this->group('/{userId}', function () {
        $this->get('', '\App\Controller\UsersController:show')->setName('user_show');
        $this->get('/edit', '\App\Controller\UsersController:edit')->setName('user_edit');
        $this->map(['PATCH', 'PUT'], '', '\App\Controller\UsersController:update')->setName('user_update');
        $this->delete('', '\App\Controller\UsersController:delete')->setName('user_delete');
    });
})->add($authMw);

/* !===== Settings =====! */

/* ===== Web API ===== */
$app->group('/api', function () {
    // Disaster Management System
    $this->get('/getDisaster', '\App\Controller\API\DisastersController:getDisaster')->setName('get_disaster');
    $this->get('/getDisasters', '\App\Controller\API\DisastersController:getDisasters')->setName('get_disasters');
    $this->post('/postDisaster', '\App\Controller\API\DisastersController:postDisaster')->setName('post_disaster');
    // $this->map(['PATCH', 'PUT'], '/updateDisaster', '\App\Controller\API\DisastersController:updateDisaster')->setName('update_disaster');
    $this->post('/updateDisaster', '\App\Controller\API\DisastersController:updateDisaster')->setName('update_disaster');
    // $this->delete('/deleteDisaster', '\App\Controller\API\DisastersController:deleteDisaster')->setName('delete_disaster');
    $this->post('/deleteDisaster', '\App\Controller\API\DisastersController:deleteDisaster')->setName('delete_disaster');
    // Disaster Response Record Management System
    $this->get('/getResponseRecord', '\App\Controller\API\DisastersController:getResponseRecord')->setName('get_response_record');
    $this->get('/getResponseRecords', '\App\Controller\API\DisastersController:getResponseRecords')->setName('get_response_records');
    $this->post('/postResponseRecord', '\App\Controller\API\DisastersController:postResponseRecord')->setName('post_response_record');
    $this->post('/updateResponseRecord', '\App\Controller\API\DisastersController:updateResponseRecord')->setName('update_response_record');
    $this->post('/deleteResponseRecord', '\App\Controller\API\DisastersController:deleteResponseRecord')->setName('delete_response_record');
    // Prevention Plan Management System
    $this->get('/getPreventionPlan', '\App\Controller\API\DisastersController:getPreventionPlan')->setName('get_prevention_plan');
    $this->get('/getPreventionPlans', '\App\Controller\API\DisastersController:getPreventionPlans')->setName('get_prevention_plans');
    $this->post('/postPreventionPlan', '\App\Controller\API\DisastersController:postPreventionPlan')->setName('post_prevention_plan');
    $this->post('/updatePreventionPlan', '\App\Controller\API\DisastersController:updatePreventionPlan')->setName('update_prevention_plan');
    $this->post('/deletePreventionPlan', '\App\Controller\API\DisastersController:deletePreventionPlan')->setName('delete_prevention_plan');
    // User Management System
    // Area Management System
    // Social Media Management System
})->add($corsMw);
