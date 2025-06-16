<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Tokens extends Model
{
    protected $table = 'tokens';
    protected $fillable = ['usuario_id', 'token', 'expiration_time'];
    public $timestamps = true;
    protected $dates = ['expiration_time'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Users::class, 'usuario_id');
    }
}

