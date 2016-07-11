<?php

class m160707_115321_support_replies extends \yii\db\Migration {

    /**
     * Create tables.
     */
    public function up() {

        $tableOptions = null;
        if (Yii::$app->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%website_comments}}', [
            'id' => $this->primaryKey(),
            'content' => $this->text()->notNull(),
            'from_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'parent_id' => $this->integer(),
            'is_blocked' => $this->boolean()->defaultValue(false)
                ], $tableOptions);
        $this->createIndex('website_comments-from', '{{%website_comments}}', 'from_id');
        $this->createIndex('website_comments-created_at', '{{%website_comments}}', 'created_at');
        $this->createIndex('website_comments-parent', '{{%website_comments}}', 'parent_id');
        
        $this->addForeignKey('fk-website_comments-parent', '{{%website_comments}}', 'parent_id', '{{%website_comments}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-website_comments-user', '{{%website_comments}}', 'from_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * Drop tables.
     */
    public function down() {
        $this->dropForeignKey('fk-website_comments-parent', '{{%website_comments}}');
        $this->dropForeignKey('fk-website_comments-user', '{{%website_comments}}');
        $this->dropTable('{{%website_comments}}');
    }

}
