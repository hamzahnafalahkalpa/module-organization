<?php

namespace Hanafalah\ModuleOrganization\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleOrganization\Contracts as Contracts;
use Hanafalah\ModuleOrganization\Resources\ShowOrganization;
use Hanafalah\ModuleOrganization\Resources\ViewOrganization;
use Illuminate\Database\Eloquent\Model;

class Organization extends PackageManagement implements Contracts\Organization
{
    protected array $__guard   = ['id'];
    protected array $__add     = ['name', 'flag', 'parent_id', 'props'];
    protected string $__entity = 'Organization';
    public static $organization_model;

    protected array $__resources = [
        'view' => ViewOrganization::class,
        'show' => ShowOrganization::class
    ];

    protected array $__cache = [
        'index' => [
            'name'     => 'organization',
            'tags'     => ['organization', 'organization-index'],
            'forever'  => true
        ]
    ];

    protected function showUsingRelation()
    {
        return [];
    }

    public function prepareShowOrganization(?Model $model = null): ?Model
    {
        $this->booting();

        $model ??= $this->getAgent();
        $id = request()->id;
        if (!request()->has('id')) throw new \Exception('No id provided', 422);

        if (!isset($model)) $model = $this->OrganizationModel()->find($id);
        return static::$organization_model = $model;
    }

    public function showOrganization(?Model $model = null): array
    {
        return $this->transforming($this->__resources['show'], $this->prepareShowOrganization($model));
    }

    public function prepareStoreOrganization(mixed $attributes = null): Model
    {
        $attributes ??= request()->all();
        $organization = $this->OrganizationModel();
        if (isset($attributes['id'])) $organization = $organization->find($attributes['id']);

        $exceptions = [];
        foreach ($attributes as $key => $attribute) {
            if ($this->inArray($key, $exceptions)) continue;
            $organization->{$key} = $attribute;
        }

        $organization->save();
        static::$organization_model = $organization;
        return $organization;
    }

    public function storeOrganization(): array
    {
        return $this->transaction(function () {
            return $this->showOrganization($this->prepareStoreOrganization());
        });
    }

    private function localAddSuffixCache(mixed $suffix): void
    {
        $this->addSuffixCache($this->__cache['index'], "organization-index", $suffix);
    }

    public function prepareViewOrganizationList(?array $attributes = null): Collection
    {
        $attributes ??= request()->all();
        if (isset($attributes['flag'])) {
            $attributes['flag'] = $this->mustArray($attributes['flag']);
            $this->localAddSuffixCache(implode('-', $attributes['flag']));
        }
        return static::$organization_model = $this->cacheWhen(!$this->isSearch(), $this->__cache['index'], function () use ($attributes) {
            return $this->organization()->when(isset($attributes['flag']), function ($query) use ($attributes) {
                $query->flagIn($attributes['flag']);
            })->orderBy('name', 'asc')->get();
        });
    }

    public function viewOrganizationList(): array
    {
        return $this->transforming($this->__resources['view'], function () {
            return $this->prepareViewOrganizationList();
        });
    }

    public function addOrChange(?array $attributes = []): self
    {
        $this->updateOrCreate($attributes);
        return $this;
    }

    public function refind(mixed $id = null): Model|null
    {
        return $this->organization()->where("id", $id ??= request()->id)->first();
    }

    public function get(mixed $conditionals = []): Collection
    {
        return $this->organization()->withParameters()->conditionals($conditionals)->get();
    }

    public function organization(mixed $conditionals = []): Builder
    {
        $this->booting();
        return $this->OrganizationModel()->conditionals($conditionals)->withParameters()->orderBy('name', 'asc');
    }
}
