<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    public $timestamps = false;
    protected $table = 'tokens';
    protected $primaryKey = 'id_token';

    protected $fillable = [
        'id_staff',
        'token'
    ];
}