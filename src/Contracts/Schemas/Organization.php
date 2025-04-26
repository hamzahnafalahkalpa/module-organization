<?php

namespace Hanafalah\ModuleOrganization\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleOrganization\Contracts\Data\OrganizationData;

/**
 * @see \Hanafalah\ModuleOrganization\Schemas\Organization
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
 * @method Builder function organization(mixed $conditionals = null)
 */
interface Organization extends DataManagement
{
    public function prepareStoreOrganization(OrganizationData $organization_dto): Model;
}
