<?php

namespace Hanafalah\ModuleOrganization\Resources\Organization;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewOrganization extends ApiResource
{
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $arr = [
      'id'            => $this->id,
      'name'          => $this->name,
      "flag"          => $this->flag,
      "phone_company" => $this->phone_company,
      "email_company" => $this->email_company,
      'created_at'    => $this->created_at,
      'updated_at'    => $this->updated_at
    ];
    return $arr;
  }
}
