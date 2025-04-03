<?php

namespace Hanafalah\ModuleOrganization\Models;

use Hanafalah\ModuleOrganization\Resources\ShowOrganization;
use Hanafalah\ModuleOrganization\Resources\ViewOrganization;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;

class ModelHasOrganization extends BaseModel
{
    use HasProps, SoftDeletes;

    public $timestamps = false;
    public static $__flags_service  = [];
    protected $list                 = ["id", "organization_id", "organization_type", "reference_id", "reference_type"];

    public function scopesetIdentityFlags($builder, array $flags){
        self::$__flags_service = $flags;
    }

    public function getShowResource(){
        return ShowOrganization::class;
    }

    public function getViewResource(){
        return ViewOrganization::class;
    }

    public function reference(){return $this->morphTo();}
    public function organization(){return $this->morphTo();}
}
