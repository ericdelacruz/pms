<?php
namespace Team\Model;

use Team\Entity\TeamEntity;
use Doctrine\Common\Persistence\ObjectManager;

class TeamDAO
{
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function findAll()
    {
        return $this->objectManager->getRepository('Team\Entity\TeamEntity')->findAll();
    }

    public function find($id)
    {
        return $this->objectManager->find('Team\Entity\TeamEntity', $id);
    }

    public function save(TeamEntity $entity)
    {
        $this->objectManager->persist($entity);
        $this->flush();
    }

    public function delete(TeamEntity $entity)
    {
        $this->objectManager->remove($entity);
        $this->flush();
    }

    public function flush()
    {
        $this->objectManager->flush();
    }
}
