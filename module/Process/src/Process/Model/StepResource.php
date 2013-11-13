<?php
namespace Process\Model;

class StepResource
{
    public $stepResourceId;
    public $stepId;
    public $resourceId;
    public $userId;
    public $basicSalary;
    public $deMinimis;
    public $transportAllowance;
    public $mealAllowance;
    public $nightDifferential;
    public $overtimeAndHolidayPay;
    public $nthMonthPay;
    public $sssContribution;
    public $eccContribution;
    public $phicContribution;
    public $hmdfContribution;
    public $medicare;
    public $pamperDayBenefit;
    public $programsAndEvents;
    public $equipmentAndFurniture;
    public $softwareAndRelated;
    public $bandwidth;
    public $rentAndUtilities;
    public $suppliesAndSharedServices;
    public $daysNeeded;
    public $totalBenefitsInitial;
    public $taxOnAllowance;
    public $totalBenefits;
    public $totalManpowerCost;
    public $totalSGACost;
    public $monthlyRate;
    public $dailyRate;
    public $hourlyRate;
    public $costInPHP;
    public $totalBillingPHP;
    public $costMargin;
    public $totalBillingUSD;

    public function exchangeArray($data)
    {
        $arrClassVars = get_class_vars(__CLASS__);
    	
    	foreach ($arrClassVars as $strKey => $strValue) {
    		$this->$strKey  = (isset($data[$strKey])) ? $data[$strKey] : 0;

    	}
    }
    
    public function getArrayCopy()
    {
    	return get_object_vars($this);
    }
    
    private function _inputFilter($field) {
    	
    }
}