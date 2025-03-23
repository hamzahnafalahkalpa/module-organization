<?php

use Hanafalah\ModuleOrganization\Models as ModuleOrganization;

return [
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts'
    ],
    'database' => [
        'models' => [
            'Organization'         => ModuleOrganization\Organization::class,
            'ModelHasOrganization' => ModuleOrganization\ModelHasOrganization::class,
        ]
    ],
];
