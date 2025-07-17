<?php

namespace Hanafalah\ModuleOrganization\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class ModelHasOrganization extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;

    public $incrementing = false;
    public $timestamps = false;
    protected $list = [
        'id', 'organization_id', 'organization_type', 
        'model_id', 'model_type', 'props',
    ];
    public static $__flags_service  = [];

    public function model(){return $this->morphTo();}
    public function organization(){return $this->morphTo();}
}
