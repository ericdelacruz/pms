<?php
namespace Process\Entity;

class ProcessEntity
{
	public function updateProcessComputations($objProcess, $arrProcessSteps)
	{
		$objProcess->costPerHour = 0;
		$objProcess->costPerStep = 0;
		$objProcess->dailyRate = 0;
		$objProcess->costInPesos = 0;
		$objProcess->totalInPhp = 0;
		$objProcess->totalInDollars = 0;
		
		foreach ($arrProcessSteps as $objProcessStep) {
			$objProcess->costPerHour += $objProcessStep->costPerHour;
			$objProcess->costPerStep += $objProcessStep->costPerStep;
			$objProcess->dailyRate += $objProcessStep->dailyRate;
			$objProcess->costInPesos += $objProcessStep->costInPesos;
			$objProcess->totalInPhp += $objProcessStep->totalInPhp;
			$objProcess->totalInDollars += $objProcessStep->totalInDollars;
		}

		return $objProcess;
	}
	
	public function getParentProcesses()
	{
		
	}
}