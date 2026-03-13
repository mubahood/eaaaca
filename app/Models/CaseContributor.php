<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseContributor extends Model
{
    use HasFactory;

    //relationship for case_modes
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_model_id');
    }

    //fillables
    protected $fillable = [
        'case_model_id',
        'administrator_id',
        'notified',
    ];
}
