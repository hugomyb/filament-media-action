<?php

namespace Hugomyb\FilamentMediaAction\Tests\Support;

use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    protected $fillable = ['name', 'media_url'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->exists = true;
        $this->id = 1;
    }
}
