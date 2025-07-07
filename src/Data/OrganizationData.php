<?php

namespace Hanafalah\ModuleOrganization\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleOrganization\Contracts\Data\OrganizationData as DataOrganizationData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class OrganizationData extends Data implements DataOrganizationData{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;
    
    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;
    
    #[MapInputName('flag')]
    #[MapName('flag')]
    public ?string $flag = null;
    
    #[MapInputName('parent_id')]
    #[MapName('parent_id')]
    public mixed $parent_id = null;
    
    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = [];
}