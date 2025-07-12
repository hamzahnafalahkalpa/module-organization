<?php

namespace Hanafalah\ModuleOrganization\Data;

use Hanafalah\LaravelSupport\Data\UnicodeData;
use Hanafalah\ModuleOrganization\Contracts\Data\OrganizationData as DataOrganizationData;

class OrganizationData extends UnicodeData implements DataOrganizationData{
    public static function before(array &$attributes){
        $attributes['flag'] ??= 'Organization';
        parent::before($attributes);
    }
}