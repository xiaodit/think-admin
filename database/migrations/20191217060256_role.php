<?php

use think\migration\Migrator;
use think\migration\db\Column;

/**
 * 角色表
 */
class Role extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('role', array('engine' => 'InnoDB'));
        $table->addColumn('name', 'string', array('limit' => 100, 'comment' => '角色唯一标识'))
            ->addColumn('title', 'string', array('limit' => 100, 'comment' => '角色名称'))
            ->addColumn('status', 'integer', array('limit' => 11, 'default' => 0, 'comment' => '状态'))
            ->addIndex(array('name'), array('unique' => true))
            ->create();
    }
}
