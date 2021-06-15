<?php

use yii\db\Migration;


class m210609_155026_pdf_generator_create_table_certificate extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pdf_generator_certificate}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'template_certificate_id' => $this->integer(),
            'token' => $this->string(255),
            'visited_at' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pdf_generator_certificate}');
    }


}
