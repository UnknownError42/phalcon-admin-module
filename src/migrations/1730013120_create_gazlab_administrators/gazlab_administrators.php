<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class GazlabAdministratorsMigration_1730013120
 */
class GazlabAdministratorsMigration_1730013120 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('gazlab_administrators', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'autoIncrement' => true
                        ]
                    ),
                    new Column(
                        'profile_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true
                        ]
                    ),
                    new Column(
                        'username',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 64
                        ]
                    ),
                    new Column(
                        'password',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 64
                        ]
                    ),
                    new Column(
                        'avatar',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'size' => 256
                        ]
                    ),
                    new Column(
                        'created_at',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "CURRENT_TIMESTAMP",
                            'notNull' => true
                        ]
                    ),
                    new Column(
                        'updated_at',
                        [
                            'type' => Column::TYPE_DATETIME
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('username_UNIQUE', ['username'], 'UNIQUE'),
                    new Index('fk_gazlab_administrators_1_idx', ['profile_id'], null)
                ],
                'references' => [
                    new Reference(
                        'fk_gazlab_administrators_1',
                        [
                            'referencedTable' => 'gazlab_profiles',
                            'columns' => ['profile_id'],
                            'referencedColumns' => ['id']
                        ]
                    )
                ]
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

    /**
     * This method is called after the table was created
     *
     * @return void
     */
     public function afterCreateTable()
     {
        $this->batchInsert('gazlab_administrators', [
                'profile_id',
                'username',
                'password'
            ]
        );
     }
}
