<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseModelFinding extends Model
{
    use HasFactory;

    //fillables
    protected $fillable = [
        'case_model_id',
        'administrator_id',
        'title',
        'details',
    ];

    //belongs to case_model
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_model_id');
    }
}
