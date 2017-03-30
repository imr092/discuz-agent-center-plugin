<?php
/**
 * Created by PhpStorm.
 * User: balabalaxiaomoxian
 * Date: 2017/3/19
 * Time: 上午2:09
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_agent_center_codes extends discuz_table
{

    public function __construct() {

        $this->_table = 'agent_center_codes';
        $this->_pk    = 'id';

        parent::__construct();
    }

    public function fetch_by_code($code) {
        return DB::fetch_first("SELECT * FROM %t WHERE code=%s", array($this->_table, $code));
    }

    public function fetch_all_by_uid($uid) {
        return DB::fetch_all("SELECT * FROM %t WHERE uid=%d", array($this->_table, $uid));
    }
}