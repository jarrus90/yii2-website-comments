<?php

use yii\db\Migration;

class m160710_115510_comments_add_block_info extends Migration {

    public function safeUp() {
        $this->addColumn('{{%website_comments}}', 'blocked_by', $this->integer());
        $this->addColumn('{{%website_comments}}', 'blocked_at', $this->integer());
        $this->addColumn('{{%website_comments}}', 'blocked_reason', $this->text());
    }

    public function safeDown() {
        $this->dropColumn('{{%website_comments}}', 'blocked_by');
        $this->dropColumn('{{%website_comments}}', 'blocked_at');
        $this->dropColumn('{{%website_comments}}', 'blocked_reason');
    }

}
