<?php
/**
 * Conjured Item Types
 * All items have a SellIn value which denotes the number of days we have to sell the item
 * All items have a Quality value which denotes how valuable the item is
 * At the end of each day our system lowers both values for every item

 * Once the sell by date has passed, Quality degrades twice as fast
 * The Quality of an item is never negative
 * The Quality of an item is never more than 50

 * "Conjured" items degrade in Quality twice as fast as normal items
 */

namespace App\ItemTypes;

use App\Item;

class ConjuredItemTypes
{
    public function itemType(Item $item): bool {
        return ($item->name == 'Conjured Mana Cake');
    }

    public function nextDay(Item $item) {
        // Initial values
        $quality = -2;
        $sellIn = -1;

        $item->sellIn = $item->sellIn + $sellIn;
        if($item->sellIn < 1) { $quality = -4; }

        // Check quality does not drop below 0
        if($item->quality + $quality < 0) { $item->quality = abs($quality); }
        $item->quality = $item->quality + $quality;
    }
}