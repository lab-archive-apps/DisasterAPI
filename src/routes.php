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

/* ===== Web API ===== */
$app->group('/api', function () {
    // Disaster Management System
    $this->get('/getDisaster', '\App\Controller\API\DisastersController:getDisaster')->setName('get_disaster');
    $this->get('/getDisasters', '\App\Controller\API\DisastersController:getDisasters')->setName('get_disasters');
    $this->post('/postDisaster', '\App\Controller\API\DisastersController:postDisaster')->setName('post_disaster');
    $this->post('/updateDisaster', '\App\Controller\API\DisastersController:updateDisaster')->setName('update_disaster');
    $this->post('/deleteDisaster', '\App\Controller\API\DisastersController:deleteDisaster')->setName('delete_disaster');
    // Disaster Response Record Management System
    $this->get('/getResponseRecord', '\App\Controller\API\ResponseRecordsController:getResponseRecord')->setName('get_response_record');
    $this->get('/getResponseRecords', '\App\Controller\API\ResponseRecordsController:getResponseRecords')->setName('get_response_records');
    $this->post('/postResponseRecord', '\App\Controller\API\ResponseRecordsController:postResponseRecord')->setName('post_response_record');
    $this->post('/updateResponseRecord', '\App\Controller\API\ResponseRecordsController:updateResponseRecord')->setName('update_response_record');
    $this->post('/deleteResponseRecord', '\App\Controller\API\ResponseRecordsController:deleteResponseRecord')->setName('delete_response_record');
    // Prevention Plan Management System
    $this->get('/getPreventionPlan', '\App\Controller\API\PreventionPlansController:getPreventionPlan')->setName('get_prevention_plan');
    $this->get('/getPreventionPlans', '\App\Controller\API\PreventionPlansController:getPreventionPlans')->setName('get_prevention_plans');
    $this->post('/postPreventionPlan', '\App\Controller\API\PreventionPlansController:postPreventionPlan')->setName('post_prevention_plan');
    $this->post('/updatePreventionPlan', '\App\Controller\API\PreventionPlansController:updatePreventionPlan')->setName('update_prevention_plan');
    $this->post('/deletePreventionPlan', '\App\Controller\API\PreventionPlansController:deletePreventionPlan')->setName('delete_prevention_plan');
    // User Management System
    $this->get('/getUser', '\App\Controller\API\UsersController:getUser')->setName('get_user');
    $this->get('/getUsers', '\App\Controller\API\UsersController:getUsers')->setName('get_users');
    $this->post('/postUser', '\App\Controller\API\UsersController:postUser')->setName('post_user');
    $this->post('/updateUser', '\App\Controller\API\UsersController:updateUser')->setName('update_user');
    $this->post('/deleteUser', '\App\Controller\API\UsersController:deleteUser')->setName('delete_user');
    // Social Media Management System
    // File System
    $this->post('/postFile', '\App\Controller\API\FilesController:postFile')->setName('post_file');
    $this->post('/postTempFile', '\App\Controller\API\FilesController:postTempFile')->setName('post_temp_file');
    $this->post('/deleteFile', '\App\Controller\API\FilesController:deleteFile')->setName('delete_file');
    $this->post('/deleteTempFile', '\App\Controller\API\FilesController:deleteTempFile')->setName('delete_file');
    // GeoJson
    $this->get('/geoJson', '\App\Controller\API\GeoJsonController:getGeoJson')->setName('get_geo_json');
    // Auth Control
})->add($corsMw);
