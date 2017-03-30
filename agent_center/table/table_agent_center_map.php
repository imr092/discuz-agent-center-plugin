<?php
/**
 * Created by PhpStorm.
 * User: balabalaxiaomoxian
 * Date: 2017/3/19
 * Time: 上午2:09
 */

if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_agent_center_map extends discuz_table
{

    public function __construct()
    {

        $this->_table = 'agent_center_map';
        $this->_pk = 'id';

        parent::__construct();
    }

    public function fetch_all_by_agent_id($agent_id)
    {
        return DB::fetch_all("SELECT * FROM %t WHERE agent_id=%d", array($this->_table, $agent_id));
    }

    public function fetch_agent_id_custom_id($agent_id, $custom_id)
    {
        return DB::fetch_first("SELECT * FROM %t WHERE agent_id=%d AND custom_id=%d", array($this->_table, $agent_id, $custom_id));
    }

    public function fetch_custom_count_month($agent_id)
    {
        $first_of_this_month = strtotime(date("Y-m-01"));
        return DB::fetch_first("SELECT COUNT(0) AS ct FROM %t WHERE agent_id=%d AND created_at>=%d", array($this->_table, $agent_id, $first_of_this_month))['ct'];
    }

    public function fetch_custon_count($agent_id) {
        return DB::fetch_first("SELECT COUNT(0) AS ct FROM %t WHERE agent_id=%d", array($this->_table, $agent_id))['ct'];
    }
}