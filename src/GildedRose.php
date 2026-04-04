<?php

namespace App;
use App\ItemTypes;

class GildedRose
{
    private $items;
    private $itemTypes = [];

    public function __construct(array $items, array $itemTypes = null)
    {
        $this->items = $items;

        if($itemTypes === NULL) {
            $itemTypes = [
                new ItemTypes\AgedBrieItemTypes,
                new ItemTypes\BackstagePassesItemTypes,
                new ItemTypes\ConjuredItemTypes,
                new ItemTypes\NormalItemTypes,
                new ItemTypes\SulfurasItemTypes,
            ];
        }

        $this->itemTypes = $itemTypes;
    }

    public function getItem($which = null)
    {
        return ($which === null
            ? $this->items
            : $this->items[$which]
        );
    }

    public function nextDay()
    {
        foreach ($this->items as $item) {
            $undeclared = true;
            foreach ($this->itemTypes as $type) {
                if ($type->itemType($item)) {
                    $type->nextDay($item);
                    $undeclared = false;
                }
            }

            if($undeclared) {
                throw new \UnexpectedValueException(
                    sprintf('Item type for %s was not found', $item)
                );
            }
        }
    }
}
