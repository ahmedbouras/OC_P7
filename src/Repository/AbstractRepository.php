<?php

namespace App\Repository;

use Pagerfanta\Pagerfanta;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Doctrine\ORM\QueryAdapter;

trait AbstractRepository
{
    public function paginate(QueryBuilder $qb, $page, $limit)
    {
        $adapter = new QueryAdapter($qb);
        $pager = new Pagerfanta($adapter);
        $offset = ($page * $limit + 1) - $limit;
        $pageNumber = ceil(($offset) / $limit);
        $pager->setCurrentPage($pageNumber);
        $pager->setMaxPerPage((int) $limit);

        return $pager;
    }

}