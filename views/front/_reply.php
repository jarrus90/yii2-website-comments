<?php
$level = empty($level) ? 1 : $level;
?>
<div class="block-comm level-<?= $level; ?>" id="comment<?= $model->id; ?>">
    <div class="wrap-img"><img src="img/comment-photo.png" alt=""></div>
    <div class="comm-text">
        <h5>Александр Александрович</h5>
        <p><?= $model->content; ?></p>
        <p class="comm-date">
            <?= date('d-m-Y', $model->created_at); ?> / <button>Комментировать</button>
        </p>
        <?php foreach ($model->childs AS $child) { ?>
            <?=
            $this->render('_reply', [
                'model' => $child,
                'level' => $level + 1
            ]);
            ?>
        <?php } ?>
    </div>
</div>