<?php

namespace Zaimea\CommonMark\Steps;

use League\CommonMark\Parser\Block\BlockStart;
use League\CommonMark\Parser\Block\BlockStartParserInterface;
use League\CommonMark\Parser\Cursor;
use League\CommonMark\Parser\MarkdownParserStateInterface;

class StepsStartParser implements BlockStartParserInterface
{
    public function tryStart(Cursor $cursor, MarkdownParserStateInterface $parserState): ?BlockStart
    {
        if ($cursor->isIndented()) {
            return BlockStart::none();
        }

        // Allow forms: "::: steps", ":::steps", "::: steps<BR/>" etc.
        $fence = $cursor->match('/^:::\s*steps(?:\s*<br\s*\/?>)?/i');
        if ($fence === null) {
            return BlockStart::none();
        }

        return BlockStart::of(new StepsParser())->at($cursor);
    }
}
