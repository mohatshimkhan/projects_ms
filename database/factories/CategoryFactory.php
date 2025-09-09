<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $id = rand(30, 300);
        $image = "https://i.picsum.photos/id/".$id."/640/480.jpg";

        return [
            "title" => $this->faker->name(),
            "slug"  => $this->faker->name(),
            "description" => $this->faker->name(),
            "image" => $image,
        ];
    }
}
