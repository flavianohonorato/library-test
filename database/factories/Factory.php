<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory as EloquentFactory;
use Faker\Factory as FakerFactory;

abstract class Factory extends EloquentFactory
{

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return FakerFactory::create('pt_BR');
    }
}
