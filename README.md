![Screenshot_2024_0319_162331.png](https://files.blog.lmb520.cn/usr/uploads/2024/03/3090234747.png)

# 介绍
Brave主题是一款拥有多功能适合有对象的博主使用，可以和对象一起记录自己的恋爱历程。
## 原版本
**作者：**[赵阿卷](https://blog.zwying.com/)

**下载：**[https://github.com/zwying0814/Brave](https://github.com/zwying0814/Brave)

**教程：**[https://blog.zwying.com/archives/59.html](https://blog.zwying.com/archives/59.html)

## 魔改版
**演示：** [love.lmb520.cn](https://love.lmb520.cn)   
**下载：** [https://github.com/LMB520/Typecho-Brave/tree/Lv1.5.0](https://github.com/LMB520/Typecho-Brave/tree/Lv1.5.0)


感谢[伊梦乡归处](https://blog.pyrroleach.com/)提供部分魔改教程

# 目前支持的功能
* Pjax无刷新
* 图片懒加载
* 恋爱计时器小组件
* 纪念日倒计时小组件
* 随机情话小组件
* 留言墙小组件
* 点点滴滴小组件
* 随笔说说小组件
* 关于我们小组件
* 恋爱清单小组件
* 相册小组件
* 小组件可控开关
* 适配Vaptcha人机验证
* 留言评论美化优化
* 增加多种可控特效
* 优化了多处细节
* 增加多个开关

等等等……

# 魔改版食用教程
## 主题配置
**推荐在php7.4版本运行，太高的版本会报错**
将主题压缩包完整上传到服务器上 Typecho 的`/usr/themes/`文件夹内，解压，然后到 Typecho `后台-控制台-外观-启用主题`即可
由于本版本魔改太多，建议将原版或者其他魔改版备份后删除，再食用本主题。
启用后，创建对应页面，这里有几个页面需要创建，分别是首页页面、祝福板页面、点点滴滴页面、随笔说说页面、关于我们页面、恋爱清单页面、相册页面
**除了首页页面其他的页面不是必须创建，而且一定要选择对应的模板！！！**
首页页面创建好后，请在设置首页(如下图)
![63adb5b22d881.jpg](https://files.blog.lmb520.cn/usr/uploads/2024/03/2979583049.jpg)
然后就是主题设置了，主题设置内容截图
[_love.lmb520.cn.jpeg](https://files.blog.lmb520.cn/usr/uploads/2024/11/1384224947.jpeg)

喜欢的功能就打开，不喜欢就不打开，自由支配功能

## 伪静态配置
**请配置好伪静态规则，并将“是否使用地址重写功能”打开**
### Nginx伪静态
``` html
    if (!-e $request_filename) {
        rewrite ^(.*)$ /index.php$1 last;
    }
```
### Apache伪静态
``` html
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
```

## 基础内置图片配置
我们魔改版内置了许多图片，填写内置图片后可以让你快速配置主题以达到效果
**头部大图设置**
```html
/usr/themes/Brave/asset/img/background.jpg
```
**背景设置设置**
```html
/usr/themes/Brave/asset/img/background.svg
```
**首页祝福墙小组件图标**
```html
/usr/themes/Brave/asset/img/bless.svg
```
**首页点点滴滴小组件图标**
```html
/usr/themes/Brave/asset/img/time.svg
```
**首页随笔说说小组件图标**
```html
/usr/themes/Brave/asset/img/shuoshuo.svg
```
**首页关于我们小组件图标**
```html
/usr/themes/Brave/asset/img/about.svg
```
**首页恋爱清单小组件图标**
```html
/usr/themes/Brave/asset/img/lovelist.svg
```
**首页相册小组件图标**
```html
/usr/themes/Brave/asset/img/photo.svg
```
## 祝福墙配置
### 祝福墙显示归属地
祝福墙已适配由[苏晓晴](https://www.toubiec.cn/)开发的显示归属地[XQLocation](https://www.toubiec.cn/1194.html)插件，将插件上传服务器并启用即可
### 快速获取祝福者信息核心(JS代码)
网络上免费用QQ获取信息的API不知道什么时候跑路，也许上一秒还能用下一秒就没了。为了避免API跑路后带来不必要的更新，所以现在可以直接在主题配置里改写用QQ快速获取祝福者信息的核心代码。
**每个信息输入框对应的id：**

| 名称 | id |
| -------- | -------- |
| QQ号 | qq     |
| 昵称  | author |
| 邮箱  | mail   |
| 链接  | url     |


**目前能够使用的核心JS代码：**
``` JS
<script>
var qqInput = document.getElementById('qq');
var avatarImg = document.getElementById('avatar');

if (qqInput && avatarImg) {
    qqInput.addEventListener('blur', function () {
        var qq = this.value.trim();  
        if (qq !== '') {  
            if (/^\d{5,12}$/.test(qq)) {
                $.ajax({
                    url: `https://api.qjqq.cn/api/qqinfo?qq=${qq}`,
                    type: "GET",
                    timeout: 5000,
                    dataType: "json",
                    success: function (data) {
                        if (data.code === 200) {
                            document.getElementById('author').value = data.name;
                            document.getElementById('mail').value = `${qq}@qq.com`;
                            document.getElementById('url').value = `https://${qq}.qzone.qq.com`;
                            avatarImg.src = `https://q1.qlogo.cn/g?b=qq&nk=${qq}&s=100`;
                        } else {
                            document.getElementById('mail').value = `${qq}@qq.com`;
                            document.getElementById('url').value = `https://${qq}.qzone.qq.com`;
                            avatarImg.src = `https://q1.qlogo.cn/g?b=qq&nk=${qq}&s=100`;
                            alert(`获取昵称失败，请手动填写(つ﹏<。) \n提示: ${data.msg}`);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr, status, error);
                        document.getElementById('mail').value = `${qq}@qq.com`;
                        document.getElementById('url').value = `https://${qq}.qzone.qq.com`;
                        avatarImg.src = `https://q1.qlogo.cn/g?b=qq&nk=${qq}&s=100`;
                        alert('获取昵称失败，请手动填写(つ﹏<。)');
                    }
                });
            } else {
                avatarImg.src = "/usr/themes/Brave/asset/img/love.png";
                alert('请输入5-12位数字的QQ号(σ｀д′)σ');
            }
        }
    });
}
</script>
```
## 恋爱清单配置
恋爱清单采用短代码形式书写，不再采用繁杂的文章发布，格式如下：
```Markdown
[loveList]
[item status="0" img="" listct=""]一起看日出🌅[/item]
[item status="0" img="" listct=""]一起看日落🌄[/item]
[/loveList]
```
**参数说明：**
status为0将显示灰色对勾，代表未完成此项，为1会显示绿色对勾，代表完成此项img后面可以填写图片的链接，将显示在清单展开后，不填默认灰色填充，listct后面填写时间内容(格式不做规定)

如果需要预制好的恋爱清单，就直接将以下内容完整复制到到恋爱清单页面里
```Markdown
[loveList]
[item status="0" img="" listct=""]一起看日出🌅[/item]
[item status="0" img="" listct=""]一起看日落🌄[/item]
[item status="0" img="" listct=""]一起看绚烂的烟花🌟[/item]
[item status="0" img="" listct=""]一起吃路边摊🍖[/item]
[item status="0" img="" listct=""]一起唱首歌并录下来🎤[/item]
[item status="0" img="" listct=""]一起穿情侣装逛街👫[/item]
[item status="0" img="" listct=""]一起去游乐园（迪士尼）嗨一天🎈[/item]
[item status="0" img="" listct=""]陪对方过生日🎂[/item]
[item status="0" img="" listct=""]一起去海南的天涯海角🌴[/item]
[item status="0" img="" listct=""]一起去你的小学、初中、高中、大学👫[/item]
[item status="0" img="" listct=""]一起去我的小学、初中、高中、大学👫[/item]
[item status="0" img="" listct=""]一起放孔明灯🏮[/item]
[item status="0" img="" listct=""]去遍中国的每一个省份🚉[/item]
[item status="0" img="" listct=""]一起去钓鱼🐟[/item]
[item status="0" img="" listct=""]一起去当志愿者、义工👮[/item]
[item status="0" img="" listct=""]一起坐一辆没坐过的车，在陌生的地方下车逛🚃[/item]
[item status="0" img="" listct=""]淋一次雨，在雨中漫步☔[/item]
[item status="0" img="" listct=""]为对方做早餐🍔[/item]
[item status="0" img="" listct=""]在沙滩上写下彼此的名字✍[/item]
[item status="0" img="" listct=""]一起看初雪⛄[/item]
[item status="0" img="" listct=""]穿彼此的衣服👯[/item]
[item status="0" img="" listct=""]一起去坐过山车🎎[/item]
[item status="0" img="" listct=""]嘴对嘴吃东西🍜[/item]
[item status="0" img="" listct=""]一起去游泳🏊[/item]
[item status="0" img="" listct=""]去遍人民币背后的风景⛳[/item]
[item status="0" img="" listct=""]两个人一起锻炼运动🏃💃[/item]
[item status="0" img="" listct=""]一起爬山💑[/item]
[item status="0" img="" listct=""]在耳边低声旖旎"我爱你"💖[/item]
[item status="0" img="" listct=""]一起对着流星许愿🌠[/item]
[item status="0" img="" listct=""]一起手拉手压马路👫[/item]
[item status="0" img="" listct=""]一起坐在阳台，晒着太阳，磕着瓜子，聊着天👐[/item]
[item status="0" img="" listct=""]一起养一只宠物🐶[/item]
[item status="0" img="" listct=""]在公共场合下一起喝娃哈哈🍼[/item]
[item status="0" img="" listct=""]一起去买菜、做饭、刷碗🍛[/item]
[item status="0" img="" listct=""]一起去坐热气球🎈[/item]
[item status="0" img="" listct=""]带我去你童年居住的地方走一走👩[/item]
[item status="0" img="" listct=""]带你去我童年居住的地方走一走🧑[/item]
[item status="0" img="" listct=""]一起堆雪人⛄[/item]
[item status="0" img="" listct=""]一起坐摩天轮，在最高处拥吻💏[/item]
[item status="0" img="" listct=""]一起用勺子吃西瓜🍉[/item]
[item status="0" img="" listct=""]一起捡贝壳🐚[/item]
[item status="0" img="" listct=""]看一次冰灯⛲[/item]
[item status="0" img="" listct=""]一起去看海🌊[/item]
[item status="0" img="" listct=""]一起走沙滩🚶[/item]
[item status="0" img="" listct=""]一起去看支付宝共同种下的树🎋[/item]
[item status="0" img="" listct=""]一起跨年，通宵守岁📺[/item]
[item status="0" img="" listct=""]送彼此出门，给一个大大的拥抱与啵啵😚[/item]
[item status="0" img="" listct=""]一起看书，装满我们的书架💡[/item]
[item status="0" img="" listct=""]为对方穿衣服、系鞋带🙅[/item]
[item status="0" img="" listct=""]推对方玩秋千💁[/item]
[item status="0" img="" listct=""]一起去参加朋友的婚礼💕[/item]
[item status="0" img="" listct=""]在马尔代夫，体验玻璃地板的海上小屋🏡[/item]
[item status="0" img="" listct=""]一起坐一次飞机🛫[/item]
[item status="0" img="" listct=""]一起坐一次游轮🚤[/item]
[item status="0" img="" listct=""]一起去看一次演唱会🎵[/item]
[item status="0" img="" listct=""]一起在浴缸里泡澡🛀[/item]
[item status="0" img="" listct=""]一起去看海豚🐬[/item]
[item status="0" img="" listct=""]一起去捡落叶🍁[/item]
[item status="0" img="" listct=""]开车红灯时叫你啵啵🚗[/item]
[item status="0" img="" listct=""]一起完成一个冒险刺激的挑战💀[/item]
[item status="0" img="" listct=""]一起沿着铁轨走🚂[/item]
[item status="0" img="" listct=""]一起去看埃菲尔铁塔，在塔下拥吻👄[/item]
[item status="0" img="" listct=""]一起设计整理房间💎[/item]
[item status="0" img="" listct=""]徒步走完北京二环👟[/item]
[item status="0" img="" listct=""]与好朋友一起，享受四人约会的美妙💜💛💚💙[/item]
[item status="0" img="" listct=""]为他打领带🔫[/item]
[item status="0" img="" listct=""]我叫你一次“老婆”，你叫我一次“老公”👨‍❤️‍💋‍👨[/item]
[item status="0" img="" listct=""]带你在午夜开车兜风🚙[/item]
[item status="0" img="" listct=""]为她涂指甲油💅[/item]
[item status="0" img="" listct=""]来一次浪漫的小情趣😍[/item]
[item status="0" img="" listct=""]在阳台上养着一排多肉植物🥦[/item]
[item status="0" img="" listct=""]一起过一次六一儿童节👧👦[/item]
[item status="0" img="" listct=""]入住一次五星级酒店🏨[/item]
[item status="0" img="" listct=""]为彼此换一个对方心仪的发型，不论长短烫染💇[/item]
[item status="0" img="" listct=""]偷偷观察对方熟睡的模样，记录下来📷[/item]
[item status="0" img="" listct=""]一起去打电玩👾[/item]
[item status="0" img="" listct=""]一起给对方写信，读给对方听📄[/item]
[item status="0" img="" listct=""]一起滑雪，摔倒也要拉着你🎿[/item]
[item status="0" img="" listct=""]拥有我们独特的情侣戒指💍[/item]
[item status="0" img="" listct=""]一起完成一副千片拼图😜[/item]
[item status="0" img="" listct=""]一起去天安门看升旗仪式🚄[/item]
[item status="0" img="" listct=""]一起包饺子🥟[/item]
[item status="0" img="" listct=""]一起去吃自助餐，把没尝过的食材都尝试一遍🔪[/item]
[item status="0" img="" listct=""]去拍一回写真📸[/item]
[item status="0" img="" listct=""]一起去新加坡看焰火表演🎇[/item]
[item status="0" img="" listct=""]一起去看极光⚡⚡[/item]
[item status="0" img="" listct=""]背着她走一段路👣[/item]
[item status="0" img="" listct=""]一起赏月🌙[/item]
[item status="0" img="" listct=""]一起去看樱花🌸[/item]
[item status="0" img="" listct=""]以喝交杯酒的方式喝东西🥂[/item]
[item status="0" img="" listct=""]一起买一张彩票🎫[/item]
[item status="0" img="" listct=""]在树下埋下我们的约定🎑[/item]
[item status="0" img="" listct=""]带上你我的家人去聚会、旅游🚙[/item]
[item status="0" img="" listct=""]来一场难忘的求婚🎁💍[/item]
[item status="0" img="" listct=""]在朋友面前大方介绍彼此💋[/item]
[item status="0" img="" listct=""]拍属于我们自己的婚纱照🎎[/item]
[item status="0" img="" listct=""]互相在朋友圈晒结婚证📇[/item]
[item status="0" img="" listct=""]设计一场梦中的婚礼💤🌹🎉[/item]
[item status="0" img="" listct=""]拥有一个爱的结晶，给予宝贝最好的爱👶👼[/item]
[item status="0" img="" listct=""]余生漫漫，执子之手，与子偕老💏[/item]
[/loveList]
```

## 相册配置
### JsDelivr源
相册我们采用[photo-page-for-typecho](https://github.com/zzd/photo-page-for-typecho)提供的Multiverse风格照片集单页，由于里面官方JsDelivr源在国内的访问体验并不算理想，导致首次访问相册极慢，所以改为在主题配置里可以自定义配置JsDelivr源。
**目前能够使用JsDelivr源：** [https://jsd.vxo.im/](https://jsd.vxo.im/)
### 内容配置
[bsgit user="zzd"]photo-page-for-typecho[/bsgit]
相册内容请按照如下格式一行一行的写
``` html
标题,简介,图片链接
```
例如：
``` html
第一张合影,2023年08月31日拍摄,https://jjaa.love/usr/uploads/2024/03/2427758495.jpg
picture1,2020年01月01日拍摄,https://ww2.sinaimg.cn/large/006uAlqKgy1fzlbjrxju2j31400u04qz.jpg
picture2,2020年01月02日拍摄,https://ww2.sinaimg.cn/large/006uAlqKgy1fzlbjrxju2j31400u04qz.jpg
picture3,2020年01月03日拍摄,https://ww2.sinaimg.cn/large/006uAlqKgy1fzlbjrxju2j31400u04qz.jpg
```
### 自定义字段配置
1. (可选) about：控制指定位置的文本，可自定义关于等信息
2. (可选) CDN：用以匹配你所使用的对象存储服务商，目前支持又拍云、阿里云OSS、七牛云、腾讯云，本字段目的在于使用云图像处理动态生成缩略图。对应填写内容为：UPYUN/OSS/KODO/COS
3. (可选) 社交链接字段 Twitter, Facebook, Instagram, GitHub，给相应字段填入链接即可。


## 关于我们配置
这里我们使用的是botui聊天机器人，效果体验：https://love.lmb520.cn/about.html

里面的内容我我没有写在后台，需要自行编辑`usr/themes/Brave/botui/botui.js`
如果有点基础的应该可以看懂怎么改了吧，没有基础的就自己百度现学吧(~~或者联系我，如果我有时间~~)

## Vaptcha人机验证配置
本功能需要搭配由[白熊](https://www.bearnotion.ru/)开发的的Vaptcha_Typecho插件
[bsgit user="whitebearcode"]Vaptcha_Typecho[/bsgit]
**Brave适配版下载链接：**  https://lmb520.lanzoul.com/b05l2yukd
**密码：** lmb520
建议使用适配版，如果用原版的话，手机端会出现验证框太大的情况(如下图)
![Screenshot_2024_0319_095337.png](https://files.blog.lmb520.cn/usr/uploads/2024/03/1376950910.png)
将`Vaptcha`插件在`/usr/plugins`解压，并在后台开启，然后设置Vaptcha插件。
**具体配置：**
1. 在[https://www.vaptcha.com/](https://www.vaptcha.com/) 注册账号并创建验证单元
2. 在插件设置里面填写`VID`，并且在`按钮`配置框填写`button`(如下图)![Screenshot_2024_0320_083332.png](https://files.blog.lmb520.cn/usr/uploads/2024/03/1363383427.png)

**注意：** 主题的Vaptcha人机验证开关和Vaptcha插件要同步启用和关闭

## Pjax无刷新配置
PJAX（Pushstate + Ajax）是一种用于加快网页加载速度的技术。它结合了HTML5的pushState API和Ajax技术，使得在不刷新整个页面的情况下，可以实现局部页面内容的更新。然而，PJAX也有一些局限性，例如像某些API无法进行及时获取更新内容。

如果你启用了**Pjax无刷新**，但是关闭了**Vaptcha人机验证**，那么你无需配置任何内容，因为相关API的重载我们已经写入了代码里。

如果你既启用了**Pjax无刷新**，又启用了**Vaptcha人机验证**，那么需要在`Pjax回调函数`填入以下内容
``` JS
//vaptcha验证
    var vaptchaScript = document.createElement('script');
    vaptchaScript.src = "https://v-cn.vaptcha.com/v3.js";    document.head.appendChild(vaptchaScript);
    vaptchaScript.onload = function() { document.getElementById("button").setAttribute("disabled", true);
        vaptcha({
            vid: "65f54815d3784602950e7f51",
            mode: 'click',
            scene: 0,
            container: "#VAPTCHAContainer",
            area: 'auto',
        }).then(function (VAPTCHAObj) {
            obj = VAPTCHAObj;
            VAPTCHAObj.render();
            VAPTCHAObj.listen('pass', function () {
                document.getElementById("button").removeAttribute("disabled");
            });
        });
    };
```
**注意：** 需要将`vid: "65f54815d3784602950e7f51",`里面的`65f54815d3784602950e7f51`换为你自己的VID，并且要和Vaptcha插件里面填的VID一样

# 需要注意的地方
1. 祝福墙已经禁止输入男女主的昵称，但是男女主可以登录账号发祝福(因为账号可以设置昵称并且不受该限制)
2. 已经禁止游客发随笔说说，但是男女主登录后可以在前台发说说。

第一点是为了防止有人冒充男女主发不当言论，第二点是防止游客乱发说说

# 更新记录
## Lv-1.5.1
1. 优化代码内容
2. 增加相关提示
3. 修复了一些已知问题
## Lv-1.5.0
### 更新内容
1. 优化了模板目录结构（有些文件改了名称和目录位置）
2. 更换了Gravatar源
3. 修复了不填QQ号不能发送祝福语的Bug
4. 修复了无法用QQ号快速获取信息
5. 增加了自定义相册里的JsDelivr源
6. 祝福墙已适配显示归属地XQLocation插件
7. 修复了一些已知问题

由于这次目录文件变动比较大，所以老用户需要修改一些地方，比如：独立页面需要重新选择模板、主题内置图片等等
**具体改动位置：** [https://github.com/LMB520/Typecho-Brave/compare/Lv1.4...Lv1.5.0](https://github.com/LMB520/Typecho-Brave/compare/Lv1.4...Lv1.5.0)
## Lv-1.4.1
首先恭喜[韩小韩WebAPI接口](https://api.vvhan.com/)升级完毕
![Screenshot_2024_0320_230504.png](https://files.blog.lmb520.cn/usr/uploads/2024/03/894502969.png)
由于[韩小韩WebAPI接口](https://api.vvhan.com/)于2024年3月20日晚10:00:00，迎来最后一次大更新，也就是大版本更新的最终版本!
因为更新后接口改变了，所以导致我今天才发布魔改版中的随机情话也失效了。