<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 10/6/14
 * Time: 10:13 AM
 */

namespace Setting\Facade;


class CampaignSettingsFacade {

    /**
     * @param $campaignSettings
     * @return array
     */
    public function formatCampaignSettings($campaignSettings)
    {
        return array(
            'fieldName' => $campaignSettings->getFieldName(),
            'fieldLabel' => $campaignSettings->getFieldLabel(),
            'isActive' => $campaignSettings->getIsActive()
        );
    }

    /**
     * @param $settingsCollection
     * @return array
     */
    public function formatSettingsCollection($settingsCollection)
    {
        foreach($settingsCollection as $settings)
        {
            $campaignSettings[] = self::formatCampaignSettings($settings);
        }
        return $campaignSettings;
    }

    /**
     * @param $campaignSettingsCollection
     * @return array
     */
    public function formatCampaignSettingsCollection($campaignSettingsCollection)
    {
        foreach($campaignSettingsCollection as $campaignSettings)
        {
            $formattedCampaignSettings[] = array(
                "campaignId" => $campaignSettings["campaignId"],
                "campaignName" => $campaignSettings["campaignName"],
                "campaignSettings" => self::formatSettingsCollection($campaignSettings["campaignSettings"])
            );
        }
        return $formattedCampaignSettings;
    }

} 