<?php
defined('IN_DISCUZ') || exit('Access Denied');
/**
 * 代理中心前台页面
 * 所属模块：
 * 设置 -> 代理中心
 *
 * Created by PhpStorm.
 * User: balabalaxiaomoxian
 * Date: 2017/3/18
 * Time: 下午3:21
 */

global $_G;
if (!$_G['uid']) {
    return;
}

// 读取action，默认为页面展示
$action = isset($_GET['agent_action']) ? $_GET['agent_action'] : null;
if ($action == 'new') {
    createInviteCode();
    exit;
}

// 获取链接列表
$allUrl = getAgentUrls();

// 获取当月邀请用户数
$custom_count_month = C::t('#agent_center#agent_center_map')->fetch_custom_count_month($_G['uid']);

// 获取当前已邀请的所有用户ID
$custom_map = C::t('#agent_center#agent_center_map')->fetch_all_by_agent_id($_G['uid']);

// 获取用户数
$custom_count = count($custom_map);

// 获取回帖数
$post_count = 0;
// 获取主题数
$thread_count = 0;

// 遍历所有下级用户并读取各用户的回帖数及主题数
foreach ($custom_map as $custom) {
    $custom_id = $custom['custom_id'];
    $custom_thread_count = C::t('forum_thread')->count_by_authorid($custom_id);
    $custom_post_count = C::t('forum_post')->count_by_authorid(0, $custom_id) - $custom_thread_count;

    $post_count += $custom_post_count;
    $thread_count += $custom_thread_count;
}

// 获取用户所有链接列表
function getAgentUrls() {
    global $_G;
    $allUrl = array();
    $codes = C::t('#agent_center#agent_center_codes')->fetch_all_by_uid($_G['uid']);
    foreach ($codes as $code) {
        $allUrl[] = $_G[siteurl] . 'forum.php?agent_invite=' . $code['code'];
    }

    return $allUrl;
}

// 生成代理链接的接口
function createInviteCode() {
    $micro_time = (int) microtime(true) * 1000;
    $code = _10_2_62($micro_time);

    // 写入数据库
    global $_G;
    C::t('#agent_center#agent_center_codes')->insert(array(
        'uid' => $_G['uid'],
        'code' => $code,
        'name' => '新建',
        'summary' => '新建',
        'created_at' => time()
    ));
    return true;
}

// 代理信息展示页

function isAgent() {
    global $_G;
    return C::t('#agent_center#agent_center_agents')->is_agent($_G['uid']);
}

function _10_2_62($num)
{
    $to = 62;
    $dict = '01239abcdGHIJKtuvwxyLMNOefghijklABCDEF45678PQRSTUVWXYZmnopqrsz'; // 打乱顺序以防算法被猜出来
    $ret = '';
    do {
        $ret = $dict[bcmod($num, $to)] . $ret;
        $num = bcdiv($num, $to);
    } while ($num > 0);
    return $ret;
}