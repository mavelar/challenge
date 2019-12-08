<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_social}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m191208_021841_create_user_social_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_social}}', [
            'id' => $this->primaryKey(),
            'twitter' => $this->string(),
            'user_id' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_social-user_id}}',
            '{{%user_social}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_social-user_id}}',
            '{{%user_social}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-user_social-user_id}}',
            '{{%user_social}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_social-user_id}}',
            '{{%user_social}}'
        );

        $this->dropTable('{{%user_social}}');
    }
}
