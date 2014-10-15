<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 10/6/14
 * Time: 8:54 AM
 */

namespace Setting\Service;

use Application\Service\AbstractService;
use Campaign\Facade\CampaignFacade;
use Setting\Entity\UserCampaign;
use Transaction\Facade\CustomFieldFacade;
use Setting\Entity\CampaignSettings;

class CampaignSettingsService {

    protected $serviceLocator;
    protected $entityManager;
    protected $stickyStreetEntityManager;
    protected $options;

    const USER_CAMPAIGN_ENTITY = 'Setting\Entity\UserCampaign';
    const CAMPAIGN_SETTINGS_ENTITY = 'Setting\Entity\CampaignSettings';

    /**
     * @param $serviceLocator
     */
    function __construct($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $this->entityManager = $this->serviceLocator->get('Doctrine\ORM\EntityManager');
        $this->stickyStreetEntityManager = $this->serviceLocator->get(AbstractService::STICKY_STREET_ENTITY_MANAGER);

        $this->options = array(
            array(
                'name' => 'allow_add',
                'label' => 'Allow add'
            ),
            array(
                'name' => 'allow_redeem',
                'label' => 'Allow redeem'
            ),
            array(
                'name' => 'ask_for_amount',
                'label' => 'Show amount to add'
            ),
            array(
                'name' => 'ask_for_description',
                'label' => 'Show transaction description'
            ),
            array(
                'name' => 'ask_for_email_receipt',
                'label' => 'Show email receipt'
            ),
            array(
                'name' => 'ask_for_points',
                'label' => 'Manually add points'
            ),
            array(
                'name' => 'ask_for_redeem_amount',
                'label' => 'Show amount to redeem'
            )
        );
    }

    /**
     * @return mixed
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * @param mixed $serviceLocator
     */
    public function setServiceLocator($serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * @param $campaignId
     * @return bool
     */
    private function existUserCampaign($campaignId)
    {
        $userCampaign = $this->entityManager->getRepository(self::USER_CAMPAIGN_ENTITY)
                            ->findBy(array('campaign_id' => $campaignId));

        if(count($userCampaign) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $accountId
     */
    private function createUserCampaign($accountId)
    {
        $campaings = CampaignFacade::formatCampaignList(
                    $this->serviceLocator->get('campaignService')->getActiveCampaigns($accountId));

        foreach($campaings as $campaign)
        {
            if(!$this->existUserCampaign($campaign['id']))
            {
                $userCampaign = new UserCampaign();
                $userCampaign->setAccountId($accountId);
                $userCampaign->setCampaignId($campaign['id']);
                $userCampaign->setCampaignName($campaign['name']);

                $this->entityManager->persist($userCampaign);
                $this->entityManager->flush();
            }
        }
    }

    /**
     * @param $campaignId
     * @param $customFieldName
     * @return bool
     */
    private function existCustomFieldCampaignSetting($campaignId, $customFieldName)
    {
        $customFieldCampaignSetting = $this->entityManager->getRepository(self::CAMPAIGN_SETTINGS_ENTITY)
            ->findBy(array('campaign_id' => $campaignId, 'field_name' => $customFieldName));

        if(count($customFieldCampaignSetting) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $accountId
     */
    private function createCampaignSettings($accountId)
    {
        $customTransactionFields = CustomFieldFacade::formatCustomFieldCollection(
                                        $this->getServiceLocator()->get('transactionService')
                                            ->getCustomFields($accountId));

        $customTransactionFields = array_merge($customTransactionFields, $this->options);

        $campaings = CampaignFacade::formatCampaignList(
            $this->serviceLocator->get('campaignService')->getActiveCampaigns($accountId));



        foreach($campaings as $campaign)
        {
            foreach($customTransactionFields as $customTransactionField)
            {
                if(!$this->existCustomFieldCampaignSetting($campaign['id'], $customTransactionField['name']))
                {
                    $campaignSetting = new CampaignSettings();
                    $campaignSetting->setCampaignId($campaign['id']);
                    $campaignSetting->setFieldName($customTransactionField['name']);
                    $campaignSetting->setFieldLabel($customTransactionField['label']);
                    $campaignSetting->setIsActive(1);

                    $this->entityManager->persist($campaignSetting);
                    $this->entityManager->flush();
                }
            }
        }
    }

    /**
     * @param $accountId
     * @return array
     */
    public function getSettingsByCampaign($accountId)
    {

        $this->createUserCampaign($accountId);
        $this->createCampaignSettings($accountId);

        $campaings = CampaignFacade::formatCampaignList(
            $this->serviceLocator->get('campaignService')->getActiveCampaigns($accountId));


        foreach($campaings as $campaign)
        {
            $customFieldCampaignSetting[] = array(
                "campaignId" => $campaign['id'],
                "campaignName" => $campaign['name'],
                "campaignSettings" => $this->entityManager->getRepository(self::CAMPAIGN_SETTINGS_ENTITY)
                    ->findBy(array('campaign_id' => $campaign['id']))
            );
        }

        return $customFieldCampaignSetting;
    }

    /**
     * @param $campaigns
     * @throws \Exception
     */
    public function saveCampaignSettings($campaigns)
    {
        if(!empty($campaigns))
        {
            foreach($campaigns as $campaign)
            {
                foreach($campaign->campaignSettings as $campaignOption)
                {
                    $campaignSettings = $this->entityManager->getRepository(self::CAMPAIGN_SETTINGS_ENTITY)
                        ->findOneBy(array('campaign_id' => $campaign->campaignId, 'field_name' => $campaignOption->fieldName));

                    $campaignSettings->setIsActive($campaignOption->isActive);

                    try{
                        $this->entityManager->persist($campaignSettings);
                        $this->entityManager->flush($campaignSettings);

                    }
                    catch(\Exception $ex)
                    {
                        throw new \Exception($ex);
                    }

                }
            }
        }
    }

} 