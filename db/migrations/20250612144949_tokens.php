<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Tokens extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up(): void
    {
        if(!$this->hasTable('tokens')){
            $this->table('tokens')
                ->addColumn('usuario_id', 'integer')
                ->addColumn('token', 'string', ['limit' => 512])
                ->addColumn('expiration_time', 'datetime')
                ->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
                ->addForeignKey('usuario_id', 'usuarios', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
                ->create();
        }
    }

    public function down(): void
    {
        if($this->hasTable('tokens')){
            $this->table('tokens')->drop()->save();
        }
    }
}
