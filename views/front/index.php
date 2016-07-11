<?php

use yii\widgets\ListView;

?>

<?=

ListView::widget([
    'dataProvider' => $dataProvider,
    'id' => 'website-comments-site-replies',
    'itemOptions' => [
        'tag' => false
    ],
    'itemView' => '_reply'
]);
?>