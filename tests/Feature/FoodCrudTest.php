<?php

namespace Tests\Feature;

use App\Models\Food;
use Tests\TestCase;

class FoodCrudTest extends TestCase
{
    public function test_food_model_can_be_instantiated(): void
    {
        $food = new Food;

        $this->assertInstanceOf(Food::class, $food);
    }
}
