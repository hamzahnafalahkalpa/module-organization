<?php

namespace Hanafalah\ModuleOrganization\Resources\Organization;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ShowOrganization extends ViewOrganization
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $resquest
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $arr = [
      "phone_owner"   => $this->phone_owner,
      "address"       => $this->address,
      "name_owner"    => $this->name_owner,
    ];
    $arr = $this->mergeArray(parent::toArray($request), $arr);

    return $arr;
  }
}
