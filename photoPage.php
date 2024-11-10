<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php
/**
 * 相册模板
 *
 * @package custom
 */
?>
<!-- 
作者：ZhangDi
https://github.com/zzd/photo-page-for-typecho
时间:2024-01-15 版权所有，请勿删除
-->
<!-- jsdelivr公共CDN -->
<?php
function usePublicCdn()
{
        echo "gh/zzd/photo-page-for-typecho@master";
}
?>

<!-- 公共CDN结束 -->
<!-- 相册图片对象存储供应商，用以加载缩略图 -->
<?php
function storage($storage)
{
        if ($storage == "UPYUN") {
                echo "!/fw/640/quality/85";
        } elseif ($storage == "OSS") {
                echo "?x-oss-process=image/resize,w_640/quality,q_85";
        } elseif ($storage == "KODO") {
                echo "?imageView2/2/w/640/q/85";
        } elseif ($storage == "COS") {
                echo "?imageView2/2/w/640/q/85";
        } else
                echo "";
}
?>
<!-- 自动缩略图结束 -->
<!DOCTYPE HTML>
<html>

<head>
        <title><?php $this->title() ?> - <?php $this->options->title() ?></title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
        <link rel="stylesheet" href="<?php $this->options->photoPageJsDelivr() ?><?php usePublicCdn(); ?>/Multiverse/css/main.css" />
        <link rel="shortcut icon" href="<?php $this->options->siteUrl(); ?>/favicon.ico">
        <noscript>
                <link rel="stylesheet" href="<?php $this->options->photoPageJsDelivr() ?><?php usePublicCdn(); ?>/Multiverse/css/noscript.css" /></noscript>
</head>

<body class="is-preload">
        <!-- Wrapper -->
        <div id="wrapper">
                <!-- Header -->
                <header id="header">
                        <h1><a href="<?php $this->permalink() ?>"><strong><?php $this->title() ?></strong> </a></h1>
                        <nav>
                                <ul>
                                        <li><a href="#footer" class="icon solid fa-info-circle">关于</a></li>
                                </ul>
                        </nav>
                </header>
                <!-- Main -->
                <div id="main">
                </div>
                <!-- Footer -->
                <footer id="footer" class="panel">
                        <div class="inner split">
                                <div>
                                        <section>
                                                <h2>信息</h2>
                                                <p>本相册共有<span id="count_CN"></span>张图片<br>前端样式Multiverse由HTML5UP设计。</p>
                                             
                                        </section>
                                        <section>
                                                <ul class="icons">
                                                        <?php if ($this->fields->Twitter) : ?>
                                                                <li><a href="<?php echo $this->fields->Twitter; ?>" class="icon brands fa-twitter" target="_blank"><span class="label">Twitter</span></a></li>
                                                        <?php endif ?>
                                                        <?php if ($this->fields->Facebook) : ?>
                                                                <li><a href="<?php echo $this->fields->Facebook; ?>" class="icon brands fa-facebook-f" target="_blank"><span class="label">Facebook</span></a></li>
                                                        <?php endif ?>
                                                        <?php if ($this->fields->Instagram) : ?>
                                                                <li><a href="<?php echo $this->fields->Instagram; ?>" class="icon brands fa-instagram" target="_blank"><span class="label">Instagram</span></a></li>
                                                        <?php endif ?>
                                                        <?php if ($this->fields->GitHub) : ?>
                                                                <li><a href="<?php echo $this->fields->GitHub; ?>" class="icon brands fa-github" target="_blank"><span class="label">GitHub</span></a></li>
                                                        <?php endif ?>
                                                </ul>
                                        </section>
                                        <p class="copyright">
                                                &copy; <?php echo date("Y")?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a> 
                                        </p>
                                </div>
                                <div>
                                        <section>
                                                <h2>关于<?php $this->title() ?></h2>
                                                <?php if ($this->fields->about) : ?>
                                                        <p><?php echo $this->fields->about; ?></p>
                                                <?php else : ?>
                                                        <p>在自定义字段内添加about字段，即可编辑此内容，现有内容将自动替换。</p>
                                                <?php endif ?>
                                        </section>
                                </div>
                        </div>
                </footer>
        </div>
        <!--
                动态读取数据 by ZhangDi
                https://github.com/zzd/photo-page-for-typecho
        -->
        <script type="text/javascript">
                var datas =
`<?php
        $html = $this->row['text'];
        echo $html;
?>`;
                datas = datas.split("\n");
                for (var i = 0; i < datas.length; i++) {
                        datas[i] = datas[i].split(",");
                }

                function creatArticle(datas) {
                        var parent = document.getElementById("main");
                        for (var i = 0; i < datas.length; i++) {
                                var article = document.createElement("article");
                                article.className = "thumb";
                                parent.appendChild(article);
                                var a = document.createElement("a");
                                a.className = "image";
                                a.href = datas[i][2];
                                article.appendChild(a);
                                var img = document.createElement("img");
                                img.src = datas[i][2] + "<?php storage($this->fields->CDN); ?>";
                                a.appendChild(img);
                                var h2 = document.createElement("h2");
                                h2.innerHTML = datas[i][0];
                                article.appendChild(h2);
                                var p = document.createElement("p");
                                p.innerHTML = datas[i][1];
                                article.appendChild(p);
                        }
                }
                creatArticle(datas);
                document.getElementById("count_CN").innerHTML = datas.length;
        </script>
        <!-- Scripts -->
        <script src="<?php $this->options->photoPageJsDelivr() ?><?php usePublicCdn(); ?>/Multiverse/js/jquery.min.js"></script>
        <script src="<?php $this->options->photoPageJsDelivr() ?><?php usePublicCdn(); ?>/Multiverse/js/jquery.poptrox.min.js"></script>
        <script src="<?php $this->options->photoPageJsDelivr() ?><?php usePublicCdn(); ?>/Multiverse/js/browser.min.js"></script>
        <script src="<?php $this->options->photoPageJsDelivr() ?><?php usePublicCdn(); ?>/Multiverse/js/breakpoints.min.js"></script>
        <script src="<?php $this->options->photoPageJsDelivr() ?><?php usePublicCdn(); ?>/Multiverse/js/util.js"></script>
        <script src="<?php $this->options->photoPageJsDelivr() ?><?php usePublicCdn(); ?>/Multiverse/js/main.js"></script>
</body>

</html>