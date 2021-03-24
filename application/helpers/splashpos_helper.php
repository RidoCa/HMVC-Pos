<?php
defined('BASEPATH') or exit('No direct script access allowed');

//fungsi tanggal datatbase
if (!function_exists('tglDB')) {
    function tglDB($date)
    {
        $day     = substr($date, 3, 2);
        $month   = substr($date, 0, 2);
        $year    = substr($date, 6, 4);
        return $year . '-' . $month . '-' . $day;
    }
}

//fungsi check value used
if (!function_exists('is_used')) {
    function is_used($table, $field, $value)
    {
        $ci = get_instance();

        $ci->db->select('*');
        $ci->db->from($table);
        $ci->db->where($field, $value);
        $query = $ci->db->get();

        return $query;
    }
}

//fungsi tanggal datatbase
if (!function_exists('dateAuto')) {
    function dateAuto($date)
    {
        $substr     = substr($date, 2);

        return $substr;
    }
}