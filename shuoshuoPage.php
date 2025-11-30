<?php
/**
 * 随笔说说
 * @package custom
 * Author: 林墨白
 * CreateTime: 2024/11/9
 */
$this->need('base/head.php');
$this->need('base/nav.php');
$this->need('base/other.php');
$this->comments()->to($comments);
?>
<?php function threadedComments($comments, $options)
{
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }
    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
    ?>
    <div id="li-<?php $comments->theId(); ?>" class=" comment-body<?php if ($comments->levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
} else {
    echo ' comment-parent';
}
$comments->alt(' comment-odd', ' comment-even');
echo $commentClass;
?>">
    <div class="commentlist fade-in-1">
        <div class="comment" id="li-<?php $comments->theId(); ?>">
            <div id="<?php $comments->theId(); ?>">
                <div class="comment-avatar"><img alt="" src="/usr/themes/Brave/asset/img/lazyload.svg"
                                                 data-original="<?= App::avatarQQ($comments->mail); ?>s=100"
                                                 class="avatar avatar-96 photo lazy" style="display: inline;"></div>
                <div class="comment-body">
                    <div class="comment_author">
<span class="name"><?php $comments->author();
    ?></span>
                        <em><?php $comments->date('Y-m-d H:i');
                            ?></em>
                    </div>
                    <div class="comment-text">
                        <?php
                        $cos = preg_replace('#\:@\((.*?)\)#', '<img style="width:20px;height:20px" src="/usr/themes/Brave/asset/OwO/QQ/$1.gif">', $comments->content);
                        echo $cos;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

?>
<?php if ($this->allow('comment')) : ?>
    <div id="<?php $this->respondId(); ?>" class="respond list-content mx-auto mt-5">
        <h5 class="list-text">💕随笔说说💕</h5>
        <div class="list-top commentframe cardshadow">
            <?php if ($comments->have()) : ?>
                <h5 class="loveList-title"><?php $this->commentsNum(_t('暂无说说'), _t('仅有一条说说'), _t('累计已经记录<span class="bigfontNum"> %d </span>条说说'));
                    ?></h5>
                <?php $comments->listComments();
                ?>
                <?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;');
                ?>
            <?php endif;
            ?>
            <hr>
            <form method="post" action="<?php $this->commentUrl() ?>" name="comment-form" id="comment-form" role="form"
                  class="comment-form">
                <?php if ($this->user->hasLogin()) : ?>
                    <p><?php _e('登录身份: ');
                        ?><a
                                href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName();
                            ?></a>.
                        <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出');
                            ?> &raquo;
                        </a>
                    </p>
                    <div class="form-group">
<textarea rows="3" cols="50" name="text" id="textarea" class="form-control OwO-textarea"
          placeholder="<?php _e('青春岁月里，满满都是你'); ?>"
          required><?php $this->remember('text');
    ?></textarea>
                    </div>
                    <!--OwO表情-->
                    <div class="OwO form-row"></div>
                    <script>
                        var OwO_demo = new OwO(
                            {
                                logo: 'OωO表情',
                                container: document.getElementsByClassName('OwO')[0],
                                target: document.getElementsByClassName('OwO-textarea')[0],
                                api: '/usr/themes/Brave/asset/OwO/OwO.json',
                                position: 'down',
                                width: '100%',
                                maxHeight: '250px'
                            }
                        );
                    </script>
                <?php if ($this->options->Vaptcha == '1'): ?>
                    <div style="width: 100%;display: flex;justify-content: flex-end;margin-right: 10px;margin-top: -33.5px;">
                        <?php $this->vaptchastyle();
                        ?>
                    </div><br>
                <?php endif;
                ?>
                    <div class="form-group">
                        <button id="button" type="submit" class="float-right btn btn-outline-danger"
                                style="float: right;">
                            <svg t="1659667552303" class="icon" viewBox="0 0 1024 1024" version="1.1"
                                 xmlns="http://www.w3.org/2000/svg" p-id="1605" width="22" height="22">
                                <path d="M727.04 750.592h-68.608v-81.92H686.08V249.856L512 99.328 337.92 253.952v414.72h28.672v81.92H296.96l-40.96-40.96V235.52l13.312-30.72 215.04-190.464h54.272l215.04 186.368 14.336 30.72v478.208z"
                                      fill="#437DFF" p-id="1606"></path>
                                <path d="M869.376 638.976l-147.456-18.432-35.84-40.96V350.208l69.632-28.672 147.456 147.456 12.288 28.672v99.328l-46.08 41.984zM768 543.744l65.536 8.192v-35.84L768 449.536v94.208zM154.624 638.976l-46.08-40.96v-99.328l12.288-28.672 147.456-147.456 69.632 28.672v229.376l-35.84 40.96-147.456 17.408z m35.84-123.904v35.84L256 542.72v-94.208l-65.536 66.56z"
                                      fill="#437DFF" p-id="1607"></path>
                                <path d="M512 465.92m-67.584 0a67.584 67.584 0 1 0 135.168 0 67.584 67.584 0 1 0-135.168 0Z"
                                      fill="#437DFF" p-id="1608"></path>
                                <path d="M479.232 660.48h58.368v233.472h-58.368zM391.168 723.968h58.368v157.696h-58.368zM461.824 922.624h58.368v88.064h-58.368zM574.464 748.544h58.368v188.416h-58.368z"
                                      fill="#63F7DE" p-id="1609"></path>
                            </svg>
                            发送说说
                        </button>
                        <br><br>
                    </div>
                <?php else : ?>
                    <h3><?php _e('游客没有权限发说说哦~');
                        ?></h3>
                <?php endif;
                ?>
            </form>
        </div>
    </div>
<?php else : ?>
    <h3><?php _e('评论已关闭');
        ?></h3>
<?php endif;
?>
<?php $this->need('base/foot.php');
?>