<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class CustomerFactory extends Factory
{
    public function definition(){

        return [
            'first_name' =>$this->faker->firstName(),
            'last_name'  =>$this->faker->lastName(),
            'email'      =>$this->faker->email(),
            'phone'      =>$this->faker->phoneNumber(),
            'address'    =>$this->faker->address(),
        ];
    }

}
