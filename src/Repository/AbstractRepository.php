<?php

namespace App\Repository;

use Pagerfanta\Pagerfanta;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;

trait AbstractRepository
{
    public function paginate(QueryBuilder $qb, $offset = 1, $limit = 10)
    {
        $adapter = new QueryAdapter($qb);
        $pager = new Pagerfanta($adapter);
        $pageNumber = ceil(($offset + 1) / $limit);
        $pager->setCurrentPage($pageNumber);
        $pager->setMaxPerPage((int) $limit);

        return $pager;
    }

}