<?php

namespace App\Representation;

use Pagerfanta\Pagerfanta;

class Products
{
    public $data;
    public $meta;

    public function __construct(Pagerfanta $data)
    {
        $this->data = $data->getCurrentPageResults();

        $this->addMeta('limit', $data->getMaxPerPage());
        $this->addMeta('current_items', count($data->getCurrentPageResults()));
        $this->addMeta('total_items', $data->getNbResults());
        $this->addMeta('offset', $data->getCurrentPageOffsetStart());
    }


    public function addMeta($key, $value)
    {
        if (isset($this->meta[$key])) {
            throw new \LogicException("la clé '$key' possède déjà une valeur. Essayez la fonction setMeta.");
        }
        $this->setMeta($key, $value);
    }

    public function setMeta($key, $value)
    {
        $this->meta[$key] = $value;
    }
}