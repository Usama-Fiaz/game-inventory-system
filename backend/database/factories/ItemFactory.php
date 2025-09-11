<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary'];
        $types = ['Weapon', 'Armor', 'Accessory', 'Consumable', 'Material'];

        return [
            'name' => $this->faker->words(2, true),
            'type' => $this->faker->randomElement($types),
            'rarity' => $this->faker->randomElement($rarities),
            'quantity' => $this->faker->numberBetween(1, 100),
        ];
    }
}
