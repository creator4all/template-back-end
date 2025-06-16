<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Users extends AbstractMigration
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
        if (!$this->hasTable('usuarios')) {
            $this->table('usuarios')
                ->addColumn('nome', 'string', ['limit' => 100])
                ->addColumn('email', 'string', ['limit' => 150])
                ->addColumn('senha', 'string', ['limit' => 255])
                ->addTimestamps() // adds created_at and updated_at
                ->addIndex(['email'], ['unique' => true])
                ->create();
        }
    }
    
    public function down(): void
    {
        if ($this->hasTable('usuarios')) {
            $this->table('usuarios')->drop()->save();
        }
    }
}
