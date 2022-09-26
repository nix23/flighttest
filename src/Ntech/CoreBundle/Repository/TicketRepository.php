<?php
namespace Ntech\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TicketRepository extends EntityRepository
{
    public function getAll()
    {
        // $whereDql = "";
        // if($isMain)
        //     $whereDql = "WHERE c.isMain = true";

        // $query = $this->getEntityManager()->createQuery("
        //     SELECT c FROM NtechCoreBundle:Country c
        //     {$whereDql}
        //     ORDER BY c.id ASC
        // ");

        return $query->getResult();
    }
}
