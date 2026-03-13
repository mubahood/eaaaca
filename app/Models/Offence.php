<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offence extends Model
{
    use HasFactory;
    protected $table = 'nature_of_offences';

    public static function list()
    {
        $cases = Offence::all();
        $casesArray = [];
        foreach ($cases as $case) {
            $casesArray[$case->id] = $case->name;
        }
        return $casesArray;
    }
}
