<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/19/14
 * Time: 10:37 AM
 */

namespace Campaign\Facade\Item;


class ItemFacace {

    /**
     * @param $item
     * @return array
     */
    public function formatItem($item)
    {
        return array(
            'id' => $item['unique_id'],
            'name' => $item['service_product'],
            'level' => $item['buy_amount']
        );
    }

    /**
     * @param $itemCollection
     * @return array
     */
    public function formatItemCollection($itemCollection)
    {
        if($itemCollection != null)
        {
            foreach($itemCollection as $item)
            {
                $items[] = self::formatItem($item);
            }
            return $items;
        }
        else
        {
            return null;
        }

    }
} 