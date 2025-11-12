<?php

namespace Zaimea\CommonMark\Steps\Tests\Feature;

use Zaimea\CommonMark\Steps\Tests\AbstractTestCase;
use Zaimea\CommonMark\Steps\Tests\GithubFlavoredMarkdownConverter;

class StepsExtraBlankLinesTest extends AbstractTestCase
{
    public function test_multiple_blank_lines_between_sections()
    {
        $md = <<<MD
::: steps
### Step A
Line A1


### Step B
Line B1
:::
MD;

        $converter = new GithubFlavoredMarkdownConverter();
        $html = $converter->convert($md);

        $this->assertStringContainsString('Step A', $html);
        $this->assertStringContainsString('Step B', $html);
        // ensure there are two <li> elements
        preg_match_all('/<li\b/', $html, $m);
        $this->assertCount(2, $m[0]);
    }
}
