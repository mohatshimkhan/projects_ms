<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class PostFactory extends Factory
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

        $title = $this->faker->name();
        $slug  = Str::slug($title);
        $desc  = $this->faker->text(400);
        $published_at = now();
        
        return [
            "title" => $title,
            "slug"  => $slug,
            "image" => $image,
            "description" => $desc,
            'category_id' => function(){
                return \App\Models\Category::inRandomOrder()->first()->id;
            },
            'user_id' => 1,
            'published_at' => $published_at,
        ];
    }


}