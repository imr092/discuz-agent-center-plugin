<?php defined('IN_DISCUZ') || exit('Access Denied');

/**
 * 代理中心插件
 * 管理后台
 *
 * Created by PhpStorm.
 * User: balabalaxiaomoxian
 * Date: 2017/3/18
 * Time: 下午3:16
 */
if(!isset($_GET['agent_id'])) {
    // 获取所有代理
    $all_agents = C::t('#agent_center#agent_center_agents')->fetch_all_agents();

    $all_uids = array();
    // 遍历数据
    foreach ($all_agents as $key => $agent) {
        $agent_id = $agent['uid'];
        $all_uids[] = $agent_id;

        // 获取下级用户数
        $all_agents[$key]['custom_count'] = C::t('#agent_center#agent_center_map')->fetch_custon_count($agent_id);
    }

    // 获取所有代理的个人资料
    $all_user_infos = C::t('common_member')->fetch_all($all_uids);

    // 获取所有代理的注册登陆状态
    $all_user_ips = C::t('common_member_status')->fetch_all($all_uids);

    $do = $_GET['do'];

    include template('agent_center:admincp_agent_list');
} else {
    // 获取代理id
    $agent_id = $_GET['agent_id'];

    // 获取代理的资料
    $agent = C::t('common_member')->fetch($agent_id);

    // 校验id
    if (!C::t('#agent_center#agent_center_agents')->is_agent($agent_id)) {
        echo '这个用户还不是代理噢';
        exit;
    }

    // 获取下级客户
    $all_customs = C::t('#agent_center#agent_center_map')->fetch_all_by_agent_id($agent_id);
    $all_custom_ids = array();
    foreach($all_customs as $key => $custom) {
        $all_custom_ids[] = $custom['custom_id'];

        // 获取发帖量
        // 获取主题数
        $all_customs[$key]['thread_count'] = C::t('forum_thread')->count_by_authorid($custom_id);
        $all_customs[$key]['post_count'] = C::t('forum_post')->count_by_authorid(0, $custom_id) - $all_customs[$key]['thread_count'];
    }

    // 获取用户昵称
    // 获取注册时间
    $all_user_infos = C::t('common_member')->fetch_all($all_custom_ids);

    // 获取注册ip
    $all_user_ips = C::t('common_member_status')->fetch_all($all_custom_ids);

    include template('agent_center:admincp_agent_custom');
}