<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string,mixed>
    */
    public function definition():array
    {
        return[
            'titulo' => $this -> faker ->sentence(5),
            'descripcion' => $this -> faker ->sentence(20),
            'imagen' =>$this -> faker ->uuid().'.jpg',
            'user_id' =>$this -> faker ->randomElement([14, 15, 16, 17]),
        ];
    }
}
