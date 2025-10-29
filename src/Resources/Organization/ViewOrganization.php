<?php

namespace Hanafalah\ModuleOrganization\Resources\Organization;

use Hanafalah\LaravelSupport\Resources\Unicode\ViewUnicode;
use Illuminate\Support\Str;

class ViewOrganization extends ViewUnicode
{
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $code = Str::snake($this->flag)."_code";
    $arr = [
      'id'        => $this->id,
      'parent_id' => $this->parent_id,
      'name'      => $this->name,
      'flag'      => $this->flag,
      'label'     => $this->label,
      $code => $this->{$code},
      "phone_company" => $this->phone_company,
      "email_company" => $this->email_company
    ];
    return $arr;
  }
}
