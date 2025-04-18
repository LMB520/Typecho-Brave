<?php
/**
 * 勇敢爱 - Typecho情侣主题(魔改版)
 * @package     Brave
 * @author      林墨白
 * @version     Lv1.5.3
 * @link        https://blog.lmb520.cn
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('base/head.php');
$this->need('base/nav.php');
$this->need('base/other.php');
?>
    <div class="list-content mx-auto mt-5">
        <h5 class="list-text">💕点点滴滴💕</h5>
        <?php if ($this->have()) : ?>
            <?php while ($this->next()) : ?>
                <article class="post fade-in-1 card cardshadow">
                    <h4 class="post-title" itemprop="name headline"><a class=" list-wbc" itemprop="url"
                                                                       href="<?php $this->permalink() ?>"><?php $this->title() ?></a>
                    </h4>
                    <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->author();
                        ?>·
                        <div class="lover-card-title" style="display: inline;">开心地写于</div>
                        <?php $this->date();
                        ?></time>
                </article>
            <?php endwhile;
            ?>
        <?php else : ?>
            <article class="post" style="text-align: center;">
                <h2 class="post-title"><?php _e('没有找到内容');
                    ?></h2>
            </article>
        <?php endif;
        ?>
        <?php $this->pageNav('&laquo; 前一页', '后一页 &raquo;');
        ?>
    </div>
    </div>
<?php $this->need('base/foot.php');
?>