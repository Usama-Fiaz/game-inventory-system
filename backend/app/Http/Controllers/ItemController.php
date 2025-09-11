<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Item;
use App\Services\RabbitMQPublisher;

class ItemController extends Controller
{
    protected RabbitMQPublisher $publisher;

    public function __construct(RabbitMQPublisher $publisher)
    {
        $this->publisher = $publisher;
    }

    public function index(): JsonResponse
    {
        $cacheKey = 'items_list';
        $ttlSeconds = 60;

        Log::info('Items list requested', ['cache_key' => $cacheKey]);

        $items = Cache::store('redis')->remember($cacheKey, $ttlSeconds, function () {
            Log::info('Cache miss - fetching from database');
            return Item::orderBy('id')->get();
        });

        Log::info('Items list returned', ['count' => $items->count()]);

        return response()->json($items);
    }

    public function store(Request $request): JsonResponse
    {
        Log::info('Item creation requested', ['data' => $request->all()]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'rarity' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $item = Item::create($data);

        Log::info('Item created successfully', [
            'item_id' => $item->id,
            'name' => $item->name,
            'type' => $item->type,
            'rarity' => $item->rarity,
            'quantity' => $item->quantity
        ]);

        Cache::store('redis')->forget('items_list');

        $this->publisher->publish('item.added', [
            'id' => $item->id, 
            'name' => $item->name,
            'type' => $item->type,
            'rarity' => $item->rarity,
            'quantity' => $item->quantity,
            'created_at' => $item->created_at->toDateTimeString(),
        ]);

        Log::info('RabbitMQ event published', ['event' => 'item.added', 'item_id' => $item->id]);

        return response()->json($item, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        Log::info('Item update requested', ['item_id' => $id, 'data' => $request->all()]);

        $item = Item::findOrFail($id);

        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'type' => ['sometimes', 'string', 'max:255'],
            'rarity' => ['sometimes', 'string', 'max:255'],
            'quantity' => ['sometimes', 'integer', 'min:0'],
        ]);

        $item->fill($data);
        $item->save();

        Log::info('Item updated successfully', [
            'item_id' => $item->id,
            'updated_fields' => array_keys($data)
        ]);

        Cache::store('redis')->forget('items_list');

        return response()->json($item);
    }

    public function destroy($id): JsonResponse
    {
        Log::info('Item deletion requested', ['item_id' => $id]);

        $item = Item::findOrFail($id);

        $payload = [
            'id' => $item->id,
            'name' => $item->name,
            'type' => $item->type,
            'rarity' => $item->rarity,
            'quantity' => $item->quantity,
            'deleted_at' => now()->toDateTimeString(),
        ];

        $item->delete();

        Log::info('Item deleted successfully', [
            'item_id' => $id,
            'name' => $payload['name']
        ]);

        Cache::forget('items_list');

        $this->publisher->publish('item.removed', $payload);

        Log::info('RabbitMQ event published', ['event' => 'item.removed', 'item_id' => $id]);

        return response()->json(['message' => 'Item removed']);
    }

}
