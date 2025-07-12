<?php

namespace Hanafalah\ModuleOrganization\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Schemas\Unicode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleOrganization\Contracts\Data\OrganizationData;

/**
 * @see \Hanafalah\ModuleOrganization\Schemas\Organization
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array storeOrganization(?OrganizationData $rab_work_list_dto = null)
 * @method bool deleteOrganization()
 * @method bool prepareDeleteOrganization(? array $attributes = null)
 * @method mixed getOrganization()
 * @method ?Model prepareShowOrganization(?Model $model = null, ?array $attributes = null)
 * @method array showOrganization(?Model $model = null)
 * @method array viewOrganizationList()
 * @method Collection prepareViewOrganizationList(? array $attributes = null)
 * @method LengthAwarePaginator prepareViewOrganizationPaginate(PaginateData $paginate_dto)
 * @method array viewOrganizationPaginate(?PaginateData $paginate_dto = null)
 */
interface Organization extends Unicode
{
    public function prepareStoreOrganization(OrganizationData $organization_dto): Model;
    public function organization(mixed $conditionals = null): Builder;
}
