<?php

use yii\db\Migration;

/**
 * Class m200711_171807_add_date_to_comment
 */
class m200711_171807_add_date_to_comment extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this -> addColumn('comment', 'date', $this -> date());
    }

    /**
     * {@inheritdoc}
     */



    public function down()
    {
       $this -> dropColumn('comment', 'data');
    }

}
