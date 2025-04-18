<blockquote class="blockquote text-center fade-in-2" style="margin-top: 20px;">
    <?php if ($this->options->lovetimeSwitch == '1'): ?>
        <h5 class="card-title lover-card-title"><?php echo $this->options->lovetitle();
            ?></h5>
        <h5 id="site_runtime"></h5>
    <?php endif;
    ?>
    <?php if ($this->options->countdownSwitch == '1'): ?>
        <h5 class="card-title lover-card-title">距离<?php echo $this->options->countdowntitle();
            ?></h5>
        <h5 id="countdown_runtime"></h5>
    <?php endif;
    ?>
</blockquote>
<?php if ($this->options->lovetextSwitch == '1'): ?>
    <div class="lovecontent fade-in-1">
        <h5 class="list-text" style="margin: 0;">
<span id="lovetext"><?php echo $this->options->lovetext();
    ?></span>
        </h5>
    </div>
<?php endif;
?>