<?php
/**
 * Created by PhpStorm.
 * User: balabalaxiaomoxian
 * Date: 2017/3/19
 * Time: 下午8:03
 */
if (!empty($_POST)) {
    $username = $_POST['username'];
    $uid = C::t('common_member')->fetch_uid_by_username($username);

    if (!$uid) {
        echo '<script>alert("对不起，没有这个用户！");window.location.href="admin.php?action=plugins&operation=config&do='.$_GET['do'].'&identifier=agent_center&pmod=admincp_add"</script>';
        exit;
    }

    // 检查用户是否已经为代理
    if (C::t('#agent_center#agent_center_agents')->is_agent($uid)) {
        echo '<script>alert("该用户已经是代理了！");window.location.href="admin.php?action=plugins&operation=config&do='.$_GET['do'].'&identifier=agent_center&pmod=admincp_add"</script>';
        exit;
    }

    // 插入数据到agents表
    C::t('#agent_center#agent_center_agents')->insert(array(
        'uid' => $uid,
    ));

    echo '<script>alert("代理创建成功！");window.location.href="admin.php?action=plugins&operation=config&do='.$_GET['do'].'&identifier=agent_center&pmod=admincp_add"</script>';
    exit;
}

$do = $_GET['do'];
?>
<br />
<form method="post">
    账号：<input name="username" value="" /> <input type="submit">
</form>
