<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/18/14
 * Time: 3:57 PM
 */

namespace Campaign\Facade\Reward;

class PointRewardFacade implements IRewardsFacade{

    public function formatReward($reward)
    {
        return array(
            'id' => $reward['unique_id'],
            'description' => $reward['reward_description'],
            'level' => $reward['dollars_accumulated']
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