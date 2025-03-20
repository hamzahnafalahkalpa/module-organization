<?php

namespace Hanafalah\ModuleOrganization;

use Hanafalah\ModuleOrganization\{
    Schemas\Organization as OrganizationSchema,
    Schemas\ModelHasOrganization as ModelHasOrganizationSchema,
    Models\Organization  as OrganizationModel,
    Contracts,
};
use Hanafalah\LaravelSupport\Providers\BaseServiceProvider;

class ModuleOrganizationServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMainClass(ModuleOrganization::class)
            ->registerCommandService(Providers\CommandServiceProvider::class)
            ->registers([
                '*',
                'Services'  => function () {
                    $this->binds([
                        Contracts\ModuleOrganization::class    => OrganizationModel::class,
                        Contracts\Organization::class          => OrganizationSchema::class,
                        Contracts\ModelHasOrganization::class  => ModelHasOrganizationSchema::class,
                    ]);
                },
            ]);
    }

    protected function dir(): string
    {
        return __DIR__ . '/';
    }

    protected function migrationPath(string $path = ''): string
    {
        return database_path($path);
    }
}
