<?php

namespace Hanafalah\ModuleOrganization\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleOrganization\Contracts\Data\OrganizationData;

interface Organization extends DataManagement
{
    public function getOrganization(): mixed;
    public function prepareShowOrganization(?Model $model = null, ? array $attributes = null): ?Model;
    public function showOrganization(?Model $model = null): array;
    public function prepareStoreOrganization(OrganizationData $organization_dto): Model;
    public function storeOrganization(?OrganizationData $organization_dto = null): array;
    public function prepareViewOrganizationList(?array $attributes = null): Collection;
    public function viewOrganizationList(): array;
    public function organization(mixed $conditionals = []): Builder;   
}
