<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS cdb_agent_center_agents;

DROP TABLE IF EXISTS cdb_agent_center_codes;

DROP TABLE IF EXISTS cdb_agent_center_map;

EOF;

runquery($sql);

$finish = TRUE;