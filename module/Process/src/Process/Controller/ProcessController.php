<?php
namespace Process\Controller;

use Zend\View\Model\ViewModel;
use Process\Model\Process;
use Process\Form\ProcessForm;
use SAC\Mvc\Controller;

use Process\Model\Step;
use Process\Model\StepResource;
use Process\Model\Media;
use Team\Model\Team;
use Resource\Model\Resource;
use Salary\Model\Salary;

use Process\Entity\StepEntity;
use Process\Entity\ProcessEntity;

class ProcessController extends Controller
{
	protected $form;
	protected $storage;
	protected $authservice;
	protected $strModule = 'Process';

    public function indexAction()
    {
    	$arrProcess = array();

    	$arrProcesses = $this->getTable($this->strModule)->fetchAllByField('parentId', '0');

    	foreach($arrProcesses as $objProcess) {
    		//get child processes if there are any
    		$objProcessTemp = $this->getTable($this->strModule)->fetchAllByField('parentId', $objProcess->processId);
    		$intNum = count($objProcessTemp);

    		if ($intNum > 0) {
    			for($intCount=0;$intCount<$intNum;$intCount++) {
    				$objProcessTemp->next();
    			}
    			$arrProcess[] = $objProcessTemp->current();
    		} else {
    			$arrProcess[] = $objProcess;
    		}
    	}

        return new ViewModel(array(
            'processes' => $arrProcess
        ));
    }
    
    public function versionsAction()
    {    	
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('process', array(
    				'action' => 'index'
    		));
    	}

    	$arrParent = array();
    	$arrProcesses = array();
    	
    	$arrParent = $this->getTable($this->strModule)->getProcess($id); //parent process
    	$arrProcesses = $this->getTable($this->strModule)->fetchAllByField('parentId', $id);
    	
