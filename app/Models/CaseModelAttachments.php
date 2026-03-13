<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseModelAttachments extends Model
{
    use HasFactory;

    //fillables
    protected $fillable = [
        'case_model_id',
        'administrator_id',
        'name',
        'file'
    ];
    //belongs to case_model
    public function case()
    {
        return $this->belongsTo(CaseModel::class, 'case_model_id');
    }

    //belongs to administrator
    public function administrator()
    {
        return $this->belongsTo(Administrator::class, 'administrator_id');
    }
}
