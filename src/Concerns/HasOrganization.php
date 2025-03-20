<?php

namespace Hanafalah\ModuleOrganization\Concerns;

trait HasOrganization
{
    public function initialieHasOrganization()
    {
        $this->OrganizationModel()::setIdentityFlags($this->__flags_Service);
    }
}
