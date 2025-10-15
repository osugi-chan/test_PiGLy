<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WeightLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'weight' => $this->faker->randomFloat(1, 45, 80),
            'calories' => $this->faker->numberBetween(1500, 3000),
            'exercise_time' => $this->faker->numberBetween(0, 120),
            'exercise_content' => $this->faker->randomElement([
                'ウォーキング',
                'ジョギング',
                '筋トレ',
                'ヨガ',
                'ストレッチ',
                'ダンス',
                'スイミング',
            ]),
        ];
    }
}
