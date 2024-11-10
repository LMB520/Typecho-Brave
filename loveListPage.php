<?php
/**
* 恋爱清单
* @package custom
*
* Author: 林墨白
* CreateTime: 2024/11/9
* Love list page
*/
$this->need('base/head.php');
$this->need('base/nav.php');
$this->need('base/other.php');
?>
<div class="container text-center my-5">
<h5 class="list-text">💕恋爱清单💕</h5>
<?php echo App::parseShortCode($this->content) ?>
</div>
<?php $this->need('base/footer.php');
?>