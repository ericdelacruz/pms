<?php
namespace Process\Model;

use Doctrine\Tests\Common\Annotations\Fixtures\Controller;

use SAC\Model\Common;

use Process\Form\ProcessForm;
use Process\Entity\ProcessEntity;
use Process\Model\ProcessDAO;
use Zend\Json\Json;

class Process extends Common
{
    private $_objProcessEntity;

    public function index() {
        $arrProcesses = $this->_objDAO->findByField('parentId', '0');

        foreach($arrProcesses as $objProcess) {
            //get child processes if there are any
            $arrProcessesTemp = $this->_objDAO->findByField('parentId', $objProcess->processId);
            $intNum = count($arrProcessesTemp);

            if ($intNum > 0) {
                $arrProcess[] = $arrProcessesTemp[$intNum-1];
            } else {
                $arrProcess[] = $objProcess;
            }
        }

        return $arrProcess;
    }

    public function add($objRequest, $intUserId) {        
        $arrData = array('redirect' => false, 'form' => '');

        //get teams
        $arrTeams = $this->_arrDAO['Team']->findAll();

        $objProcessForm = new ProcessForm($arrTeams);
        $objProcessForm->get('submit')->setValue('Add');

        if ($objRequest->isPost()) {
            $objProcessForm->setData($objRequest->getPost());

            if ($objProcessForm->isValid()) {
                $objProcessEntity = new ProcessEntity();

                $objProcessEntity->exchangeArray($objProcessForm->getData());
                
                //set initial values
                $objProcessEntity->parentId = 0;
                $objProcessEntity->userId = $intUserId;
                $objProcessEntity->lastUpdateDate = date('Y-m-d H:i:s');
                $objProcessEntity->teams = json_encode($objProcessEntity->teams);
                
                $this->_arrDAO['Process']->save($objProcessEntity);
                $intProcessId = $objProcessEntity->processId;
               
                $arrPost = array_merge_recursive(
                                $objRequest->getPost()->toArray(),
                                $objRequest->getFiles()->toArray()
                );

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

                        //$intMediaId = $this->getTable('Media', true, 'Process')->saveMedia($objMedia);
                         
                    }
                }
                // Redirect to list of processes
                $arrData['redirect'] = 'process';
            }
        }
        
        $arrData['form'] = $objProcessForm;

        return $arrData;
    }

    public function edit($intId, $objRequest) {
        $arrData = array('redirect' => false, 'form' => '');

        if (!$this->_objDAO) {
            $arrData['redirect'] = 'dashboard';
        } else {
            $objProcessValue = $this->_objDAO->find($intId);

            $objForm = new ProcessForm();

            $objForm->bind($objProcessValue);

            if ($objRequest->isPost()) {
                $objForm->setInputFilter($objProcessValue->getInputFilter())->setData($objRequest->getPost());

                if ($objForm->isValid()) {
                    $this->_objDAO->flush();
                    $arrData['redirect'] = 'finance';
                }
            }
            $arrData['form'] = $objForm;
        }

        return $arrData;
    }
}