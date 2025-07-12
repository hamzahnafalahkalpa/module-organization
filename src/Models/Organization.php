<?php

namespace Hanafalah\ModuleOrganization\Models;

use Hanafalah\ModuleOrganization\Resources\Organization\{ViewOrganization,ShowOrganization};
use Hanafalah\LaravelSupport\Concerns\Support\HasPhone;
use Hanafalah\LaravelSupport\Models\Unicode\Unicode;
use Hanafalah\ModuleRegional\Concerns\HasAddress;

class Organization extends Unicode
{
    use HasAddress, HasPhone;

    public function viewUsingRelation(): array{
        return $this->mergeArray(['parent'],$this->viewUsingRelation());
    }

    public function showUsingRelation(): array{
        return $this->mergeArray(['parent'],$this->showUsingRelation());
    }

    public function getShowResource(){
        return ShowOrganization::class;
    }

    public function getViewResource(){
        return ViewOrganization::class;
    }

    public function modelHasOrganization(){return $this->morphOneModel('ModelHasOrganization', 'reference');}
}
