<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class GazlabPermissionsMigration_1784241165
 */
class GazlabPermissionsMigration_1784241165 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('gazlab_permissions', [
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
                        'resource',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 64
                        ]
                    ),
                    new Column(
                        'action',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 64
                        ]
                    ),
                    new Column(
                        'created_at',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "CURRENT_TIMESTAMP",
                            'notNull' => true
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('fk_gazlab_permissions_1_idx', ['profile_id'], null)
                ],
                'references' => [
                    new Reference(
                        'fk_gazlab_permissions_1',
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
        $this->batchInsert('gazlab_permissions', [
                'profile_id',
                'resource',
                'action'
            ]
        );
     }
}
