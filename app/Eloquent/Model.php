<?php

namespace App\Eloquent;

use App\Eloquent\Concerns\HasHashId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as IlluminateModel;

abstract class Model extends IlluminateModel
{
    use HasFactory;
    use HasHashId;

    protected $guarded = [];

    public static function table(): string
    {
        return (new static())->getTable();
    }

    public function delete(): ?bool
    {
        return $this->getConnection()->transaction(fn (): ?bool => parent::delete());
    }
}
