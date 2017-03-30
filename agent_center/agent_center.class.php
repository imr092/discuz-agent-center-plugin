<?php
defined('IN_DISCUZ') || exit('Access Denied');

/**
 * 代理中心插件
 *
 * Created by PhpStorm.
 * User: balabalaxiaomoxian
 * Date: 2017/3/18
 * Time: 下午3:16
 */
class plugin_agent_center
{
    function plugin_agent_center()
    {
        // 处理全局邀请码，如果链接有带邀请码则写入cookie，过期时间24小时
        if (isset($_GET['agent_invite']) && !is_null($_GET['agent_invite']) && !empty($_GET['agent_invite'])) {
            $agentInviteCode = $_GET['agent_invite'];
            // 检查数据库确认邀请码是否有效
            $result = C::t('#agent_center#agent_center_codes')->fetch_by_code($agentInviteCode);
            if (!empty($result)) {
                dsetcookie('agent_invite', $agentInviteCode, 86400);
            }
        }
    }

    /**
     * 在页面顶部登陆信息处根据用户组判断用户是否可以访问代理中心
     * 如果用户可以访问则显示相应链接
     *
     * @return string
     */
    public function global_usernav_extra4()
    {
        global $_G;
        if (!C::t('#agent_center#agent_center_agents')->is_agent($_G['uid'])) {
            return '';
        }
        return '<span class="pipe">|</span><a href="home.php?mod=spacecp&ac=plugin&id=agent_center:teamcp">代理中心</a> <span class="pipe">|</span>';
    }
}

class plugin_agent_center_member extends plugin_agent_center
{
    /**
     * 代理中心
     * 注册完成时绑定邀请关系
     *
     * @return null
     */
    function register_bind_invite_output()
    {
        global $_G;
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || empty($_POST) || !$_G['uid'] || !isset($_G['cookie']['agent_invite']) || empty($_G['cookie']['agent_invite'])) {
            return;
        }

        // 检查邀请码，如果有问题则清理该邀请码
        $agentInviteCode = $_G['cookie']['agent_invite'];
        $result = C::t('#agent_center#agent_center_codes')->fetch_by_code($agentInviteCode);
        if (empty($result)) {
            dsetcookie('agent_invite');
            return;
        }
        $agentId = $result['uid'];
        $userId = $_G['uid'];
        $inviteId = $result['id'];

        // 检查邀请关系是否已存在, 如已存在则不处理
        if (!empty(C::t('#agent_center#agent_center_map')->fetch_agent_id_custom_id($agentId, $userId))) {
            return;
        }

        // 创建邀请关系
        C::t('#agent_center#agent_center_map')->insert(array(
            'agent_id' => $agentId,
            'custom_id' => $userId,
            'invite_code_id' => $inviteId,
            'created_at' => time()
        ));

        return;
    }
}

