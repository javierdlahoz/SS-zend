<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/18/14
 * Time: 3:57 PM
 */

namespace Campaign\Facade\Reward;


interface IRewardsFacade {

    public function formatReward($reward);

    public function formatRewardCollection($rewardCollection);
} 