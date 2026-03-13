<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationRequestReponse extends Model
{
    use HasFactory;

    //fillables
    protected $fillable = [
        'description',
        'file',
    ];
    //belongsTo InformationRequest
    public function information_request()
    {
        return $this->belongsTo(InformationRequest::class, 'information_request_id');
    }
}
