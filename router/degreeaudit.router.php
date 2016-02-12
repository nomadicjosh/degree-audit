<?php
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');

/**
 * Helpdesk Plugin Router
 *  
 * @license GPLv3
 * 
 * @author  Joshua Parker <joshmac3@icloud.com>
 */
    

$view = new \app\plugins\degreeaudit\classes\View();
    
$app->group('/', function () use($app, $view) {

    $app->get('/', function () use($view) {

        $view->display('', [
            'title' => 'Degree Audit'
            ]
        );
    });
});

$app->setError(function() use($app) {

    $app->view->display('error/404', ['title' => '404 Error']);
});
