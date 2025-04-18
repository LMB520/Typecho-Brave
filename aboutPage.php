<?php
/**
 * 关于我们
 * @package custom
 * Author: ace
 * CreateTime: 2022/02/10
 * about page
 */
$this->need('base/head.php');
$this->need('base/nav.php');
$this->need('base/other.php');
?>
    <div class="list-content mx-auto mt-5">
        <div class="list-top">
            <h5 class="list-text">💕关于我们💕</h5>
        </div>
    </div>
    <div class="botui-app-container" id="botui"
         style="min-height:300px; padding:14px 6px 4px 6px; background-image:url(https://s2.loli.net/2022/02/10/htvkG9LmSJWK4CF.jpg); border-radius: 10px;">
        <h6 class="list-text" style="color:#F2F2F2;"><strong>与<?php $this->options->title() ?>对话中...</strong></h6>
        <bot-ui style="background:transparent;">
            <div style="text-align: center;">
                <h4 style="color:#F2F2F2;">Loading...</h4>
                <h5 style="color:#F2F2F2;padding-top:30px;">请刷新一次页面以使聊天机器人能正常显示</h5>
            </div>
            <bot-ui>
    </div>
    <script src="/usr/themes/Brave/botui/vue.min.js"></script>
    <script src="/usr/themes/Brave/botui/botui.min.js"></script>
    <script src="/usr/themes/Brave/botui/botui.js"></script>
<?php $this->need('base/foot.php');
?>