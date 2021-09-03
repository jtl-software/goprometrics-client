<?php

declare(strict_types=1);

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
        $tagStr = '';
        if (count($this->itemList) > 0) {
            $tagStrList = [];
            /** @var \JTL\GoPrometrics\Client\Label $label */
            foreach ($this->itemList as $label) {
                $tagStrList[] = "{$label->getKey()}:{$label->getValue()}";
            }
            $tagStr = implode(',', $tagStrList);
        }

        return $tagStr;
    }
}
