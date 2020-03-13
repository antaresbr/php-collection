<?php declare(strict_types=1);

use Antares\Collection\AbstractCollection;
use PHPUnit\Framework\TestCase;

use Antares\Collection\Collection;
use Antares\Collection\CollectionException;

final class CollectionTest extends TestCase
{
    public function testExceptionForNotDefinedItemType()
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessage('Item type not defined.');

        new Collection('');
    }

    public function testExceptionForNonExistentType()
    {
        $this->expectException(CollectionException::class);
        $this->expectExceptionMessageMatches('/Non existent type\:/');

        new Collection('non_existent');
    }

    public function testCollectionConstruct()
    {
        $types = explode(',', AbstractCollection::VALID_TYPES);

        foreach ($types as $type) {
            $this->assertInstanceOf(Collection::class, new Collection($type));
            $this->assertInstanceOf(Collection::class, new Collection($type, true));
        }
    }

    public function testAssociativeStringCollection()
    {
        $collection = new Collection('string', true);
        $collection->add('a', 'apple');
        $collection->add('b', 'banana');
        $collection->add('c', 'carrot');
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertEquals($collection->getType(), 'string');
        $this->assertTrue($collection->isAssociative());
        $this->assertEquals($collection->count(), 3);
        $this->assertTrue($collection->hasId('b'));
        $this->assertFalse($collection->hasId('x'));
        $this->assertEquals($collection->getById('b'), 'banana');
       
    }

    public function testNonAssociativeStringCollection()
    {
        $collection = new Collection('string', false);
        $collection->add('apple');
        $collection->add('banana');
        $collection->add('carrot');
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertEquals($collection->getType(), 'string');
        $this->assertFalse($collection->isAssociative());
        $this->assertEquals($collection->count(), 3);
        $this->assertTrue($collection->hasId('banana'));
        $this->assertFalse($collection->hasId('mango'));
    }
}
