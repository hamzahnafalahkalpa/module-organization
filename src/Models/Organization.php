<?php

namespace Hanafalah\ModuleOrganization\Models;

use Hanafalah\ModuleOrganization\Resources\Organization\{ViewOrganization,ShowOrganization};
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Concerns\Support\HasPhone;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleRegional\Concerns\HasAddress;

class Organization extends BaseModel
{
    use HasProps, SoftDeletes, HasAddress, HasPhone;

    protected $list                 = ["id", "parent_id", "name", "flag", "props"];
    protected $show                 = [];
    public static $__flags_service  = [];
    protected $casts = [
        'name' => 'string'
    ];

    protected $getPropsQuery = [
        'name' => 'name'
    ];

    protected static function booted(): void{
        parent::booted();
        static::addGlobalScope('flag',function($query){
            //DIKOSONGKAN SEBAGAI TEMPLATE
        });
    }

    public function viewUsingRelation(): array{
        return ['parent'];
    }

    public function showUsingRelation(): array{
        return ['parent'];
    }

    public function getShowResource(){
        return ShowOrganization::class;
    }

    public function getViewResource(){
        return ViewOrganization::class;
    }

    public function scopeSetIdentityFlags($builder, array $flags){
        self::$__flags_service = $flags;
    }

    public function modelHasOrganization(){return $this->morphOneModel('ModelHasOrganization', 'reference');}
}
