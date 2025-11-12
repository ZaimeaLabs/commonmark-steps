<?php

namespace Zaimea\CommonMark\Steps\Tests\Feature;

use Zaimea\CommonMark\Steps\Tests\AbstractTestCase;
use Zaimea\CommonMark\Steps\Tests\GithubFlavoredMarkdownConverter;

class StepsNoHeadingsTest extends AbstractTestCase
{
    public function test_fallback_first_line_as_title_when_no_headings(): void
    {
        $md = <<<MD
::: steps
Step A Title
Line A1
Line A2

Step B Title
Line B1
:::
MD;

        $converter = new GithubFlavoredMarkdownConverter();
        $html = $converter->convert($md);

        $this->assertStringContainsString('<div', $html);
        $this->assertStringContainsString('step', $html);
        // first title should be present
        $this->assertStringContainsString('Step A Title', $html);
        $this->assertStringContainsString('Line A1', $html);
        $this->assertStringContainsString('Step B Title', $html);
    }
}
