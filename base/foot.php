</div>
<footer>
    <div class="p-5 text-center ">
        <h6 class="lover-card-title"> &copy; <?php echo date("Y"); ?><a href="./"
                                                                        target="_blank"> <?php $this->options->title() ?></a>
            ＆ Forever Love</h6>
        <h6 class="lover-card-title"><a href="http://beian.miit.gov.cn/"
                                        target="_blank"> <?php $this->options->ICP() ?></a></h6>
        <!--版权©勿删-->
        <h6>我们自豪的使用<a href="http://typecho.org" target="_blank">Typecho</a> ＆ <a
                    href="https://blog.lmb520.cn/archives/1196/" target="_blank">Brave</a></h6>
                    <!--自定义底部-->
<?php $this->options->CustomizeFoot();
?>
    </div>
</footer>
<?php if ($this->options->pjaxSwitch == '1'): ?>
    <!--pjax代码-->
    <script>
        $(document).pjax("a", "#pjax-container", {
                fragment: "#pjax-container",
                timeout: 6000
            }
        );
        $(document).on("pjax:send", function () {
                NProgress.start();
            }
        );
        $(document).on("pjax:complete", function () {
                // 恋爱计时
                showSiteRuntime();
                // 纪念日倒计时
                showCountdown();
                // 图片懒加载
                lazyload();
                // 随机情话
                lovetext();
                // 淡入效果
                fadeIn();
                <?php echo $this->options->pjaxContent();
                ?>
                NProgress.done();
            }
        );
    </script>
<?php endif;
?>
<?php if ($this->options->lovetextSwitch == '1'): ?>
    <!--随机情话-->
    <script>
        function lovetext() {
            fetch('https://api.vvhan.com/api/text/love?type=json')
                .then(response => response.json())
                .then(data => {
                        if (data.success) {
                            const loveText = data.data.content;
                            document.getElementById('lovetext').innerText = loveText;
                        } else {
                            console.error('请求失败');
                        }
                    }
                )
                .catch(error => {
                        console.error('Fetch error:', error);
                    }
                );
        }

        lovetext();
    </script>
<?php endif;
?>
<?php if ($this->options->lovetimeSwitch == '1'): ?>
    <script>
        //恋爱计时
        function showSiteRuntime() {
            var siteRuntime = $("#site_runtime");
            if (siteRuntime.length === 0) return;
            var start = new Date("<?php echo $this->options->lovetime(); ?>");

            function updateSiteRuntime() {
                var now = new Date();
                var diff = now - start;
                var days = Math.floor(diff / (1000 * 60 * 60 * 24));
                var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((diff % (1000 * 60)) / 1000);
                siteRuntime.html("第 <span class=\"bigfontNum\" style=\"color: red;\">" + days + "</span> 天 <span class=\"bigfontNum\" style=\"color: orange;\">" + hours + "</span> 小时 <span class=\"bigfontNum\" style=\"color: blue;\">" + minutes + "</span> 分钟 <span class=\"lover-card-title bigfontNum\">" + seconds + "</span> 秒");
            }

            updateSiteRuntime();
            // 立即显示一次时间
            setInterval(updateSiteRuntime, 1000);
            // 每秒更新时间
        }

        showSiteRuntime();
    </script>
<?php endif;
?>
<?php if ($this->options->countdownSwitch == '1'): ?>
    <script>
        //纪念日倒计时
        function showCountdown() {
            var countdownRuntime = $("#countdown_runtime");
            if (countdownRuntime.length === 0) {
                return;
            }
            var end = new Date("<?php echo $this->options->countdowntime(); ?>");

            function updateCountdown() {
                var now = new Date();
                if (now >= end) {
                    // 计算已过去的时间
                    var timeDiff = now.getTime() - end.getTime();
                    var days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);
                    countdownRuntime.html("已过去 <span class=\"bigfontNum\" style=\"color: red;\">" + days + "</span> 天 <span class=\"bigfontNum\" style=\"color: orange;\">" + hours + "</span> 小时 <span class=\"bigfontNum\" style=\"color: blue;\">" + minutes + "</span> 分钟 <span class=\"lover-card-title bigfontNum\">" + seconds + "</span> 秒");
                } else {
                    // 计算倒计时剩余时间
                    var timeDiff = end.getTime() - now.getTime();
                    var days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);
                    countdownRuntime.html("还剩 <span class=\"bigfontNum\" style=\"color: red;\">" + days + "</span> 天 <span class=\"bigfontNum\" style=\"color: orange;\">" + hours + "</span> 小时 <span class=\"bigfontNum\" style=\"color: blue;\">" + minutes + "</span> 分钟 <span class=\"lover-card-title bigfontNum\">" + seconds + "</span> 秒");
                }
            }

            updateCountdown();
            // 立即显示一次倒计时
            setInterval(updateCountdown, 1000);
            // 每秒更新倒计时
        }

        showCountdown();
    </script>
<?php endif;
?>
<?php if (is_array($this->options->Specialeffects)) {
    if (in_array('dianji', $this->options->Specialeffects)) {
        echo '<!--点击爱心特效-->
        <script>
        var a_idx = 0;
        $("body").click(function(e) {
        var a = new Array(
        "❤️", "💛", "🧡", "💚", "💙"
        );
        var $i = $("<span/>").text(a[a_idx]);
        a_idx = (a_idx + 1) % a.length;
        var x = e.pageX,
        y = e.pageY;
        $i.css({
        "z-index": 144469,
        "top": y - 20,
        "left": x,
        "position": "absolute",
        "font-weight": "bold",
        "color": "#f00"
        });
        $("body").append($i);
        $i.animate({
        "top": y - 160,
        "opacity": 0
        },
        1500,
        function() {
        $i.remove()
        })
        });
        </script>';
    }
}
?>
<!--淡入效果-->
<script>
    function fadeIn() {
        const elements1 = document.querySelectorAll('.fade-in-1');
        const elements2 = document.querySelectorAll('.fade-in-2');
        const options = {
                root: null,
                rootMargin: '0px',
                threshold: 0.5
            }
        ;
        const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = 1;
                            entry.target.style.transform = 'translateY(0)';
                            observer.unobserve(entry.target);
                        }
                    }
                );
            }
            , options);
        elements1.forEach(element => {
                observer.observe(element);
            }
        );
        elements2.forEach(element => {
                observer.observe(element);
            }
        );
    }

    fadeIn();
</script>
<!--全局懒加载-->
<script src="/usr/themes/Brave/asset/js/lazyload.js"></script>
<script>
    function lazyload() {
        $("img.lazy").lazyload({
                effect: "fadeIn", threshold: 200
            }
        );
    }

    lazyload();
</script>
<?php $this->foot();
?>
</body>
</html>