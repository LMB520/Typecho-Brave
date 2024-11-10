<?php
/**
 * 主题首页
 * @package custom
 * Author: 林墨白
 * CreateTime: 2024/11/9
 */
$this->need('base/head.php');
$this->need('base/nav.php');
$this->need('base/other.php');
?>
</script>
<div class="container">
    <div class="row indexPlate">
<?php if ($this->options->blessSwitch == '1'): ?>
    <div class="col-md-4 fade-in-1">
        <a href="<?php $this->options->blessPageLink() ?>" class="card home-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="avatar avatar-md">
                            <img style="width:60px;height:auto" class="lazy" src="/usr/themes/Brave/asset/img/lazyload.svg" data-original="<?php $this->options->blessPageIcon() ?>" alt="...">
                        </div>
                    </div>
                    <div class="col">
                        <p class="h5">祝福墙</p>
                        <p class="small text-muted mb-1">💌写下对我们的祝福</p>
                    </div>
                </div>
            </div>
        </a>
    </div>
<?php endif; ?>
<?php if ($this->options->timeSwitch == '1'): ?>
        <div class="col-md-4 fade-in-1">
            <a href="<?php $this->options->timePageLink() ?>" class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-md">
                                <img style="width:60px;height:auto" class="lazy" src="/usr/themes/Brave/asset/img/lazyload.svg"  data-original="<?php $this->options->timePageIcon() ?>" alt="...">
                            </div>
                        </div>
                        <div class="col">
                            <p class="h5">点点滴滴</p>
                            <p class="small text-muted mb-1">💖记录你我生活</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php endif; ?>
        <?php if ($this->options->shuoshuoSwitch == '1'): ?>
        <div class="col-md-4 fade-in-1">
            <a href="<?php $this->options->shuoshuoPageLink() ?>" class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-md">
                                <img style="width:60px;height:auto" class="lazy" src="/usr/themes/Brave/asset/img/lazyload.svg"  data-original="<?php $this->options->shuoshuoPageIcon() ?>" alt="...">
                            </div>
                        </div>
                        <div class="col">
                            <p class="h5"style="font-family:FangzhengKT;color:#3B3838;">随笔说说</p>
                            <p class="small text-muted mb-1" >🕖你言我语</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php endif; ?>
        <?php if ($this->options->aboutSwitch == '1'): ?>
<div class="col-md-4 fade-in-1">
    <a href="<?php $this->options->aboutPageLink() ?>" class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="avatar avatar-md">
                        <img style="width:60px;height:auto" class="lazy" src="/usr/themes/Brave/asset/img/lazyload.svg" data-original="<?php $this->options->aboutPageIcon() ?>" alt="...">
                    </div>
                </div>
                <div class="col">
                    <p class="h5">关于我们</p>
                    <p class="small text-muted mb-1">💑我们的经历</p>
                </div>
            </div>
        </div>
    </a>
</div>
        <?php endif; ?>
        <?php if ($this->options->loveListSwitch == '1'): ?>
        <div class="col-md-4 fade-in-1">
            <a href="<?php $this->options->loveListPageLink() ?>" class="card ">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-md">
                                <img style="width:60px;height:auto" class="lazy" src="/usr/themes/Brave/asset/img/lazyload.svg"  data-original="<?php $this->options->loveListPageIcon() ?>" alt="...">
                            </div>
                        </div>
                        <div class="col">
                            <p class="h5">恋爱清单</p></p>
                            <p class="small text-muted mb-1">📜甜蜜瞬间有你陪伴</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php endif; ?>
        <?php if ($this->options->photoSwitch == '1'): ?>
        <div class="col-md-4 fade-in-1">
            <a href="<?php $this->options->photoPageLink() ?>" class="card ">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-md">
                                <img style="width:60px;height:auto" class="lazy" src="/usr/themes/Brave/asset/img/lazyload.svg"  data-original="<?php $this->options->photoPageIcon() ?>" alt="...">
                            </div>
                        </div>
                        <div class="col">
                            <p class="h5">相册</p>
                            <p class="small text-muted mb-1">🖼️留住你我回忆</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $this->need('base/footer.php'); ?>