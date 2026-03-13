<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseModel extends Model
{
    use HasFactory;


    //boot
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($m) {
            $u = Administrator::find($m->administrator_id);
            if ($u == null) {
                throw new \Exception("Owner not found");
            }
            $m->country_id = $u->country_id; 
            return $m;
        });
        static::updating(function ($m) {
        });
        static::deleting(function ($m) {
            //delete all attachments
            $attachments = CaseModelAttachments::where('case_model_id', $m->id)->get();
            foreach ($attachments as $attachment) {
                $attachment->delete();
            }
            //delete all findings
            $findings = CaseModelFinding::where('case_model_id', $m->id)->get();
            foreach ($findings as $finding) {
                $finding->delete();
            }
            //delete all contributors
            $contributors = CaseContributor::where('case_model_id', $m->id)->get();
            foreach ($contributors as $contributor) {
                $contributor->delete();
            }
            
        });
    }

    //cases to array for select dropdown
    public static function casesToArray()
    {
        $cases = CaseModel::all();
        $casesArray = [];
        foreach ($cases as $case) {
            $casesArray[$case->id] = $case->title;
        }
        return $casesArray;
    }

    //has many CaseContributor
    public function contributors()
    {
        return $this->hasMany(CaseContributor::class);
    }
    //has many CaseModelAttachment
    public function attachments()
    {
        return $this->hasMany(CaseModelAttachments::class);
    }

    //has many CaseModelFinding
    public function findings()
    {
        return $this->hasMany(CaseModelFinding::class);
    }

    //owner
    public function owner()
    {
        return $this->belongsTo(Administrator::class, 'administrator_id');
    }

    //country
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
