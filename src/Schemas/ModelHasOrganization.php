<?php

namespace Hanafalah\ModuleOrganization\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleOrganization\Contracts\Data\ModelHasOrganizationData;
use Hanafalah\ModuleOrganization\Contracts\Schemas as Contracts;

class ModelHasOrganization extends PackageManagement implements Contracts\ModelHasOrganization
{
    protected string $__entity = 'ModelHasOrganization';
    public $model_has_organization_model = null;

    public function preapreStoreModelHasOrganization(ModelHasOrganizationData $has_organization_dto){
        $model = $this->modelHasOrganization()->updateOrCreate([
            'organization_id'   => $has_organization_dto->organization_id,
            'organization_type' => $has_organization_dto->organization_type,
            'reference_id'      => $has_organization_dto->reference_id,
            'reference_type'    => $has_organization_dto->reference_type,
        ]);
        return $this->model_has_organization_model = $model;
    }

    public function modelHasOrganization(mixed $conditionals = []): Builder{
        $this->booting();
        return $this->ModelHasOrganizationModel()->conditionals($this->mergeCondition($conditionals ?? []));
    }
}
