<?php
/**
 * Sulfuras Item Types
 * "Sulfuras", being a legendary item, never has to be sold or decreases in Quality
 */

namespace App\ItemTypes;

use App\Item;

class SulfurasItemTypes
{
    public function itemType(Item $item): bool {
        return ($item->name == 'Sulfuras, Hand of Ragnaros');
    }

    public function nextDay(Item $item) {
        // Nothing to see here! Although it something changes..
        return true;
    }
}