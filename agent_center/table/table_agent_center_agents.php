<?php
/**
 * Created by PhpStorm.
 * User: balabalaxiaomoxian
 * Date: 2017/3/19
 * Time: 下午3:56
 */
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_agent_center_agents extends discuz_table
{

    public function __construct()
    {

        $this->_table = 'agent_center_agents';
        $this->_pk = 'id';

        parent::__construct();
    }

    public function is_agent($uid) {
        return ! empty(DB::fetch_first("SELECT * FROM %t WHERE uid=%d", array($this->_table, $uid)));
    }

    public function fetch_all_agents()
    {
        return DB::fetch_all("SELECT * FROM %t", array($this->_table));
    }
}