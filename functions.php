<?php

use Typecho\Widget\Helper\Form\Element\Checkbox;
use Typecho\Widget\Helper\Form\Element\Radio;
use Typecho\Widget\Helper\Form\Element\Select;
use Typecho\Widget\Helper\Form\Element\Text;
use Typecho\Widget\Helper\Form\Element\Textarea;

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
require_once("core/shortcodes.php");
require_once("core/App.php");
$db = Typecho_Db::get();
function themeInit()
{
    Helper::options()->commentsAntiSpam = false;
    //关闭反垃圾
    Helper::options()->commentsCheckReferer = false;
    //关闭检查评论来源URL与文章链接是否一致判断(否则会无法评论)
    Helper::options()->commentsMaxNestingLevels = '999';
    //最大嵌套层数
    Helper::options()->commentsPageDisplay = 'first';
    //强制评论第一页
    Helper::options()->commentsOrder = 'DESC';
    //将最新的评论展示在前
    Helper::options()->commentsHTMLTagAllowed = '<a href=""> <img src=""> <img src="" class=""> <code> <del>';
    Helper::options()->commentsMarkdown = true;
}

/**
 * 主题后台设置
 */
function themeConfig($form)
{
    $navsay = new Text('navsay', NULL, NULL, _t('导航栏右侧文字设置'), _t('直接书写文字即可，不建议过长。也可使用相关随机api'));
    $form->addInput($navsay);
    $heroimg = new Text('heroimg', NULL, NULL, _t('头部大图设置'), _t('在这里输入图片链接'));
    $form->addInput($heroimg);
    $background = new Text('background', NULL, NULL, _t('背景设置设置'), _t('在这里输入图片链接'));
    $form->addInput($background);
    $boy = new Text('boy', NULL, NULL, _t('男主头像设置'), _t('在这里输入头像链接'));
    $form->addInput($boy);
    $girl = new Text('girl', NULL, NULL, _t('女主头像设置'), _t('在这里输入头像链接'));
    $form->addInput($girl);
    $boyname = new Text('boyname', NULL, NULL, _t('男主昵称设置'), _t('在这里输入昵称'));
    $form->addInput($boyname);
    $girlname = new Text('girlname', NULL, NULL, _t('女主昵称设置'), _t('在这里输入昵称'));
    $form->addInput($girlname);
    $ICP = new Text('ICP', NULL, NULL, _t('ICP备案号'), _t('如果没有可以不填'));
    $form->addInput($ICP);
    $lovetimeSwitch = new Radio(
        'lovetimeSwitch',
        array(
            '1' => _t('显示'),
            '0' => _t('隐藏')
        ),
        '0', _t('恋爱计时器小组件开关⏰️'), _t('选择是否显示恋爱计时器')
    );
    $form->addInput($lovetimeSwitch);
    $lovetimeSwitch = Helper::options()->lovetimeSwitch;
    if ($lovetimeSwitch == '1') {
        $lovetitle = new Text('lovetitle', NULL, NULL, _t('标题设定'), _t('例如：我们风雨同舟已经一起走过'));
        $form->addInput($lovetitle);
        $lovetime = new Text('lovetime', NULL, NULL, _t('日期设定'), _t('格式“YYYY/MM/DD”，例“2023/07/11”'));
        $form->addInput($lovetime);
    }
    $countdownSwitch = new Radio(
        'countdownSwitch',
        array(
            '1' => _t('显示'),
            '0' => _t('隐藏')
        ),
        '0', _t('纪念日倒计时小组件开关⏳️'), _t('选择是否显示纪念日倒计时')
    );
    $form->addInput($countdownSwitch);
    $countdownSwitch = Helper::options()->countdownSwitch;
    if ($countdownSwitch == '1') {
        $countdowntitle = new Text('countdowntitle', NULL, NULL, _t('标题设定'), _t('例如：情人节'));
        $form->addInput($countdowntitle);
        $countdowntime = new Text('countdowntime', NULL, NULL, _t('日期设定'), _t('格式“YYYY/MM/DD”，例“2025/02/14”'));
        $form->addInput($countdowntime);
    }
    $lovetextSwitch = new Radio(
        'lovetextSwitch',
        array(
            '1' => _t('显示'),
            '0' => _t('隐藏')
        ),
        '0', _t('随机情话小组件开关💝'), _t('选择是否显示随机情话')
    );
    $form->addInput($lovetextSwitch);
    $lovetextSwitch = Helper::options()->lovetextSwitch;
    if ($lovetextSwitch == '1') {
        $lovetext = new Text('lovetext', NULL, NULL, _t('情话加载时的占位词'), _t('随便填，例如：Loading…、加载中…、喜欢你是我的秘密等等等之类的，或者也可以不填'));
        $form->addInput($lovetext);
    }
    $blessSwitch = new Radio(
        'blessSwitch',
        array(
            '1' => _t('显示'),
            '0' => _t('隐藏')
        ),
        '0', _t('首页祝福墙小组件开关💌'), _t('选择是否在首页显示祝福墙')
    );
    $form->addInput($blessSwitch);
    $blessSwitch = Helper::options()->blessSwitch;
    if ($blessSwitch == '1') {
        $blessPageIcon = new Text('blessPageIcon', NULL, NULL, _t('图标'), _t('在此输入图标直链，将显示在首页祝福墙小版块中'));
        $form->addInput($blessPageIcon);
        $blessPageLink = new Text('blessPageLink', NULL, NULL, _t('链接'), _t('在此输入祝福页面链接'));
        $form->addInput($blessPageLink);
        $ForbiddenWords = new Textarea('ForbiddenWords', NULL, NULL, _t('违禁词(以“,”相隔)'), _t('用于检测发送的祝福内容是否包含违禁词'));
        $form->addInput($ForbiddenWords);
        $quickget = new Textarea('quickget', NULL, NULL, _t('快速获取祝福者信息核心(JS代码)'), _t('用于游客发送祝福时，可以输入QQ号快速获取邮箱、头像等信息，不会请查看食用教程'));
        $form->addInput($quickget);
    }
    $timeSwitch = new Radio('timeSwitch',
        array(
            '1' => _t('显示'),
            '0' => _t('隐藏')
        ), '0', _t('首页点点滴滴小组件开关📖'), _t('选择是否在首页显示点点滴滴'));
    $form->addInput($timeSwitch);
    $timeSwitch = Helper::options()->timeSwitch;
    if ($timeSwitch == '1') {
        $timePageIcon = new Text('timePageIcon', NULL, NULL, _t('图标'), _t('在此输入图标直链，将显示在首页点点滴滴小版块中'));
        $form->addInput($timePageIcon);
        $timePageLink = new Text('timePageLink', NULL, NULL, _t('链接'), _t('在此输入点点滴滴页面链接，一般为：/blog'));
        $form->addInput($timePageLink);
    }
    $shuoshuoSwitch = new Radio('shuoshuoSwitch',
        array(
            '1' => _t('显示'),
            '0' => _t('隐藏')
        ), '0', _t('首页随笔说说小组件开关📝'), _t('选择是否显示随笔说说'));
    $form->addInput($shuoshuoSwitch);
    $shuoshuoSwitch = Helper::options()->shuoshuoSwitch;
    if ($shuoshuoSwitch == '1') {
        $shuoshuoPageIcon = new Text('shuoshuoPageIcon', NULL, NULL, _t('图标'), _t('在此输入图标直链，将显示在首页随笔说说小版块中'));
        $form->addInput($shuoshuoPageIcon);
        $shuoshuoPageLink = new Text('shuoshuoPageLink', NULL, NULL, _t('链接'), _t('在此输入随笔说说页面链接'));
        $form->addInput($shuoshuoPageLink);
    }
    $aboutSwitch = new Radio('aboutSwitch',
        array(
            '1' => _t('显示'),
            '0' => _t('隐藏')
        ), '0', _t('首页关于我们小组件开关💖'), _t('选择是否显示关于我们'));
    $form->addInput($aboutSwitch);
    $aboutSwitch = Helper::options()->aboutSwitch;
    if ($aboutSwitch == '1') {
        $aboutPageIcon = new Text('aboutPageIcon', NULL, NULL, _t('图标'), _t('在此输入图标直链，将显示在首页关于小版块中'));
        $form->addInput($aboutPageIcon);
        $aboutPageLink = new Text('aboutPageLink', NULL, NULL, _t('链接'), _t('在此输入关于我们链接'));
        $form->addInput($aboutPageLink);
    }
    $lovelistSwitch = new Radio('lovelistSwitch',
        array(
            '1' => _t('显示'),
            '0' => _t('隐藏')
        ), '0', _t('首页恋爱清单小组件开关📋'), _t('选择是否显示恋爱清单'));
    $form->addInput($lovelistSwitch);
    $lovelistSwitch = Helper::options()->lovelistSwitch;
    if ($lovelistSwitch == '1') {
        $lovelistPageIcon = new
        Text('lovelistPageIcon', NULL, NULL, _t('图标'), _t('在此输入图标直链，将显示在首页恋爱清单小版块中'));
        $form->addInput($lovelistPageIcon);
        $lovelistPageLink = new Text('lovelistPageLink', NULL, NULL, _t('链接'), _t('在此输入恋爱清单页面链接'));
        $form->addInput($lovelistPageLink);
    }
    $photoSwitch = new Radio('photoSwitch',
        array(
            '1' => _t('显示'),
            '0' => _t('隐藏')
        ), '0', _t('首页相册小组件开关📷'), _t('选择是否显示相册'));
    $form->addInput($photoSwitch);
    $photoSwitch = Helper::options()->photoSwitch;
    if ($photoSwitch == '1') {
        $photoPageIcon = new Text('photoPageIcon', NULL, NULL, _t('图标'), _t('在此输入图标直链，将显示在首页相册小版块中'));
        $form->addInput($photoPageIcon);
        $photoPageLink = new Text('photoPageLink', NULL, NULL, _t('链接'), _t('在此输入相册页面链接'));
        $form->addInput($photoPageLink);
        $photoPageJsDelivr = new Text('photoPageJsDelivr', NULL, NULL, _t('JsDelivr源'), _t('在此输入相册页面中的JsDelivr源，并且请加上http(s)://和/，不会请查看食用教程'));
        $form->addInput($photoPageJsDelivr);
    }
    $announce‌Switch = new Radio(
        'announce‌Switch',
        array(
            '1' => _t('显示'),
            '0' => _t('隐藏')
        ),
        '0', _t('公告开关'), _t('选择是否显示公告')
    );
    $form->addInput($announce‌Switch);
    $announce‌Switch = Helper::options()->announce‌Switch;
    if ($announce‌Switch == '1') {
        $announce‌title = new Text('announce‌ttitle', NULL, NULL, _t('标题设定'), _t('例如：公告'));
        $form->addInput($announce‌title);
        $announce‌content = new Textarea('announce‌content', NULL, NULL, _t('内容设定'), _t('在此填写公告内容，支持HTML'));
        $form->addInput($announce‌content);
    }
    $Vaptcha = new Radio('Vaptcha',
        array(
            '1' => _t('启用'),
            '0' => _t('关闭')
        ), '0', _t('Vaptcha人机验证开关'), _t('远离人机留言，人机快滚开o(￣ヘ￣o#)。<br>启用后提交所有评论时都会进行人机验证，以防止人机刷评论，具体配置请查看食用教程'));
    $form->addInput($Vaptcha);
    $pjaxSwitch = new Radio('pjaxSwitch',
        array(
            '1' => _t('启用'),
            '0' => _t('关闭')
        ), '0', _t('pjax无刷新开关'), _t('选择是否启用pjax无刷新'));
    $form->addInput($pjaxSwitch);
    $pjaxSwitch = Helper::options()->pjaxSwitch;
    if ($pjaxSwitch == '1') {
        $pjaxContent = new Textarea('pjaxContent', NULL, NULL, _t('pjax回调函数'), _t('在这里可以书写回调函数内容。如果你不知道这项如何使用请忽略'));
        $form->addInput($pjaxContent);
    }
    $Specialeffects = new Checkbox(
        'Specialeffects',
        [
            'xiaxue' => _t('下雪特效❄'),
            'yinghua' => _t('樱花特效🌸'),
            'denglong' => _t('灯笼特效🏮'),
            'yuqun' => _t('底部鱼群特效🐳'),
            'dazi' => _t('底部打字特效📠'),
            'dianji' => _t('点击爱心特效🖱'),
        ],
        [], _t('需要显示的特效'), _t('选择你喜欢的特效在全局显示〃•ω‹〃')
    );
    $form->addInput($Specialeffects->multiMode());
    $CustomizeHead = new Textarea('CustomizeHead', NULL, NULL, _t('头部自定义内容'), _t('位于头部，head内，适合放置一些链接引用或自定义内容'));
    $form->addInput($CustomizeHead);
    $stylemyself = new Textarea('stylemyself', NULL, NULL, _t('自定义样式'), _t('已包含&lt;style&gt;标签，请直接书写样式'));
    $form->addInput($stylemyself);
    $CustomizeFoot = new Textarea('CustomizeFoot', NULL, NULL, _t('底部自定义内容'), _t('位于底部，footer之后body之前，适合放置一些js或自定义内容，如网站统计代码等'));
    $form->addInput($CustomizeFoot);
    echo '
    <style>
        .tips {
            border: 1px solid #00BF63;
            text-align: center;
            border-radius: 10px;
            background-color: #f0f8f0;
        }
        hr {
            border: 1px dashed #00BF63;
            width: 90%;
            margin: 10px auto;
        }
        .tips a {
            color: #00BF63;
            text-decoration: none;
        }
        .tips a:hover {
            text-decoration: underline;
        }
        button{
        padding: 10px 20px;
        border-radius: 10px;
        background-color: #00BF63;
        color: white;
        border: none;
        cursor: pointer;
        margin-bottom: 20px;
        }
    </style>
<div class="tips">
        <h3>Brave主题由 <a href="https://blog.zwying.com/">赵阿卷</a> 开发创作
            <br>
            当前使用的Brave主题由 <a href="https://www.lmb520.cn/">林墨白</a> 魔改<br>
            配置主题时，请务必查看<a href="https://blog.lmb520.cn/archives/1196/">食用教程</a>
        </h3><hr><h3>系统信息</h3>
        <li>PHP版本：' . PHP_VERSION . '</li>
        <li>网站服务器：' . $_SERVER['SERVER_SOFTWARE'] . '</li>
        <li>Typecho版本：' . Typecho_Widget::widget('Widget_Options')->Version . '</li>';
    // Vaptcha插件未启用提醒
    echo '<h4>';
    if ($Vaptcha == '1' && !Typecho_Plugin::exists('Vaptcha')) {
        echo '请启用并配置 <a href="https://www.123912.com/s/tNNLjv-Jr0yh">Vaptcha</a> 插件<span style="color: red;">(必要)</span><br>';
    }
    // XQLocation插件未启用提醒
    if ($blessSwitch == '1' && !Typecho_Plugin::exists('XQLocation')) {
        echo '请启用并配置 <a href="https://www.toubiec.cn/1194.html">XQLocation</a> 插件<span style="color: orange;">(非必要)</span>';
    }
    echo '</h4>';
    echo '<hr><h3>更新检测</h3>';
    //版本更新检测
    include_once 'base/update.php';
    echo '</div>';
}