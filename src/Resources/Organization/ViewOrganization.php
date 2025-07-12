<?php

namespace Hanafalah\ModuleOrganization\Resources\Organization;

use Hanafalah\LaravelSupport\Resources\Unicode\ViewUnicode;

class ViewOrganization extends ViewUnicode
{
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $arr = [
      "phone_company" => $this->phone_company,
      "email_company" => $this->email_company
    ];
    $arr = $this->mergeArray(parent::toArray($request),$arr);
    return $arr;
  }
}
