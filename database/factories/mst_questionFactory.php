<?php

namespace Database\Factories;

use App\Models\mst_question;
use Illuminate\Database\Eloquent\Factories\Factory;

class mst_questionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = mst_question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'questionname' => $this->faker->paragraph,
            'opt1' => $this->faker->realText(30),
            'opt2' => $this->faker->realText(30),
            'opt3' => $this->faker->realText(30),
            'opt4' => $this->faker->realText(30),
            'opt5' => $this->faker->realText(30),
        ];
    }
}
