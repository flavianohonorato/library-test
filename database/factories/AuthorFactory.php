<?php

namespace Database\Factories;

use App\Models\Author;

class AuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Author::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'birthdate' => $this->faker->date(),
            'genre' => $this->faker->randomElement([
                'Ficção científica',
                'Romance',
            ])
        ];
    }
}
