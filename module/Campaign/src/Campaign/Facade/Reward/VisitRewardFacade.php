<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/18/14
 * Time: 3:57 PM
 */

namespace Campaign\Facade\Reward;

use Campaign\Facade\Reward\IRewardsFacade;

class VisitRewardFacade implements IRewardsFacade{

    public function formatReward($reward)
    {
        return array(
            'id' => $reward['reward_id'],
            'description' => $reward['reward_description'],
            'level' => $reward['number_visits']
        );
    }

    public function formatRewardCollection($rewardCollection)
    {
        foreach($rewardCollection as $reward)
        {
            $rewards[] = self::formatReward($reward);
        }

        return $rewards;
    }
} 