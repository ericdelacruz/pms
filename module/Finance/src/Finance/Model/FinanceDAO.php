<?php
namespace Finance\Model;

use Finance\Entity\FinanceEntity;
use Doctrine\Common\Persistence\ObjectManager;

class FinanceDAO
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function findAll()
    {
        return $this->objectManager->getRepository('Finance\Entity\FinanceEntity')->findAll();
    }

    public function find($id)
    {
        return $this->objectManager->find('Finance\Entity\FinanceEntity', $id);
    }

    public function save(FinanceEntity $entity)
    {
        $this->objectManager->persist($entity);
        $this->flush();
    }

    public function delete(FinanceEntity $entity)
    {
        $this->objectManager->remove($entity);
        $this->flush();
    }

    public function flush()
    {
        $this->objectManager->flush();
    }
}
