<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-04-16
 */

namespace JTL\GoPrometrics\Client;

use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\GoPrometrics\Client\TagList
 */
class TagListTest extends TestCase
{
    public function testCanBeUsed(): void
    {
        $taglist = new TagList();
        $taglist->add(new Tag('foo', 'bar'));

        $this->assertInstanceOf(TagList::class, $taglist);
        foreach ($taglist as $tag) {
            $this->assertInstanceOf(Tag::class, $tag);
        }
    }

    public function testCanNotAddOtherObjects(): void
    {
        $taglist = new TagList();

        $this->expectException(\InvalidArgumentException::class);
        $taglist->add(new \stdClass());
    }
}
