<?php
namespace Resource\Model;

use Resource\Entity\ResourceEntity;
use Doctrine\Common\Persistence\ObjectManager;

class ResourceDAO
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function findAll()
    {
        return $this->objectManager->getRepository('Resource\Entity\ResourceEntity')->findAll();
    }

    public function find($id)
    {
        return $this->objectManager->find('Resource\Entity\ResourceEntity', $id);
    }

    public function save(ResourceEntity $entity)
    {
        $this->objectManager->persist($entity);
        $this->flush();
    }

    public function delete(ResourceEntity $entity)
    {
        $this->objectManager->remove($entity);
        $this->flush();
    }

    public function flush()
    {
        $this->objectManager->flush();
    }
}
