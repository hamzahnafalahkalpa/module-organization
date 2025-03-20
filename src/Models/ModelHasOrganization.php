<?php

namespace Gii\ModuleOrganization\Models;

use Gii\ModuleOrganization\Resources\ShowOrganization;
use Gii\ModuleOrganization\Resources\ViewOrganization;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zahzah\LaravelHasProps\Concerns\HasCurrent;
use Zahzah\LaravelHasProps\Concerns\HasProps;
use Zahzah\LaravelSupport\Models\BaseModel;

class ModelHasOrganization extends BaseModel {
    use HasProps, SoftDeletes;

    protected $list                 = ["id","organization_id","organization_type","reference_id", "reference_type"];
    public static $__flags_service  = [];
    public $timestamps = false;
    public $current_conditions = [
        'organization_id', "organization_type", 'reference_id', 'reference_type'
    ];


    public function scopesetIdentityFlags($builder,array $flags){
        self::$__flags_service = $flags;
    }

    public function toShowApi(){
        return new ShowOrganization($this);
    }

    public function toViewApi(){
        return new ViewOrganization($this);
    }

    //EIGER SECTION

    //END EIGER SECTION
    public function reference(){return $this->morphTo(__FUNCTION__,"reference_type","reference_id");}
    // public function organization(){return $this->belongsTo(Organization::class,"organization_id","id");}
    public function organization(){return $this->morphTo();}
}

