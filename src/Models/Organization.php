<?php

namespace Hanafalah\ModuleOrganization\Models;

use Hanafalah\ModuleOrganization\Resources\ShowOrganization;
use Hanafalah\ModuleOrganization\Resources\ViewOrganization;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelSupport\Models\BaseModel;

class Organization extends BaseModel
{
    use HasProps, SoftDeletes;

    protected $list                 = ["id", "name", "flag", "parent_id", "props"];
    protected $show                 = [];
    public static $__flags_service  = [];
    protected $casts = [
        'name' => 'string'
    ];

    protected $getPropsQuery = [
        'name' => 'name'
    ];

    public function toShowApi()
    {
        return new ShowOrganization($this);
    }

    public function toViewApi()
    {
        return new ViewOrganization($this);
    }

    public function scopeSetIdentityFlags($builder, array $flags)
    {
        self::$__flags_service = $flags;
    }

    public function modelHasOrganization()
    {
        return $this->morphOneModel('ModelHasOrganization', 'reference');
    }
}
