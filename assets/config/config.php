<?php

use Hanafalah\ModuleOrganization\Models as ModuleOrganization;

return [
    'database' => [
        'models' => [
            'Organization'         => ModuleOrganization\Organization::class,
            'ModelHasOrganization' => ModuleOrganization\ModelHasOrganization::class,
        ]
    ],
];
