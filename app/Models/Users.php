<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Users extends Model
{
    protected $table = 'usuarios';
    protected $fillable = ['nome', 'email', 'senha'];
    public $timestamps = true;
    protected $hidden = ['senha'];

    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class, 'usuario_id');
    }
}
