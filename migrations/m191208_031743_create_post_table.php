<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m191208_031743_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notnull(),
            'image' => $this->string(),
            'excerpt' => $this->text(),
            'content' => $this->text(),
            'date_created' => $this->datetime(),
            'author' => $this->integer(),
        ]);

        // creates index for column `author`
        $this->createIndex(
            '{{%idx-post-author}}',
            '{{%post}}',
            'author'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-post-author}}',
            '{{%post}}',
            'author',
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
            '{{%fk-post-author}}',
            '{{%post}}'
        );

        // drops index for column `author`
        $this->dropIndex(
            '{{%idx-post-author}}',
            '{{%post}}'
        );

        $this->dropTable('{{%post}}');
    }
}
