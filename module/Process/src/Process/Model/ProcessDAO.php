<?php
namespace Process\Model;

use Process\Entity\ProcessEntity;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;

class ProcessDAO
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function findAll()
    {
        return $this->objectManager->getRepository('Process\Entity\ProcessEntity')->findAll();
    }

    public function find($id)
    {
        return $this->objectManager->find('Process\Entity\ProcessEntity', $id);
    }
    
    public function findByField($strField, $strValue)
    {
        $objQuery = $this->objectManager->createQuery("SELECT u FROM Process\Entity\ProcessEntity u WHERE u.".$strField." = ".$strValue."");

        return $objQuery->getResult();
    }

    public function save(ProcessEntity $entity)
    {
        $this->objectManager->persist($entity);
        $this->flush();
    }

    public function delete(ProcessEntity $entity)
    {
        $this->objectManager->remove($entity);
        $this->flush();
    }

    public function flush()
    {
        $this->objectManager->flush();
    }
}