<?php
$level = empty($level) ? 1 : $level;
?>
<div class="website-comment media level-<?= $level; ?>" id="comment<?= $model->id; ?>">
    <div class="media-left">
        <a href="#">
            <img class="media-object" src="<?= $model->from->avatar; ?>">
        </a>
    </div>
    <div class="media-body">
        <h4 class="media-heading"><?= $model->from->name; ?></h4>
        <p><?= $model->content; ?></p>
        <p class="comm-date">
            <?= date('d-m-Y', $model->created_at); ?> / <button>Комментировать</button>
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