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
    /* === Storage System === */
    $this->get('/getLatestDisaster', '\App\Controller\API\DisastersController:getLatestDisaster')->setName('get_latest_disaster');
    $this->get('/getLatestResponseRecord', '\App\Controller\API\ResponseRecordsController:getLatestResponseRecord')->setName('get_latest_record');
    $this->get('/getLatestPreventionPlan', '\App\Controller\API\PreventionPlansController:getLatestPreventionPlan')->setName('get_latest_plan');
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
    $this->post('/deleteTempFile', '\App\Controller\API\FilesController:deleteTempFile')->setName('delete_temp_file');
    // Geo Control
    $this->get('/getArea', '\App\Controller\API\GeoController:getArea')->setName('get_area');
    $this->get('/getPrefecture', '\App\Controller\API\GeoController:getPrefecture')->setName('get_prefecture');
    $this->get('/getCity', '\App\Controller\API\GeoController:getCity')->setName('get_city');
    $this->get('/getGeoJson', '\App\Controller\API\GeoController:getGeoJson')->setName('get_geo_json');
    $this->post('/postCity', '\App\Controller\API\GeoController:postCity')->setName('post_city');
    // Classification Management System
    $this->get('/getClassifications', 'App\Controller\API\SettingsController:getClassifications')->setName('get_classifications');
    $this->post('/postClassification', 'App\Controller\API\SettingsController:postClassification')->setName('post_classifications');
    $this->post('/updateClassification', 'App\Controller\API\SettingsController:updateClassification')->setName('update_classifications');
    $this->post('/deleteClassification', 'App\Controller\API\SettingsController:deleteClassification')->setName('delete_classifications');
    // Scale Management System
    $this->get('/getScales', 'App\Controller\API\SettingsController:getScales')->setName('get_scales');
    $this->post('/postScale', 'App\Controller\API\SettingsController:postScale')->setName('post_scales');
    $this->post('/updateScale', 'App\Controller\API\SettingsController:updateScale')->setName('update_scales');
    $this->post('/deleteScale', 'App\Controller\API\SettingsController:deleteScale')->setName('delete_scales');
    // Section Management System
    $this->get('/getSections', 'App\Controller\API\SettingsController:getSections')->setName('get_sections');
    $this->post('/postSection', 'App\Controller\API\SettingsController:postSection')->setName('post_section');
    $this->post('/updateSection', 'App\Controller\API\SettingsController:updateSection')->setName('update_section');
    $this->post('/deleteSection', 'App\Controller\API\SettingsController:deleteSection')->setName('delete_section');
    // Status Management System
    $this->get('/getStatus', 'App\Controller\API\SettingsController:getStatus')->setName('get_status');
    $this->post('/postStatus', 'App\Controller\API\SettingsController:postStatus')->setName('post_status');
    $this->post('/updateStatus', 'App\Controller\API\SettingsController:updateStatus')->setName('update_status');
    $this->post('/deleteStatus', 'App\Controller\API\SettingsController:deleteStatus')->setName('delete_status');
    // Division Management System
    $this->get('/getDivisions', 'App\Controller\API\SettingsController:getDivisions')->setName('get_divisions');
    $this->post('/postDivision', 'App\Controller\API\SettingsController:postDivision')->setName('post_division');
    $this->post('/updateDivision', 'App\Controller\API\SettingsController:updateDivision')->setName('update_division');
    $this->post('/deleteDivision', 'App\Controller\API\SettingsController:deleteDivision')->setName('delete_division');
    // Auth Control
    /* === Visualization System === */
})->add($corsMw);
