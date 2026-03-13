<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MigrationModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'migrations';

    //fillable
    protected $fillable = [
        'migration',
        'batch',
    ];
}
