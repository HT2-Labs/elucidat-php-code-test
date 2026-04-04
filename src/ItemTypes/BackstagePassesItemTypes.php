<?php
/**
 * Backstage Passes Item Types
 * All items have a SellIn value which denotes the number of days we have to sell the item
 * All items have a Quality value which denotes how valuable the item is
 * At the end of each day our system lowers both values for every item

 * The Quality of an item is never more than 50
 * "Backstage passes", like aged brie, increases in Quality as its SellIn value approaches; 
 * Quality increases by 2 when there are 10 days or less and by 3 when there are 5 days or less but 
 * Quality drops to 0 after the concert
 */

namespace App\ItemTypes;

use App\Item;

class BackstagePassesItemTypes
{
    public function itemType(Item $item): bool {
        return ($item->name == 'Backstage passes to a TAFKAL80ETC concert');
    }

    public function nextDay(Item $item) {
        // Initial values
        $quality = 1;
        $sellIn = -1;

        // If sell in gets closer to concert quality increases
        // After concert, quality is 0
        if ($item->sellIn < 1) { $quality = 0 - $item->quality;
        } elseif ($item->sellIn <= 5) { $quality = 3;
        } elseif ($item->sellIn <= 10) { $quality = 2; }

        // Check quality does not exceed 50
        if($item->quality + $quality >= 50) { $quality = 50 - $item->quality; }

        $item->sellIn = $item->sellIn + $sellIn;
        $item->quality = $item->quality + $quality;
    }
}