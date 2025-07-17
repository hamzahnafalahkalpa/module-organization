<?php

namespace Hanafalah\ModuleOrganization\Data;

use Hanafalah\LaravelSupport\Concerns\Support\HasRequestData;
use Hanafalah\LaravelSupport\Data\UnicodeData;
use Hanafalah\ModuleOrganization\Contracts\Data\OrganizationData as DataOrganizationData;
use Hanafalah\ModuleRegional\Contracts\Data\AddressData;

class OrganizationData extends UnicodeData implements DataOrganizationData{
    use HasRequestData;

    public static function before(array &$attributes){
        $attributes['flag'] ??= 'Organization';
        parent::before($attributes);
    }

    public static function after(self $data) : self{
        $new = static::new();
        $props = &$data->props;

        if (isset($props['address'])){
            $props['address'] = $new->requestDTO(AddressData::class,$props['address']);
        }

        return $data;
    }
}