<?php
namespace Process\Entity;

use Process\Model\Step;

use User\Model\User;

class StepEntity
{
	public function updateStepComputations($objStep, $arrStepResources)
	{
		$objStep->turnaroundTime = 0;
		$objStep->costPerHour = 0;
		$objStep->costPerStep = 0;
		$objStep->dailyRate = 0;
		$objStep->costInPesos = 0;
		$objStep->margin = 0;
		$objStep->totalInPhp = 0;
		$objStep->totalInDollars = 0;
		
		foreach ($arrStepResources as $objStepResource) {
			$objStep->turnaroundTime += $objStepResource->daysNeeded;
			$objStep->costPerHour += $objStepResource->hourlyRate;
			$objStep->costPerStep += $objStepResource->costInPHP;
			$objStep->dailyRate += $objStepResource->dailyRate;
			$objStep->costInPesos += $objStepResource->costInPHP;
			$objStep->margin += $objStepResource->costMargin;
			$objStep->totalInPhp += $objStepResource->totalBillingPHP;
			$objStep->totalInDollars += $objStepResource->totalBillingUSD;			
		}
		
		return $objStep;
	}
	
	public function mapStepResource(User $objUser) 
	{
		$arrData = array();
		
		$arrData['userId'] = $objUser->user_id;
		$arrData['resourceId'] = $objUser->resourceId;
		$arrData['basicSalary'] = $objUser->basicSalary;
		$arrData['deMinimis'] = $objUser->deMinimis;
		$arrData['transportAllowance'] = $objUser->transportAllowance;
		$arrData['mealAllowance'] = $objUser->mealAllowance;
		$arrData['nightDifferential'] = $objUser->nightDifferential;
		$arrData['overtimeAndHolidayPay'] = $objUser->overtimeAndHolidayPay;
		$arrData['nthMonthPay'] = $objUser->nthMonthPay;
		$arrData['sssContribution'] = $objUser->sssContribution;
		$arrData['eccContribution'] = $objUser->eccContribution;
		$arrData['phicContribution'] = $objUser->phicContribution;
		$arrData['hmdfContribution'] = $objUser->hmdfContribution;
		$arrData['medicare'] = $objUser->medicare;
		$arrData['pamperDayBenefit'] = $objUser->pamperDayBenefit;
		$arrData['programsAndEvents'] = $objUser->programsAndEvents;
		$arrData['equipmentAndFurniture'] = $objUser->equipmentAndFurniture;
		$arrData['softwareAndRelated'] = $objUser->softwareAndRelated;
		$arrData['bandwidth'] = $objUser->bandwidth;
		$arrData['rentAndUtilities'] = $objUser->rentAndUtilities;
		$arrData['suppliesAndSharedServices'] = $objUser->suppliesAndSharedServices;
		
		return $arrData;
	}
	
	public function mapStepResourceToSalary($objSalaryGrade)
	{
		$arrData = array();

		$arrData['basicSalary'] = $objSalaryGrade->salaryMaximum;
		$arrData['deMinimis'] = $objSalaryGrade->variableAllowance;
		$arrData['transportAllowance'] = $objSalaryGrade->transportationAllowance;
		$arrData['mealAllowance'] = $objSalaryGrade->mealAllowance;
		$arrData['nightDifferential'] = $objSalaryGrade->nightDifferential;
		$arrData['overtimeAndHolidayPay'] = $objSalaryGrade->overtimeHolidayPremium;
		$arrData['sssContribution'] = 0;
		$arrData['eccContribution'] = 0;
		$arrData['phicContribution'] = 0;
		$arrData['hmdfContribution'] = 0;
		$arrData['medicare'] = 0;
		$arrData['pamperDayBenefit'] = 0;
		$arrData['programsAndEvents'] = 0;
		$arrData['equipmentAndFurniture'] = 0;
		$arrData['softwareAndRelated'] = 0;
		$arrData['bandwidth'] = 0;
		$arrData['rentAndUtilities'] = 0;
		$arrData['suppliesAndSharedServices'] = 0;
		
		if($objSalaryGrade->monthPay == 1) {
			$arrData['nthMonthPay'] = round(($objSalaryGrade->salaryMaximum/12),2);
		} else {
			$arrData['nthMonthPay'] = 0;
		}

		return $arrData;		
	}
	
	public function computeTotalBenefitsInitial($arrData)
	{
		$fltTotalBenefits = 0;
		
		$fltTotalBenefits += $arrData['nightDifferential'];
		$fltTotalBenefits += $arrData['overtimeAndHolidayPay'];
		$fltTotalBenefits += $arrData['nthMonthPay'];
		$fltTotalBenefits += $arrData['sssContribution'];
		$fltTotalBenefits += $arrData['eccContribution'];
		$fltTotalBenefits += $arrData['phicContribution'];
		$fltTotalBenefits += $arrData['hmdfContribution'];
		$fltTotalBenefits += $arrData['medicare'];
		$fltTotalBenefits += $arrData['pamperDayBenefit'];
		$fltTotalBenefits += $arrData['pamperDayBenefit'];
		$fltTotalBenefits += $arrData['programsAndEvents'];
		
		return $fltTotalBenefits;
	}
	
	public function computeTaxOnAllowance($arrData)
	{
		$fltTaxOnAllowance = 0;
		
		$fltTaxOnAllowance += $arrData['deMinimis'];
		$fltTaxOnAllowance += $arrData['transportAllowance'];
		$fltTaxOnAllowance += $arrData['mealAllowance'];
		$fltTaxOnAllowance += $arrData['overtimeAndHolidayPay'];
		
		$fltTaxOnAllowanceTotal = round((($fltTaxOnAllowance)/0.68)*0.32, 2);
		
		return $fltTaxOnAllowanceTotal;
	}
	
	public function computeTotalBenefits($fltTotalBenefitsInitial, $fltTaxOnAllowance)
	{
		$fltTotalBenefits = round($fltTotalBenefitsInitial + $fltTaxOnAllowance, 2);
		
		return $fltTotalBenefits;
	}
	
	public function computeManpowerCost($arrData, $fltTotalBenefits)
	{
		$fltTotalManpowerCost = 0;
		
		$fltTotalManpowerCost += $arrData['basicSalary'];
		$fltTotalManpowerCost += $arrData['deMinimis'];
		$fltTotalManpowerCost += $arrData['transportAllowance'];
		$fltTotalManpowerCost += $arrData['mealAllowance'];
		$fltTotalManpowerCost += $arrData['nightDifferential'];
		
		$fltTotalManpowerCost += $fltTotalBenefits;
		
		return $fltTotalManpowerCost;
	}
	
	public function computeTotalSGACost($arrData)
	{
		$fltTotalSGACost = 0;
		
		$fltTotalSGACost += $arrData['equipmentAndFurniture'];
		$fltTotalSGACost += $arrData['softwareAndRelated'];
		$fltTotalSGACost += $arrData['bandwidth'];
		$fltTotalSGACost += $arrData['rentAndUtilities'];
		$fltTotalSGACost += $arrData['suppliesAndSharedServices'];
		
		return $fltTotalSGACost;
	}
	
	public function computeMonthlyRate($fltTotalManpowerCost, $fltTotalSGACost)
	{
		$fltMonthlyRate = 0;
		
		$fltMonthlyRate = $fltTotalManpowerCost + $fltTotalSGACost;
		
		return $fltMonthlyRate;
	}
}