    	return array(
    			'parent' => $arrParent,
    			'processes' => $arrProcesses,
    	);
    }

    public function addAction()
    {
    	//get resources
    	//$arrResources = $this->getTable('Resource', true)->fetchAll();
    	
    	//get teams
    	$arrTeams = $this->getTable('Team', true)->fetchAll();
    	
    	$form  = new ProcessForm($arrTeams);
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $process = new Process();
            $form->setInputFilter($process->getInputFilter());
            
            //$arrPost = $request->getPost();
            
            $arrPost = array_merge_recursive(
            		$this->getRequest()->getPost()->toArray(),
            		$this->getRequest()->getFiles()->toArray()
            );

            $form->setData($arrPost);
            if ($form->isValid()) {
                $process->exchangeArray($form->getData());

                //set user
                $process->userId = $this->zfcUserAuthentication()->getIdentity()->getId();
                
                $intProcessId = $this->getTable($this->strModule, true)->saveProcess($process);
                
                //fileupload
                $arrFile = $arrPost['sampleFiles'];

                $strName = $arrFile['name'];
                $strType = $arrFile['type'];
                $strTmp = $arrFile['tmp_name'];
                $intSize = $arrFile['size'];
                if ($strName != '' && strlen($strName) > 0) {
	
	                $arrImageData = getimagesize($strTmp);
	                
	                if($arrImageData === FALSE || !($arrImageData[2] == IMAGETYPE_GIF || $arrImageData[2] == IMAGETYPE_JPEG || $arrImageData[2] == IMAGETYPE_PNG)) {
	                	//not really an image
	                	//do something
	                } else { //upload file
		                //generate random image name
						$arrFilename = explode('.', $strName);
						$strExt = strtolower($arrFilename[1]);
						$strTargetFolder = './public/images/process/'.$intProcessId;
						$strPath = '/images/process/'.$intProcessId;
						
						if (!is_dir($strTargetFolder)) {
							mkdir($strTargetFolder);
						}
	                
		                $strRandName = uniqid().'_'.$intProcessId.'.'.$strExt;
		                $strTarget = $strTargetFolder.'/'.$strRandName;
	
		                move_uploaded_file($strTmp, $strTarget);
		                
		                //save media
		                $arrStep['originalFilename'] = $strName;
		                $arrStep['filename'] = $strRandName;
		                $arrStep['path'] = $strPath;
	
		                $objMedia = new Media();
		                $objMedia->exchangeArray($arrStep);
		                $objMedia->processId = $intProcessId;
		                
		                $intMediaId = $this->getTable('Media', true, 'Process')->saveMedia($objMedia);
	
	                }
                }
                // Redirect to list of processes
                return $this->redirect()->toRoute('process');
            }
        }
        return array('form' => $form);
    }
    

    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('process', array(
    				'action' => 'add'
    		));
    	}
    	$objProcessEntity = new ProcessEntity();
    	$process = $this->getTable($this->strModule)->getProcess($id);

    	//get resources
    	$arrResources = $this->getTable('Resource', true)->fetchAll();

    	//get teams
    	$arrTeams = $this->getTable('Team', true)->fetchAll();
    	
    	//get steps
    	$arrSteps = array();
    	$arrStepsTemp = $this->getTable('Step', true, 'Process')->fetchAllByField('processId', $id);
    	$intCount = 0;
    	foreach($arrStepsTemp as $objStep) {
    		//get resources
    		$arrStepResources = $this->getTable('StepResource', true, 'Process')->fetchAllByField('stepId', $objStep->stepId);
    		$intCountResource = 0;
    		foreach ($arrStepResources as $objStepResource) {
    			
    			if ($objStepResource->userId != '' && $objStepResource->userId != 0) {
	    			//get user data
	    			$objUser = $this->getTable('User', true)->getUser($objStepResource->userId);
	    			$arrSteps[$intCount]['resource'][$intCountResource] = $objUser->firstName.' '.$objUser->lastName;
    			} else {
    				//get resource data
    				$objResource = $this->getTable('Resource', true)->getResource($objStepResource->resourceId);
    				$arrSteps[$intCount]['resource'][$intCountResource] = $objResource->description;
    			}
    			
    			$intCountResource++;
    		}
    		
    		$arrSteps[$intCount]['step'] = $objStep;
    		$intCount++;
    	}
    	//get media
    	$arrMedia = array();
    	$arrMedia = $this->getTable('Media', true, 'Process')->fetchAllByField('processId', $id);

    	$form  = new ProcessForm($arrTeams);
    	$form->bind($process);
    	$form->get('submit')->setAttribute('value', 'Save Changes');

    	$request = $this->getRequest();
    	if ($request->isPost()) {
            $arrPost = array_merge_recursive(
            		$this->getRequest()->getPost()->toArray(),
            		$this->getRequest()->getFiles()->toArray()
            );

    		$form->setInputFilter($process->getInputFilter());
    		
    		//$arrPost['userId'] = $this->zfcUserAuthentication()->getIdentity()->getId();
    		$form->setData($arrPost);

    		if ($form->isValid()) {
    			$intProcessId = $this->getTable($this->strModule, true)->saveProcess($form->getData());

    			//update steps
    			//remove existing steps and update with new one
    			//$this->getTable('Step', true, 'Process')->deleteAllByField('processId', $id);
    			
    			if (isset($arrPost['step'])) {
    			$arrSteps = $arrPost['step'];
	    			if (count($arrSteps) > 0) {
		    			foreach ($arrSteps as $arrStep) {
		    				$objStep = new Step();
		    				$objStep->exchangeArray($arrStep);
		    				$objStep->processId = $intProcessId;	
		    				$intStepId = $this->getTable('Step', true, 'Process')->saveStep($objStep);
		    				
		    				//save step resources
		    				//get step resources
		    				$arrStepsResources = $this->getTable('StepResource', true, 'Process')->fetchAllByField('stepId', $objStep->stepId);
		    				
		    				foreach ($arrStepsResources as $objStepRes) {
		    					$objStepRes->stepResourceId = '';
		    					$objStepRes->stepId = $intStepId;
		    					
		    					$intStepResourceId = $this->getTable('StepResource', true, 'Process')->saveStepResource($objStepRes);
		    				}
		    			}
	    			}
    			}
    			//compute totals
    			$process = $this->getTable($this->strModule, true)->getProcess($intProcessId);
    			$arrProcessSteps = $this->getTable('Step', true, 'Process')->fetchAllByField('processId', $intProcessId);

    			$process = $objProcessEntity->updateProcessComputations($process, $arrProcessSteps);
    			$this->getTable('Process', true)->updateProcess($process); //update process data

    			//keep photos
    			if (isset($arrPost['keepFiles'])) {
    				$arrPhotos = $arrPost['keepFiles'];
    				
    				$strTargetFolder = './public/images/process/'.$intProcessId;

    				if (!is_dir($strTargetFolder)) {
    					mkdir($strTargetFolder);
    				}
    				
    				foreach ($arrPhotos as $intMedia) { //save media
						//get photo details
						$objMediaDetails = $this->getTable('Media', true, 'Process')->getMedia($intMedia);

						$arrMedia = array();
    					$arrMedia['originalFilename'] = $objMediaDetails->originalFilename;
    					$arrMedia['filename'] = $objMediaDetails->filename;
    					$arrMedia['path'] = $objMediaDetails->path;
    					
    					$objMedia = new Media();
    					$objMedia->exchangeArray($arrMedia);
    					$objMedia->processId = $intProcessId;
    					
    					$intMediaId = $this->getTable('Media', true, 'Process')->saveMedia($objMedia); //save to database
    					
    					//copy existing photo to new folder
    					$arrFilename = explode('.', $arrMedia['filename']);
    					$strExt = strtolower($arrFilename[1]);
    					$strRandName = uniqid().'_'.$intProcessId.'.'.$strExt;
    					@copy('./public/images/process/'.$objMediaDetails->mediaId.'/'.$arrMedia['filename'], $strTargetFolder.'/'.$strRandName);
    				}
    			}

    			//fileupload
    			//remove existing images and update with new one
    			//$this->getTable('Media', true, 'Process')->deleteAllByField('processId', $id);
    			
    			$arrFile = $arrPost['sampleFiles'];
    			
    			$strName = $arrFile['name'];
    			$strType = $arrFile['type'];
    			$strTmp = $arrFile['tmp_name'];
    			$intSize = $arrFile['size'];
    			
    			if ($strName != '' && strlen($strName) > 0) {
	    			$arrImageData = getimagesize($strTmp);
	    			
	    			if($arrImageData === FALSE || !($arrImageData[2] == IMAGETYPE_GIF || $arrImageData[2] == IMAGETYPE_JPEG || $arrImageData[2] == IMAGETYPE_PNG)) {
	    				//not really an image
	    				//do something
	    			} else { //upload file
	    				//generate random image name
	    				$arrFilename = explode('.', $strName);
	    				$strExt = strtolower($arrFilename[1]);
	    				$strTargetFolder = './public/images/process/'.$intProcessId;
	    				$strPath = '/images/process/'.$intProcessId;
	    					
	    				if (!is_dir($strTargetFolder)) {
	    					mkdir($strTargetFolder);
	    				}
	    			
	    				$strRandName = uniqid().'_'.$intProcessId.'.'.$strExt;
	    				$strTarget = $strTargetFolder.'/'.$strRandName;
	    			
	    				move_uploaded_file($strTmp, $strTarget);
	    				 
	    				//save media
	    				$arrStep['originalFilename'] = $strName;
	    				$arrStep['filename'] = $strRandName;
	    				$arrStep['path'] = $strPath;
	    			
	    				$objMedia = new Media();
	    				$objMedia->exchangeArray($arrStep);
	    				$objMedia->processId = $intProcessId;
	    				 
	    				$intMediaId = $this->getTable('Media', true, 'Process')->saveMedia($objMedia);
	    			
	    			}
    			}
    			
    			// Redirect to list of processes
    			return $this->redirect()->toRoute('process');
    		}
    	}
    	
    	//get User
    	$objUser = $this->getTable('User', true)->getUser($process->userId);
    	
    	return array(
    			'processId' => $id,
    			'process' => $process,
    			'form' => $form,
    			'user' => $objUser,
    			'steps' => $arrSteps,
    			'resources' => $arrResources,
    			'media' => $arrMedia,
    	);
    }

    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('process');
    	}
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'No');
    	
    		if ($del == 'Yes') {
    			$id = (int) $request->getPost('processId');
    			$this->getTable($this->strModule)->deleteProcess($id);

    			//delete resources associated to process steps
    			$arrSteps = $this->getTable('Step', true, 'Process')->fetchAllByField('processId', $id);

    			foreach ($arrSteps as $objStep) {
    				//delete steps resources
    				$this->getTable('StepResource', true, 'Process')->deleteAllByField('stepId', $objStep->stepId);
    			}
    			
    			//delete steps
    			$this->getTable('Step', true, 'Process')->deleteAllByField('processId', $id);
    			
    			//delete media
    			$this->getTable('Media', true, 'Process')->deleteAllByField('processId', $id);
    		}
    	
    		// Redirect to list of processes
    		return $this->redirect()->toRoute('process');
    	}
    	
    	return array(
    			'processId'    => $id,
    			'process' => $this->getTable($this->strModule)->getProcess($id)
    	);
    }
    
    public function resourcesAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		//$arrPost = $request->getPost();
    		$arrPost = $request->getPost();
    		
    		if(isset($arrPost['stepResourceId']) && isset($arrPost['deleteButton'])) {
    			$intStepResourceId = $arrPost['stepResourceId'];
    			
    			//delete
    			$this->getTable('StepResource', true, 'Process')->deleteStepResource($intStepResourceId);
    			
    			//get step
    			$objStep = $this->getTable('Step', true, 'Process')->getStep($id);
    		} else {

	    		$intStepId = $id;
	    		$intResourceId = $arrPost['resourceId'];
	    		$intUserId = $arrPost['userId'];
	    		$fltDaysOnProject = $arrPost['daysNeeded'];
	
	    		$objStepEntity = new StepEntity();
	    		
	    		if ($intUserId > 0 ) { //selected a specific user
	    			//get user data
	    			$objUser = $this->getTable('User', true)->getUser($intUserId);
	    			
	    			$arrData = $objStepEntity->mapStepResource($objUser);
	    		} else if (strlen($intResourceId) > 0 ) {
	    			//get resource data
	    			$objResource = $this->getTable('Resource', true)->getResource($intResourceId);
	    			
	    			//get salary grade for said resource
	    			$objSalaryGrade = $this->getTable('Salary', true)->getSalary($objResource->salaryGradeId);
	    			
	    			$arrData = $objStepEntity->mapStepResourceToSalary($objSalaryGrade);
	    			$arrData['resourceId'] = $intResourceId;
	    		}
	    			$arrData['stepId'] = $intStepId;
	    			$arrData['daysNeeded'] = $fltDaysOnProject;
	    			
	    			//compute costs
	    			$arrData['totalBenefitsInitial'] = $objStepEntity->computeTotalBenefitsInitial($arrData);
	    			$arrData['taxOnAllowance'] = $objStepEntity->computeTaxOnAllowance($arrData);
	    			$arrData['totalBenefits'] = $objStepEntity->computeTotalBenefits($arrData['totalBenefitsInitial'], $arrData['taxOnAllowance']);
	    			$arrData['totalManpowerCost'] = $objStepEntity->computeManpowerCost($arrData, $arrData['totalBenefits']);
	
	    			$arrData['totalSGACost'] = $objStepEntity->computeTotalSGACost($arrData);
	    			$arrData['monthlyRate'] = $objStepEntity->computeMonthlyRate($arrData['totalManpowerCost'], $arrData['totalSGACost']);
	    			$arrData['dailyRate'] = round($arrData['monthlyRate']/22, 2);
	    			$arrData['hourlyRate'] = round($arrData['dailyRate']/8, 2);
	    			
	    			$arrData['costInPHP'] = round(($arrData['dailyRate']*$fltDaysOnProject) ,2);
	    			$arrData['totalBillingPHP'] = round(($arrData['costInPHP']/0.8), 2); //@TODO make margin dynamic
	    			$arrData['costMargin'] = $arrData['totalBillingPHP'] - $arrData['costInPHP'];
	    			$arrData['totalBillingUSD'] = round(($arrData['totalBillingPHP']/40),2); //@TODO make dollar conversion dynamic
	    			
	    			//assign computed values
	    			$objStepResource = new StepResource();
	    			$objStepResource->exchangeArray($arrData);
	
	    			//save step resource
	    			$intStepResourceId = $this->getTable('StepResource', true, 'Process')->saveStepResource($objStepResource);
	    			
	    			//this time update step computations
	    			//get step resources
	    			$arrStepResources = $this->getTable('StepResource', true, 'Process')->fetchAllByField('stepId', $id);
	    			
	    			//get step
	    			$objStep = $this->getTable('Step', true, 'Process')->getStep($id);
	    			
	    			$objStep = $objStepEntity->updateStepComputations($objStep, $arrStepResources);
	
	    			$this->getTable('Step', true, 'Process')->updateStep($objStep);
    		}

    	} else {

	    	//get step
	    	$objStep = $this->getTable('Step', true, 'Process')->getStep($id);
    	}

    	//get step resources
    	$arrStepResources = $this->getTable('StepResource', true, 'Process')->fetchAllByField('stepId', $id);
    	
    	//get all huuman resource
    	$arrResources = $this->getTable('Resource', true)->fetchAll();
    	
    	
    	return array(
    			'processId' => $objStep->processId,
    			'stepId' => $id,
    			'resources' => $arrResources,
    			'stepresources' => $arrStepResources,
    	);
    }
    
    public function chartAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);

    	if (!$id) {
    		return $this->redirect()->toRoute('process');
    	}
    	
    	//get steps
    	$arrSteps = array();
    	$arrStepsTemp = $this->getTable('Step', true, 'Process')->fetchAllByField('processId', $id);
    	foreach($arrStepsTemp as $objStep) {
    		/*$objResource = $this->getTable('Resource', true)->getResource($objStep->resourceId);
    		$objStep->resourceName = $objResource->description;*/
    		array_push($arrSteps, $objStep);
    	}

    	 return array(
    			'processId' => $id,
    			'steps' => $arrSteps,
    	);
    }
    
    /** AJAX **/
    public function getStepDetailsAjaxAction()
    {
    	$intResourceId = (int) $this->params()->fromRoute('id', 0);
    	$arrData = array();
    	
    	$objResource = $this->getTable('Resource', true)->getResource($intResourceId);
    	$objSalary = $this->getTable('Salary', true)->getSalary($objResource->salaryGradeId);
    	$objTeam = $this->getTable('Team', true)->getTeam($objResource->teamId);
    	
    	$arrData['salary'] = $objSalary;
    	$arrData['team'] = $objTeam;
 
    	$objView = new ViewModel(array(
    			'data'    => $arrData
    	));
    	$objView->setTerminal(true);
    	$objView->setTemplate('process/ajax/view.phtml');

    	return $objView;
    }
}