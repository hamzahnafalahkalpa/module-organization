<?php

namespace Hanafalah\ModuleOrganization\Models;

use Hanafalah\ModuleOrganization\Resources\Organization\{ViewOrganization,ShowOrganization};
use Hanafalah\LaravelSupport\Concerns\Support\HasPhone;
use Hanafalah\LaravelSupport\Models\Unicode\Unicode;
use Hanafalah\ModuleRegional\Concerns\HasAddress;
use Illuminate\Support\Str;

class Organization extends Unicode
{
    use HasAddress, HasPhone;

    protected static function booted(): void{
        parent::booted();
        static::creating(function ($query) {
            $morph = $query->getMorphClass();
            $query->{Str::snake($morph).'_code'} = static::hasEncoding(Str::upper(Str::snake($morph)));
            $query->flag ??= $morph;
        });
    }

    public function viewUsingRelation(): array{
        return $this->mergeArray(['parent'],parent::viewUsingRelation());
    }

    public function showUsingRelation(): array{
        return $this->mergeArray(['parent'],parent::showUsingRelation());
    }

    public function getShowResource(){
        return ShowOrganization::class;
    }

    public function getViewResource(){
        return ViewOrganization::class;
    }

    public function modelHasOrganization(){return $this->morphOneModel('ModelHasOrganization', 'reference');}
}
