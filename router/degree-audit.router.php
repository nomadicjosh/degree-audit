<?php
if (! defined('BASE_PATH'))
    exit('No direct script access allowed');

/**
 * Degree Audit Plugin Router
 *
 * @license GPLv3
 *         
 * @author Joshua Parker <joshmac3@icloud.com>
 */

$view = new \app\plugins\degreeaudit\classes\View();

$app->group('/', function () use($app, $view) {
    
    $app->get('/', function () use($view) {
        
        $view->display('', [
            'title' => 'Degree Audit'
        ]);
    });
});

$app->match('GET', '/program/(\d+)/crse/', function ($id) use($app, $view, $css, $js, $logger, $dbcache, $flashNow) {
    
    $prog = $app->db->prog_crse()
        ->setTableAlias('a')
        ->select('a.*')
        ->_join('acad_program', 'a.progCode = b.acadProgCode', 'b')
        ->where('b.acadProgID = ?', $id)
        ->orderBy('a.sort');
    $q1 = $prog->find(function ($data) {
        $array = [];
        foreach ($data as $d) {
            $array[] = $d;
        }
        return $array;
    });
    
    $crse = $app->db->course()
        ->select('courseCode')
        ->where('currStatus = "A"')
        ->_and_()
        ->where('endDate <= "0000-00-00"');
    $q2 = $crse->find(function ($data) {
        $array = [];
        foreach ($data as $d) {
            $array[] = $d;
        }
        return $array;
    });
    
    $acad = $app->db->acad_program()
        ->where('acadProgID = ?', $id);
    $q3 = $acad->find(function ($data) {
        $array = [];
        foreach ($data as $d) {
            $array[] = $d;
        }
        return $array;
    });
    
    $app->view->display('program/crse', [
        'title' => 'Program Courses',
        'cssArray' => $css,
        'jsArray' => $js,
        'prog' => $q3,
        'acadProg' => $q1,
        'crse' => $q2
    ]);
});

$app->post('/program/prog-ajax/', function () {
    
    $action = $_POST['action'];
    unset($_POST['action']);
    
    if ($action == "save") {
        $escapedPost = $_POST;
        $escapedPost = array_map('htmlentities', $escapedPost);
        
        $res = prog_crse_save($escapedPost);
        
        if ($res) {
            $escapedPost["success"] = "1";
            $escapedPost["ID"] = $res;
            echo json_encode($escapedPost);
        } else
            echo prog_crse_error("save");
    } elseif ($action == "del") {
        $id = $_POST['rid'];
        $res = delete_prog_crse_record($id);
        if ($res) {
            echo json_encode(array(
                "success" => "1",
                "id" => $id
            ));
        } else {
            echo prog_crse_error("delete");
        }
    } elseif ($action == "update") {
        $escapedPost = $_POST;
        $escapedPost = array_map('htmlentities', $escapedPost);
        
        $id = update_prog_crse_record($escapedPost);
        if ($id) {
            echo json_encode(array_merge(array(
                "success" => "1",
                "id" => $id
            ), $escapedPost));
        } else {
            echo prog_crse_error("update");
        }
    } elseif ($action == "updatetd") {
        $escapedPost = $_POST;
        $escapedPost = array_map('htmlentities', $escapedPost);
        
        $id = update_prog_crse_column($escapedPost);
        if ($id) {
            echo json_encode(array_merge(array(
                "success" => "1",
                "id" => $id
            ), $escapedPost));
        } else {
            echo prog_crse_error("updatetd");
        }
    }
});

$app->setError(function () use($app) {
    
    $app->view->display('error/404', [
        'title' => '404 Error'
    ]);
});


