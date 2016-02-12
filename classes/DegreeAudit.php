<?php namespace app\plugins\degreeaudit\classes;
if (!defined('BASE_PATH'))
    exit('No direct script access allowed');

class DegreeAudit
{

    public function __construct()
    {
        
    }

    public function index_page()
    {
        include( PLUGINS_DIR . 'degreeaudit/templates/indexpage.php' );
    }
}
