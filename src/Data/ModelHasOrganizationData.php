<?php

namespace Hanafalah\ModuleOrganization\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleOrganization\Contracts\Data\ModelHasOrganizationData as DataModelHasOrganizationData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class ModelHasOrganizationData extends Data implements DataModelHasOrganizationData{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;
    
    #[MapInputName('reference_type')]
    #[MapName('reference_type')]
    public string $reference_type;
    
    #[MapInputName('reference_id')]
    #[MapName('reference_id')]
    public mixed $reference_id;

    #[MapInputName('organization_type')]
    #[MapName('organization_type')]
    public string $organization_type;

    #[MapInputName('organization_id')]
    #[MapName('organization_id')]
    public mixed $organization_id;
}