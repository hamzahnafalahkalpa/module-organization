<?php

namespace Hanafalah\ModuleOrganization\Schemas;

use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleOrganization\Contracts\Data\OrganizationData;
use Hanafalah\ModuleOrganization\Contracts\Schemas as Contracts;
use Illuminate\Database\Eloquent\Model;

class Organization extends PackageManagement implements Contracts\Organization
{
    protected string $__entity = 'Organization';
    public static $organization_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'organization',
            'tags'     => ['organization', 'organization-index'],
            'forever'  => true
        ]
    ];

    public function prepareStoreOrganization(OrganizationData $organization_dto): Model{
        $organization = $this->{$this->__entity.'Model'}()->updateOrCreate([
            'id' => $organization_dto->id ?? null
        ],[
            'parent_id' => $organization_dto->parent_id ?? null,
            'name'      => $organization_dto->name,
            'flag'      => $organization_dto->flag ?? $this->__entity
        ]);
        foreach ($organization_dto->props as $key => $value) {
            $organization->{$key} = $value;
        }

        $organization->save();
        return static::$organization_model = $organization;
    }
}
