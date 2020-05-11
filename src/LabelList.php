<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2020-04-14
 */

namespace JTL\GoPrometrics\Client;

use JTL\Generic\GenericCollection;

/**
 * Class TagList
 *
 * @method Label offsetGet($offset)
 */
class LabelList extends GenericCollection
{
    public function __construct()
    {
        parent::__construct(Label::class);
    }

    /**
     * @param array $itemList
     * @return LabelList
     */
    public static function create(array $itemList): LabelList
    {
        $labelList = new self();
        foreach ($itemList as $key => $value) {
            $labelList->add(new Label((string)$key, (string)$value));
        }
        return $labelList;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        if (count($this->itemList) > 0) {
            $tagStrList = [];
            foreach ($this->itemList as $tag) {
                $tagStrList[] = "{$tag->getKey()}:{$tag->getValue()}";
            }
            $tagStr = implode(',', $tagStrList);
        }

        return $tagStr ?? '';
    }
}
