<?php
if (! defined('BASE_PATH'))
    exit('No direct script access allowed');
    
/*
 * Plugin Name: Degree Audit
 * Plugin URI: http://plugins.edutracsis.com/package/degree-audit/
 * Version: 1.0.0
 * Description: With the degree audit plugin, those who create and manage academic programs will also be able to create a degree audit so that faculty advisors can audit students for graduation. Students will also be able to run their own degree audit as well.
 * Author: Joshua Parker
 * Author URI: http://www.joshparker.name/
 * Plugin Slug: degree-audit
 */

$app = \Liten\Liten::getInstance();

include (ETSIS_PLUGIN_DIR . 'degree-audit/classes/DegreeAudit.php');
include (ETSIS_PLUGIN_DIR . 'degree-audit/classes/View.php');
include (ETSIS_PLUGIN_DIR . 'degree-audit/router/degree-audit.router.php');
load_plugin_textdomain('degree-audit', 'degree-audit/languages');

function degree_audit_tables()
{
    $app = \Liten\Liten::getInstance();
    $now = date('Y-m-d h:i:s');
    $hd = $app->db->query('SHOW TABLES LIKE "da_group"');
    $q = $hd->find(function($data) {
        $array = [];
        foreach ($data as $d) {
            $array[] = $d;
        }
        return $array;
    });
    
    if (count($q) <= 0) {
        $sql = [];
        
        $sql = "";
        
        foreach ($sql as $query) {
            $app->db->query($query);
        }
    }
}
register_activation_hook(__FILE__, 'degree_audit_tables');