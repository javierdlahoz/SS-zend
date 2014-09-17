<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/15/14
 * Time: 3:40 PM
 */

namespace Campaign\Facade\Promotion;


class PromotionFacade {

    public function formatPromotion($promotion)
    {
        return array(
            'id' => $promotion->getId(),
            'multiplier' => $promotion->getMultiplier(),
            'operation' => $promotion->getOperation(),
            'description' => $promotion->getPromotion(),
            'startDate' => $promotion->getPromoStartDate(),
            'endDate' => $promotion->getPromoEndDate()
        );
    }

    public function formatPromotionCollection($promotionCollection)
    {
        foreach($promotionCollection as $promotion)
        {
            $promotions[] = self::formatPromotion($promotion);
        }

        return $promotions;
    }
} 