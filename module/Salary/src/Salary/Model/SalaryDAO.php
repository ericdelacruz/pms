<?php
namespace Salary\Model;

use Salary\Entity\SalaryEntity;
use Doctrine\Common\Persistence\ObjectManager;

class SalaryDAO
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function findAll()
    {
        return $this->objectManager->getRepository('Salary\Entity\SalaryEntity')->findAll();
    }

    public function find($id)
    {
        return $this->objectManager->find('Salary\Entity\SalaryEntity', $id);
    }

    public function save(SalaryEntity $entity)
    {
        $this->objectManager->persist($entity);
        $this->flush();
    }

    public function delete(SalaryEntity $entity)
    {
        $this->objectManager->remove($entity);
        $this->flush();
    }

    public function flush()
    {
        $this->objectManager->flush();
    }
}
