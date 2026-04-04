<?php
/**
 * Normal Item Types
 * All items have a SellIn value which denotes the number of days we have to sell the item
 * All items have a Quality value which denotes how valuable the item is
 * At the end of each day our system lowers both values for every item

 * Once the sell by date has passed, Quality degrades twice as fast
 * The Quality of an item is never negative
 * The Quality of an item is never more than 50
 */

namespace App\ItemTypes;

use App\Item;

class NormalItemTypes
{
    public function itemType(Item $item): bool {
        return ($item->name == 'normal');
    }

    public function nextDay(Item $item) {
        // initial values
        $quality = -1;
        $sellIn = -1;

        $item->sellIn = $item->sellIn + $sellIn;
        if($item->sellIn < 1) { $quality = -2; }

        // Check if quality will drop below 0
        if($item->quality + $quality < 0) { $item->quality = abs($quality); }
        $item->quality = $item->quality + $quality;
    }
}