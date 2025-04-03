<?php

namespace Hanafalah\ModuleOrganization\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleOrganization\Contracts\Data\OrganizationData;
use Hanafalah\ModuleOrganization\Contracts\Schemas as Contracts;
use Illuminate\Database\Eloquent\Model;

class Organization extends PackageManagement implements Contracts\Organization
{
    protected array $__guard   = ['id'];
    protected array $__add     = ['name', 'flag', 'parent_id', 'props'];
    protected string $__entity = 'Organization';
    public static $organization_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'organization',
            'tags'     => ['organization', 'organization-index'],
            'forever'  => true
        ]
    ];

    protected function viewUsingRelation(){
        return [];
    }

    protected function showUsingRelation(){
        return [];
    }

    public function getOrganization(): mixed{
        return static::$organization_model;
    }

    public function prepareShowOrganization(?Model $model = null, ? array $attributes = null): ?Model{
        $attributes ??= \request()->all();

        $model ??= $this->getOrganization();
        if (!isset($model)){
            $id = $attributes['id'] ?? null;
            if (!isset($id)) throw new \Exception('Id not found');
            $model = $this->organization()->with($this->showUsingRelation())->findOrFail($id);
        }else{
            $model->load($this->showUsingRelation());
        }
        return static::$organization_model = $model;
    }

    public function showOrganization(?Model $model = null): array{
        return $this->showEntityResource(function() use ($model){
            $this->prepareShowOrganization($model);
        });
    }

    public function prepareStoreOrganization(OrganizationData $organization_dto): Model{
        $organization = $this->{$this->__entity.'Model'}()->updateOrCreate([
            'id' => $organization_dto->id ?? null
        ],[
            'parent_id' => $organization_dto->parent_id ?? null,
            'name'      => $organization_dto->name,
            'flag'      => $this->__entity
        ]);
        foreach ($organization_dto->props as $key => $value) {
            $organization->{$key} = $value;
        }

        $organization->save();
        return static::$organization_model = $organization;
    }

    public function storeOrganization(?OrganizationData $organization_dto = null): array{
        return $this->transaction(function() use ($organization_dto){
            return $this->showOrganization($this->prepareStoreOrganization($organization_dto ?? $this->requestDTO(OrganizationData::class)));
        });
    }

    private function localAddSuffixCache(mixed $suffix): void{
        $this->addSuffixCache($this->__cache['index'], "organization-index", $suffix);
    }

    public function prepareViewOrganizationList(?array $attributes = null): Collection{
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

    public function viewOrganizationList(): array{
        return $this->viewEntityResource(function() {
            return $this->prepareViewOrganizationList();
        });
    }

    public function organization(mixed $conditionals = []): Builder{
        $this->booting();
        return $this->{$this->__entity.'Model'}()->conditionals($this->mergeCondition($conditionals ?? []))->withParameters()->orderBy('name', 'asc');
    }
}
