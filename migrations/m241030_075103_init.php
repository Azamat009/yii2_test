<?php

use yii\db\Migration;

/**
 * Class m241030_075103_init
 */
class m241030_075103_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employee}}', [
            'id' => $this->primaryKey(),
            'first_name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'middle_name' => $this->string()->null()->defaultValue(null),
            'work_days' => $this->integer()->defaultValue(0),
            'part_work_days' => $this->integer()->defaultValue(0),
        ]);

        $this->createTable('{{%language}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(4)->notNull(),
            'name_ru' => $this->string(255)->notNull(),
        ]);

        $this->createTable('{{%employee_language}}', [
            'employee_id' => $this->integer()->notNull()->unsigned(),
            'language_id' => $this->integer()->notNull()->unsigned(),
        ]);

        $this->addForeignKey(
            'fk-el_language_id',
            '{{%employee_language}}',
            'language_id',
            '{{%language}}',
            'id',
            'CASCADE',
            'CASCADE',
        );

        $this->addForeignKey(
            'fk-el_employee_id',
            '{{%employee_language}}',
            'employee_id',
            '{{%employee}}',
            'id',
            'CASCADE',
            'CASCADE',
        );

        $this->createIndex(
            'idx-el',
            '{{%employee_language}}',
            ['employee_id', 'language_id'],
            true,
        );

        $this->createIndex(
            'idx-language-code',
            '{{%language}}',
            'code',
            true,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-el_employee_id', '{{%employee_language}}');
        $this->dropForeignKey('fk-el_language_id', '{{%employee_language}}');
        $this->dropIndex('idx-el', '{{%employee_language}}');
        $this->dropIndex('idx-language-code', '{{%language}}');
        $this->dropTable('{{%employee_language}}');
        $this->dropTable('{{%language}}');
        $this->dropTable('{{%employee}}');
    }
}
