<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
    return [
        'name' => $this->faker->sentence,
        'desc' => $this->faker->paragraph,
        'id_user' => User::factory(),
    ];
}
     
}



