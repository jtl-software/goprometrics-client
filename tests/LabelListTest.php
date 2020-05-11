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
 * @covers \JTL\GoPrometrics\Client\LabelList
 */
class LabelListTest extends TestCase
{
    public function testCanBeUsed(): void
    {
        $labelList = new LabelList();
        $labelList->add(new Label('foo', 'bar'));

        $this->assertInstanceOf(LabelList::class, $labelList);
        foreach ($labelList as $tag) {
            $this->assertInstanceOf(Label::class, $tag);
        }
    }

    public function testCanNotAddOtherObjects(): void
    {
        $taglist = new LabelList();

        $this->expectException(\InvalidArgumentException::class);
        $taglist->add(new \stdClass());
    }

    public function testCanBeCreatedFromArray(): void
    {
        $labelDataList = ['brand' => "bitburger", "type" => "pils", "alc" => "4.8"];

        $labelList = LabelList::create($labelDataList);
        $this->assertInstanceOf(LabelList::class, $labelList);
        $this->assertSame(3, $labelList->count());
        foreach ($labelList as $label) {
            $this->assertTrue(isset($labelDataList[$label->getKey()]));
            $this->assertSame($labelDataList[$label->getKey()], $label->getValue());
        }
    }

    public function testCanLabelsConvertToString(): void
    {
        $labelList = new LabelList();
        $this->assertEmpty($labelList->__toString());

        $labelList->add(new Label('foo', 'bar'));
        $this->assertEquals('foo:bar', $labelList->__toString());
    }
}
