<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_item()
    {
        $item = Item::create([
            'name' => 'Test Item',
            'type' => 'Weapon',
            'rarity' => 'Rare',
            'quantity' => 5
        ]);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals('Test Item', $item->name);
        $this->assertEquals('Weapon', $item->type);
        $this->assertEquals('Rare', $item->rarity);
        $this->assertEquals(5, $item->quantity);
    }

    public function test_quantity_is_cast_to_integer()
    {
        $item = Item::create([
            'name' => 'Test Item',
            'type' => 'Weapon',
            'rarity' => 'Rare',
            'quantity' => '10'
        ]);

        $this->assertIsInt($item->quantity);
        $this->assertEquals(10, $item->quantity);
    }

    public function test_fillable_attributes()
    {
        $item = new Item();
        $fillable = $item->getFillable();

        $this->assertContains('name', $fillable);
        $this->assertContains('type', $fillable);
        $this->assertContains('rarity', $fillable);
        $this->assertContains('quantity', $fillable);
    }
}
