<?php

namespace App\Modules\Invoicing\Parametric\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Invoicing\Collective\Configuration\GeneralVariables;

class Parametric extends Model
{

    protected $table = 'parametrics';

    protected $primaryKey= 'id';

    protected $fillable = [
       'json_countries',
        'spanish_name',
        'english_name',
        'spanish_description',
        'english_description',
        'state',
        'value',
        'symbol',
        'fk_id_parent',
        'fk_id_auxiliary_parametric'
    ];

    public $timestamps = true;

    use SoftDeletes;

    public function scopeActive(){
        return $this->where('state',1);
    }

    public function parent()
    {
        return $this->belongsTo(Parametric::class, 'fk_id_parent','id');
    }

    public function auxiliarParametric()
    {
        return $this->belongsTo(Parametric::class, 'fk_id_auxiliary_parametric','id');
    }

    public function getNameAttribute()
    {
        if (GeneralVariables::getCurrentLanguage() == 'es') {
            return $this->spanish_name;
        } else {
            return $this->english_name;
        }

    }

    public function getDescriptionAttribute()
    {
        if (GeneralVariables::getCurrentLanguage() == 'es') {
            return $this->spanish_description;
        } else {
            return $this->english_description;
        }

    }

    public function getNameAndAuxiliaryNameAttribute()
    {
        if (GeneralVariables::getCurrentLanguage() == 'es') {
            return $this->spanish_name.' ('.$this->auxiliarParametric->name.')';
        } else {
            return $this->english_name.' ('.$this->auxiliarParametric->name.')';
        }

    }

    public function setSpanishNameAttribute($value)
    {
        $this->attributes['spanish_name'] = strtoupper($value);
    }

    public function setEnglishNameAttribute($value)
    {
        $this->attributes['english_name'] = strtoupper($value);
    }


}
