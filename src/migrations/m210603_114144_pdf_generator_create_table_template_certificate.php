<?php

use yii\db\Migration;

/**
 * Class m210603_114144_pdf_generator_create_table_certificate
 */
class m210603_114144_pdf_generator_create_table_template_certificate extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pdf_generator_template_certificate}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'title' => $this->string(255),
            'cssInline' => $this->text(),
            'css_files' => $this->text(),
            'content' => $this->text(),
            'width' => $this->integer(),
            'height' => $this->integer(),
            'status' =>$this->tinyInteger()->defaultValue(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pdf_generator_template_certificate}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210603_114144_pdf_generator_create_table_certificate cannot be reverted.\n";

        return false;
    }
    */
}
