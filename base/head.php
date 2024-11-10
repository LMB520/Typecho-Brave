<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="<?php $this->options->charset(); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php $this->archiveTitle(array(
'category' => _t('分类 %s 下的文章'),
'search' => _t('包含关键字 %s 的文章'),
'tag' => _t('标签 %s 下的文章'),
'author' => _t('%s 发布的文章')
), '', ' - ');
?><?php $this->options->title();
?></title>
<?php $this->header();
?>
<div style="background-image: url('<?php echo htmlspecialchars($this->options->background, ENT_QUOTES); ?>'); background-repeat: no-repeat; background-size: cover; background-position: center 0;">
</div>
<style>
/*
引入自定义背景，建议白色
*/
body
{
    background-image: url(<?php $this->options->background() ?>);
    background-position: center 0;
}
<?php $this->options->stylemyself();
?>
</style>
<link rel="stylesheet" href="<?php $this->options->themeUrl('/base/style.css'); ?>">
<link href="https://gfonts.ctfile.com/css2?family=Inter:wght@400;700&display=swap"
rel="stylesheet">
<link href="https://lf3-cdn-tos.bytecdntp.com/cdn/expire-1-M/bootstrap/4.6.1/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
<script src="https://lf3-cdn-tos.bytecdntp.com/cdn/expire-1-M/jquery/3.6.0/jquery.min.js" type="application/javascript"></script>
<script src="https://lf6-cdn-tos.bytecdntp.com/cdn/expire-1-M/bootstrap/4.6.1/js/bootstrap.min.js" type="application/javascript"></script>
<link rel="stylesheet" href="/usr/themes/Brave/asset/OwO/OwO.min.css"/>
<script src="/usr/themes/Brave/asset/OwO/OwO.min.js"></script>
<link rel="stylesheet" href="/usr/themes/Brave/botui/botui.min.css" />
<link rel="stylesheet" href="/usr/themes/Brave/botui/botui-theme-default.css" />
<!--侧边标签栏-->
<div class="elevator_item" id="elevator_item" style="display:block;">
<a class="hd-time-limited" href="./" rel="nofollow"></a>
<a target="_self" class="feedback graHover" style="background-color: #ffffff;" href="/"><svg class="icon" style="width: 26px;height: 26px;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1029 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="18960"><path d="M767.0784 900.5056a82.2784 82.2784 0 0 0 82.2784-82.2784v-253.3376h22.016a47.36 47.36 0 0 0 33.8432-80.5376l-310.9888-317.44a79.872 79.872 0 0 0-114.4832 0.3584l-306.8928 317.44a47.36 47.36 0 0 0 34.048 80.3328h22.016v253.3376a82.2784 82.2784 0 0 0 82.2784 82.2784c10.5984-1.792 455.8848-0.1536 455.8848-0.1536z" fill="#8CECFF" p-id="974"></path><path d="M627.968 830.976a35.84 35.84 0 0 1-35.84-35.84v-193.5872a16.3328 16.3328 0 0 0-16.3328-16.3328H461.7216a16.3328 16.3328 0 0 0-16.2816 16.3328v192.8192a35.84 35.84 0 0 1-71.68 0v-192.8192a88.1152 88.1152 0 0 1 87.9616-88.0128h114.0736a88.1152 88.1152 0 0 1 88.0128 88.0128v193.5872a35.84 35.84 0 0 1-35.84 35.84z" fill="#FFDE73" p-id="975"></path><path d="M922.2656 442.9824l-337.92-344.7808a108.9536 108.9536 0 0 0-78.3872-32.9728h-0.3584a108.9536 108.9536 0 0 0-78.592 33.4848L93.7984 443.3408a74.496 74.496 0 0 0 53.504 126.3104H148.48v252.0576a112.64 112.64 0 0 0 112.64 112.384 20.48 20.48 0 0 0 2.5088 0c18.5344-1.1776 304.2304-0.5632 492.544 0a112.64 112.64 0 0 0 112.384-112.384v-252.0576h0.8704a74.5472 74.5472 0 0 0 53.248-126.6688z m-27.0336 63.1808a27.9552 27.9552 0 0 1-26.2144 17.408h-23.9104a22.9888 22.9888 0 0 0-23.04 23.04v275.0976a66.56 66.56 0 0 1-66.304 66.304c-172.8-0.6144-458.8032-1.4336-495.1552 0A66.56 66.56 0 0 1 194.56 821.7088v-275.0976a23.04 23.04 0 0 0-23.04-23.04h-24.2176a28.4672 28.4672 0 0 1-20.48-48.2304l333.3632-344.576a63.0784 63.0784 0 0 1 45.568-19.456 63.3344 63.3344 0 0 1 45.5168 19.1488l337.92 344.7808a27.904 27.904 0 0 1 6.0416 30.9248z" fill="#474747" p-id="976"></path><path d="M565.1968 515.7376H451.1232a75.3152 75.3152 0 0 0-75.2128 75.264v192.768a23.04 23.04 0 0 0 46.08 0v-192.768a29.184 29.184 0 0 1 29.1328-29.184h114.0736a29.2352 29.2352 0 0 1 29.184 29.184v193.536a23.04 23.04 0 0 0 46.08 0v-193.536a75.3664 75.3664 0 0 0-75.264-75.264z" fill="#474747" p-id="977"></path></svg></a>
<a class="feedback graHover" style="background-color: #ffffff;" href="<?php $this->options->timePageLink() ?>"><svg class="icon" style="width: 26px;height: 26px;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1029 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="18960"><path d="M164.3008 167.9872m163.3792 0l416.5632 0q163.3792 0 163.3792 163.3792l0 424.448q0 163.3792-163.3792 163.3792l-416.5632 0q-163.3792 0-163.3792-163.3792l0-424.448q0-163.3792 163.3792-163.3792Z" fill="#8CECFF" p-id="12461"></path><path d="M683.4176 794.1632H354.7648a35.84 35.84 0 0 1 0-71.68h328.6528a35.84 35.84 0 1 1 0 71.68zM550.7072 297.216l44.3392 89.8048a21.7088 21.7088 0 0 0 16.384 11.8784l99.072 14.3872a21.76 21.76 0 0 1 12.0832 37.2736l-71.68 69.888a21.7088 21.7088 0 0 0-6.2464 19.2512l16.896 98.7136a21.7088 21.7088 0 0 1-31.5392 22.9376L541.3376 614.4a21.4528 21.4528 0 0 0-20.48 0l-88.6784 46.592a21.76 21.76 0 0 1-31.5392-22.9376l16.9472-98.7136a21.76 21.76 0 0 0-6.2976-19.2512L339.8656 450.56a21.76 21.76 0 0 1 12.032-37.12l99.1232-14.3872a21.8112 21.8112 0 0 0 16.384-11.8784l44.288-89.8048a21.76 21.76 0 0 1 39.0144-0.1536z" fill="#FFDE73" p-id="12462"></path><path d="M673.1776 725.0432H344.5248a23.04 23.04 0 0 0 0 46.08h328.6528a23.04 23.04 0 1 0 0-46.08zM698.0608 381.44l-117.76-17.152L527.36 257.28a23.0912 23.0912 0 0 0-41.3184 0L433.152 364.288 315.0848 381.44A23.04 23.04 0 0 0 302.08 420.7104l85.6576 83.3024-20.1728 117.76a23.04 23.04 0 0 0 33.4336 24.2688l105.5744-55.7056 105.5744 55.5008a23.04 23.04 0 0 0 33.4336-24.2688l-20.1728-117.76 85.4528-83.3024a22.9888 22.9888 0 0 0-12.8-39.2704z m-113.4592 97.9968a23.0912 23.0912 0 0 0-6.656 20.48l14.336 83.5072-75.1616-39.5264a23.4496 23.4496 0 0 0-10.752-2.6112 23.0912 23.0912 0 0 0-10.7008 2.6112l-75.008 39.424L435.2 499.8144a23.0912 23.0912 0 0 0-6.6048-20.48L367.9232 420.3008l83.8144-12.1856a22.9888 22.9888 0 0 0 17.3568-12.5952l37.4784-75.9808 37.4784 75.9808a23.0912 23.0912 0 0 0 17.3568 12.5952L645.12 420.3008z" fill="#474747" p-id="12463"></path><path d="M729.344 87.04H281.6a201.5744 201.5744 0 0 0-201.3696 201.5744v452.3008A201.5744 201.5744 0 0 0 281.6 942.08h447.7952a201.5744 201.5744 0 0 0 201.3184-201.3184V288.6144A201.5744 201.5744 0 0 0 729.344 87.04z m155.2384 653.6704A155.392 155.392 0 0 1 729.344 896H281.6a155.392 155.392 0 0 1-155.2384-155.2384V288.6144A155.4432 155.4432 0 0 1 281.6 133.12h447.7952a155.4432 155.4432 0 0 1 155.2384 155.2896z" fill="#474747" p-id="12464"></path></svg></a>
<a class="feedback graHover" style="background-color: #ffffff;" href="/admin"><svg class="icon" style="width: 26px;height: 26px;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="9584"><path d="M357.9904 318.1568a175.5648 173.2096 0 1 0 351.1296 0 175.5648 173.2096 0 1 0-351.1296 0Z" fill="#FFDE73" p-id="1118"></path><path d="M458.1376 535.5008h158.4128a284.0576 284.0576 0 0 1 284.0576 284.0576v25.6a63.5392 63.5392 0 0 1-63.5392 63.5392H237.6192A63.5392 63.5392 0 0 1 174.08 844.8v-25.6a284.0576 284.0576 0 0 1 284.0576-283.6992z" fill="#8CECFF" p-id="1119"></path><path d="M663.4496 814.6944H370.176a35.84 35.84 0 0 1 0-71.68h293.2736a35.84 35.84 0 1 1 0 71.68z" fill="#FFDE73" p-id="1120"></path><path d="M641.536 472.4736A216.8832 216.8832 0 0 0 732.16 296.6016c0-120.1152-98.9184-217.856-220.4672-217.856S291.2256 176.4864 291.2256 296.6016a216.8832 216.8832 0 0 0 90.624 175.872 335.104 335.104 0 0 0-282.1632 330.4448v14.5408a114.2272 114.2272 0 0 0 114.0736 114.0736h595.8656a114.2272 114.2272 0 0 0 114.0736-114.0736v-14.5408a335.104 335.104 0 0 0-282.1632-330.4448zM337.3056 296.6016c0-94.72 78.2336-171.776 174.3872-171.776S686.08 201.8816 686.08 296.6016s-78.2336 171.7248-174.3872 171.7248-174.3872-77.056-174.3872-171.7248z m540.3136 520.8576a68.096 68.096 0 0 1-67.9936 67.9936H213.76a68.096 68.096 0 0 1-67.9936-67.9936v-14.5408a288.8704 288.8704 0 0 1 288.512-288.512h154.8288a288.8704 288.8704 0 0 1 288.512 288.512z" fill="#474747" p-id="1121"></path><path d="M658.3296 745.5744H365.056a23.04 23.04 0 0 0 0 46.08h293.2736a23.04 23.04 0 1 0 0-46.08z" fill="#474747" p-id="1122"></path></svg></a>
<a id="backToTopButton" class="feedback graHover" style="background-color: #ffffff; display: none;" href="javascript:void(0)"><svg class="icon" style="width: 26px;height: 26px;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="14608"><path d="M183.9104 173.6192m136.448 0l450.9184 0q136.448 0 136.448 136.448l0 456.7552q0 136.448-136.448 136.448l-450.9184 0q-136.448 0-136.448-136.448l0-456.7552q0-136.448 136.448-136.448Z" fill="#8CECFF" p-id="1263"></path><path d="M343.808 339.3024h368.64a35.84 35.84 0 1 0 0-71.68h-368.64a35.84 35.84 0 0 0 0 71.68zM551.8848 448.6144a35.84 35.84 0 0 0-50.7904 0L325.7344 627.2a35.84 35.84 0 0 0 51.2 50.2784l115.456-117.4016v211.3536a35.84 35.84 0 0 0 71.68 0v-209.92l115.7632 114.944a35.84 35.84 0 1 0 50.4832-50.8416z" fill="#FFDE73" p-id="1264"></path><path d="M733.184 83.9168H292.352A197.8368 197.8368 0 0 0 94.7712 281.6v447.1808a197.7856 197.7856 0 0 0 197.5808 197.5296h440.832a197.7856 197.7856 0 0 0 197.5808-197.5808V281.6a197.8368 197.8368 0 0 0-197.5808-197.6832z m151.5008 644.8128a151.6544 151.6544 0 0 1-151.5008 151.5008H292.352a151.6544 151.6544 0 0 1-151.5008-151.5008V281.6A151.7056 151.7056 0 0 1 292.352 129.9968h440.832A151.7056 151.7056 0 0 1 884.6848 281.6z" fill="#474747" p-id="1265"></path><path d="M697.088 265.0624h-368.64a23.04 23.04 0 0 0 0 46.08h368.64a23.04 23.04 0 0 0 0-46.08zM527.36 442.3168a22.9376 22.9376 0 0 0-16.2304-6.7072 22.9376 22.9376 0 0 0-16.2816 6.912L319.488 620.8512a23.04 23.04 0 0 0 32.8704 32.3072l137.3696-139.7248v242.6368a23.04 23.04 0 0 0 46.08 0v-240.64l137.5744 136.6528a23.04 23.04 0 0 0 32.4608-32.6656z" fill="#474747" p-id="1266"></path></svg></a>
<script>
var backToTopButton = document.getElementById('backToTopButton');
backToTopButton.addEventListener('click', function()
{
    scrollToTop(600);
}
);
window.addEventListener('scroll', function()
{
    var scrollDistance = window.scrollY || document.documentElement.scrollTop;
    if (scrollDistance > 200)
    {
        backToTopButton.style.display = 'block';
    }
    else
    {
        backToTopButton.style.display = 'none';
    }
}
);
function scrollToTop(scrollDuration)
{
    var scrollStep = -window.scrollY / (scrollDuration / 15);
    var scrollInterval = setInterval(function()
    {
        if (window.scrollY != 0)
        {
            window.scrollBy(0, scrollStep);
        }
        else clearInterval(scrollInterval);
    }
    ,15);
}
</script>
</div>
<!--引入自定义头部代码-->
<?php $this->options->CustomContenth();
?>
</head>
<body>