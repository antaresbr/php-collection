<?php

namespace Antares\Collection;

class Collection extends AbstractCollection
{
    /**
     * @see AbstractCollection::add()
     */
    public function add($id, $item = null) {
        return parent::_add($id, $item);
    }

    /**
     * @see AbstractCollection::addIfExists()
     */
    public function addIfNotExists($id, $item = null) {
        return parent::_addIfNotExists($id, $item);
    }

    /**
     * @see AbstractCollection::delete()
     */
    public function delete($id) {
        return parent::_delete($id);
    }

    /**
     * @see AbstractCollection::deleteIfExists()
     */
    public function deleteIfExists($id) {
        return parent::_deleteIfExists($id);
    }

    /**
     * @see AbstractCollection::getById()
     */
    public function getById($id) {
        return parent::_getById($id);
    }

}
