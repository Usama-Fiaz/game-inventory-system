<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_items()
    {
        Item::factory()->create(['name' => 'Test Item 1']);
        Item::factory()->create(['name' => 'Test Item 2']);

        $response = $this->getJson('/api/items');

        $response->assertStatus(200)
                ->assertJsonCount(2)
                ->assertJsonFragment(['name' => 'Test Item 1'])
                ->assertJsonFragment(['name' => 'Test Item 2']);
    }

    public function test_can_create_item()
    {
        $itemData = [
            'name' => 'Dragon Sword',
            'type' => 'Weapon',
            'rarity' => 'Legendary',
            'quantity' => 1
        ];

        $response = $this->postJson('/api/items', $itemData);

        $response->assertStatus(201)
                ->assertJsonFragment($itemData);

        $this->assertDatabaseHas('items', $itemData);
    }

    public function test_can_update_item()
    {
        $item = Item::factory()->create(['quantity' => 5]);

        $updateData = ['quantity' => 10];

        $response = $this->putJson("/api/items/{$item->id}", $updateData);

        $response->assertStatus(200)
                ->assertJsonFragment(['quantity' => 10]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'quantity' => 10
        ]);
    }

    public function test_can_delete_item()
    {
        $item = Item::factory()->create();

        $response = $this->deleteJson("/api/items/{$item->id}");

        $response->assertStatus(200)
                ->assertJsonFragment(['message' => 'Item removed']);

        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }

    public function test_validation_requires_name()
    {
        $itemData = [
            'type' => 'Weapon',
            'rarity' => 'Legendary',
            'quantity' => 1
        ];

        $response = $this->postJson('/api/items', $itemData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['name']);
    }

    public function test_validation_requires_positive_quantity()
    {
        $itemData = [
            'name' => 'Test Item',
            'type' => 'Weapon',
            'rarity' => 'Legendary',
            'quantity' => -1
        ];

        $response = $this->postJson('/api/items', $itemData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['quantity']);
    }

    public function test_returns_404_for_nonexistent_item_update()
    {
        $response = $this->putJson('/api/items/999', ['quantity' => 5]);

        $response->assertStatus(404);
    }
}
