<?php

use yii\widgets\ListView;

?>

<?=

ListView::widget([
    'dataProvider' => $dataProvider,
    'id' => 'support-site-replies',
    'itemOptions' => [
        'tag' => false
    ],
    'itemView' => '_reply'
]);
?>