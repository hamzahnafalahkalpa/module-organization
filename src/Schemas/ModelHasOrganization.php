<?php

namespace Hanafalah\ModuleOrganization\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Hanafalah\LaravelFeature\Supports\BaseLaravelFeature;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleOrganization\Contracts as Contracts;
use Hanafalah\ModulePatient\Enums\VisitRegistration\RegistrationStatus;

class ModelHasOrganization extends PackageManagement implements Contracts\ModelHasOrganization
{
    protected array $__guard   = ['id'];
    protected array $__add     = ['name', 'flag', 'parent_id'];
    protected string $__entity = 'ModelHasOrganization';

    public function booting(): self
    {
        static::$__class = $this;
        static::$__model = $this->{$this->__entity . "Model"}();
        return $this;
    }


    public function addOrChange(?array $attributes = []): self
    {
        $this->updateOrCreate($attributes);
        return $this;
    }

    public function preapreStoreModelHasOrganization(?array $attributes = null)
    {
        $attributes ??= request()->all();

        if (isset($attributes['visit_registration_id'])) {
            $visit_registration = $this->VisitRegistrationModel()->with("visitPatient")->find($attributes['visit_registration']);
            $visit_patient      = $visit_registration->visit_patient;

            if ($visit_registration->status != RegistrationStatus::DRAFT->value) throw new \Exception("visit registration status not draft");
        }

        if (!isset($visit_patient)) throw new \Exception("visit patient not found");

        if (isset($attributes['agent_id'])) {
            $visit_patient->modelHasOrganization()->updateOrCreate([
                'reference_id'       => $visit_patient->getKey(),
                'reference_type'     => $visit_patient->getMorphClass(),
                'organization_type'  => $this->AgentModel()->getMorphClass()
            ], [
                'organization_id'    => $attributes['agent_id'],
            ]);
            $agent = $this->AgentModel()->findOrFail($attributes['agent_id']);
            $visit_patient->sync($agent, ['id', 'name']);
        }

        if (isset($attributes['payer_id']) || isset(request()->payer_id)) {
            $payer_id = $attributes['payer_id'] ?? request()->payer_id;
            $visit_patient->modelHasOrganization()->updateOrCreate([
                'reference_id'       => $visit_patient->getKey(),
                'reference_type'     => $visit_patient->getMorphClass(),
                'organization_type'  => $this->PayerModel()->getMorphClass()
            ], [
                'organization_id'    => $payer_id
            ]);

            $payer   = $this->PayerModel()->findOrFail($payer_id);
            $visit_patient->sync($payer, ['id', 'name']);
        }
    }

    public function get(mixed $conditionals = []): Collection
    {
        return $this->modelHasOrganization()->conditionals($conditionals)->get();
    }

    public function modelHasOrganization(mixed $conditionals = []): Builder
    {
        return $this->getModel()->conditionals($conditionals);
    }
}
