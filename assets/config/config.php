<?php

use Hanafalah\ModuleOrganization\Commands\InstallMakeCommand;

return [
    'namespace' => 'Hanafalah\\ModuleOrganization',
    'app' => [
        'contracts' => [
            //ADD YOUR CONTRACTS HERE
        ]
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts',
        'schema' => 'Schemas',
        'database' => 'Database',
        'data' => 'Data',
        'resource' => 'Resources',
        'migration' => '../assets/database/migrations'
    ],
    'database' => [
        'models' => [
        ]
    ],
    'commands' => [
        InstallMakeCommand::class
    ]
];
