<?php

namespace Zaimea\CommonMark\Steps\Tests\Unit;

use Zaimea\CommonMark\Steps\StepsParser;
use Zaimea\CommonMark\Steps\Tests\AbstractTestCase;

class StepsParserTest extends AbstractTestCase
{
    public function test_parses_header_and_body_lines()
    {
        $parser = new StepsParser();

        // Emulate lines being added to the parser: first line = header/info
        $parser->addLine('steps mytype My Title');
        $parser->addLine('This is line one.');
        $parser->addLine('This is line two.');

        // Close block to populate the Step node
        $parser->closeBlock();

        $block = $parser->getBlock();

        // Header words should contain 'mytype' and the literal should contain the body lines
        $this->assertStringContainsString('mytype', implode(' ', $block->getHeaderWords()));
        $this->assertStringContainsString('This is line one.', $block->getLiteral());
        $this->assertStringContainsString('This is line two.', $block->getLiteral());
    }
}
