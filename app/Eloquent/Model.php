<?php

namespace App\Eloquent;

use App\Eloquent\Concerns\HasHashId;
use BadMethodCallException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as IlluminateModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany as IlluminateBelongsToMany;
use InvalidArgumentException;

abstract class Model extends IlluminateModel
{
    use HasFactory, HasHashId;

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
