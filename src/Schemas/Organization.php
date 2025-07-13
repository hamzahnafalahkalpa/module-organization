<?php

namespace Hanafalah\ModuleOrganization\Schemas;

use Hanafalah\LaravelSupport\Schemas\Unicode;
use Hanafalah\ModuleOrganization\Contracts\Data\OrganizationData;
use Hanafalah\ModuleOrganization\Contracts\Schemas as Contracts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Organization extends Unicode implements Contracts\Organization
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
        $organization = $this->prepareStoreUnicode($organization_dto);
        return static::$organization_model = $organization;
    }



    public function organization(mixed $conditionals = null): Builder{
        return $this->unicode($conditionals);
    }
}
