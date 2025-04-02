<?php

namespace Hanafalah\ModuleOrganization\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;

interface Organization extends DataManagement
{
    public function prepareShowOrganization(?Model $model = null): ?Model;
    public function showOrganization(?Model $model = null): array;
    public function prepareStoreOrganization(mixed $attributes = null): Model;
    public function storeOrganization(): array;
    public function prepareViewOrganizationList(?array $attributes = null): Collection;
    public function viewOrganizationList(): array;
    public function addOrChange(?array $attributes = []): self;
    public function refind(mixed $id = null): Model|null;
    public function get(mixed $conditionals = []): Collection;
    public function organization(mixed $conditionals = []): Builder;
}
