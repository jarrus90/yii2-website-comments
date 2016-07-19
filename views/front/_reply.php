<?php
$level = empty($level) ? 1 : $level;
?>
<div class="website-comment media level-<?= $level; ?>" id="comment<?= $model->id; ?>">
    <div class="media-left">
        <a href="#">
            <img class="media-object" src="<?= $model->from->avatar; ?>" alt="<?= $model->from->name; ?>">
        </a>
    </div>
    <div class="media-body">
        <h4 class="media-heading comment-from"><?= $model->from->name; ?></h4>
        <p class="comment-content"><?= $model->content; ?></p>
        <p class="comm-date">
            <?= date('d-m-Y', $model->created_at); ?> / <button class="comment-reply" data-id="<?= $model->id; ?>"><?= Yii::t('website-comments', 'Reply'); ?></button>
        </p>
        <?php
        foreach ($model->childs AS $child) {
            echo $this->render('_reply', [
                'model' => $child,
                'level' => $level + 1
            ]);
        }
        ?>
    </div>
</div>