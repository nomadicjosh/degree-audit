<?php
if (! defined('BASE_PATH'))
    exit('No direct script access allowed');
    
function prog_crse_save($data)
{
    $app = \Liten\Liten::getInstance();
    if (count($data)) {
        $q = $app->db->prog_crse();
        $q->progCode = $data['progCode'];
        $q->crseCode = $data['crseCode'];
        $q->sort = $data['sort'];
        $q->save();

        if ($q->lastInsertId()) {
            return $q->lastInsertId();
        }
        return 0;
    } else {
        return 0;
    }
}

function delete_prog_crse_record($id)
{
    if ($id > 0) {
        $app = \Liten\Liten::getInstance();
        $rem = $app->db->prog_crse()->where('ID = ?', $id)->limit(1)->delete();
        return count($rem);
    }
    return false;
}

function update_prog_crse_record($data)
{
    $app = \Liten\Liten::getInstance();
    if (count($data)) {
        $id = $data['rid'];
        unset($data['rid']);
        $values = implode("','", array_values($data));
        $str = "";
        foreach ($data as $key => $val) {
            $str .= $key . "='" . $val . "',";
        }
        $str = substr($str, 0, -1);
        $sql = $app->db->query("UPDATE prog_crse SET $str WHERE ID = ? LIMIT 1", [$id]);

        if ($sql->update()) {
            return $id;
        }
        return 0;
    } else {
        return 0;
    }
}

function update_prog_crse_column($data)
{
    $app = \Liten\Liten::getInstance();
    if (count($data)) {
        $id = $data['rid'];
        unset($data['rid']);
        $sql = $app->db->query("UPDATE prog_crse SET " . key($data) . "='" . $data[key($data)] . "' WHERE ID = ? LIMIT 1", [$id]);
        if ($sql->update()) {
            return $id;
        }
        return 0;
    }
}

function prog_crse_error($act)
{
    return json_encode(array("success" => "0", "action" => $act));
}

function program_courses_field($prog)
{
    $field = '<div class="form-group">';
    $field .= '<label class="col-md-3 control-label">' . _t('Courses') . ' <a href="' . url('/') . 'program/' . _h($prog[0]['acadProgID']) . '/crse/"><img src="' . url('/') . 'static/common/theme/images/cascade.png" /></a></label>';
    $field .= '<div class="col-md-1">';
    $field .= '<input class="form-control" type="text" disabled value="X" class="center" />';
    $field .= '</div>';
    $field .= '</div>';
    echo $field;
}
add_action('left_prog_view_form', 'program_courses_field', 1);