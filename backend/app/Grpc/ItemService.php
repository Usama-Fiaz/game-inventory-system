<?php

namespace App\Grpc;

use App\Models\Item;
use Inventory\ItemRequest;
use Inventory\ItemResponse;

class ItemService
{
    public function GetItemById(ItemRequest $request): ItemResponse
    {
        $item = Item::find($request->getId());

        $response = new ItemResponse();

        if ($item) {
            $response->setId($item->id);
            $response->setName($item->name);
            $response->setType($item->type);
            $response->setRarity($item->rarity);
            $response->setQuantity($item->quantity);
        } else {
            $response->setId(0);
            $response->setName('');
            $response->setType('');
            $response->setRarity('');
            $response->setQuantity(0);
        }

        return $response;
    }
}
