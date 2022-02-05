<?php

namespace Database\Factories;

use App\Enums\Language;
use App\Enums\License;
use App\Models\Repository;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepositoryFactory extends Factory
{
    protected $model = Repository::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique->randomNumber(8),
            'name' => $this->faker->userName . '/' . $this->faker->unique->slug(3),
            'license' => $this->faker->randomEnum(License::class),
            'language' => $this->faker->randomEnum(Language::class),
            'stargazers_count' => $this->faker->numberBetween(0, 25_100),
        ];
    }

    public function configure(): self
    {
        return $this->for(User::factory(), 'owner');
    }
}
