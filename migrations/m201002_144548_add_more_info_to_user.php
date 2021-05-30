<?php

use yii\db\Migration;

/**
 * Class m200915_153024_add_more_info_to_user
 */
class m201002_144548_add_more_info_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this -> addColumn('user', 'age', $this -> integer());
        $this -> addColumn('user', 'sex', $this -> string());
        $this -> addColumn('user', 'city', $this -> string());
        $this -> addColumn('user', 'country', $this -> string());
        $this -> addColumn('user', 'isOwner', $this -> integer());
        $this -> addColumn('user', 'atBanlist', $this -> integer());
        $this -> addColumn('user', 'banlistComment', $this -> text());



    }

    /**
     * {@inheritdoc}
     */




    public function down()
    {
        $this -> dropColumn('user', 'age');
        $this -> dropColumn('user', 'sex');
        $this -> dropColumn('user', 'city');
        $this -> dropColumn('user', 'country');
        $this -> dropColumn('user', 'isOwner');
        $this -> dropColumn('user', 'atBanlist');
        $this -> dropColumn('user', 'banlistComment');
    }

}

