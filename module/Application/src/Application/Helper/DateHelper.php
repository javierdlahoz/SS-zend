<?php
/**
 * Created by PhpStorm.
 * User: jdelahoz1
 * Date: 9/8/14
 * Time: 2:55 PM
 */

namespace Application\Helper;

class DateHelper
{
    private $startDate;
    private $endDate;

    function __construct()
    {
        $today = getdate();

        $this->startDate = $today['year']."-".$today['mon']."-01";
        $this->endDate = $today['year']."-".$today['mon']."-31";
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }



}