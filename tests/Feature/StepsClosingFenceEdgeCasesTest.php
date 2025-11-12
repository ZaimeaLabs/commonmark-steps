<?php

namespace Zaimea\CommonMark\Steps\Tests\Feature;

use Zaimea\CommonMark\Steps\Tests\AbstractTestCase;
use Zaimea\CommonMark\Steps\Tests\GithubFlavoredMarkdownConverter;

class StepsClosingFenceEdgeCasesTest extends AbstractTestCase
{
    public function test_closing_fence_with_spaces_is_recognized()
    {
        $md = "::: steps\n### A\nX\n:::   \n";
        $converter = new GithubFlavoredMarkdownConverter();
        $html = $converter->convert($md);

        $this->assertStringNotContainsString('::: steps', $html); // should not be left in output
        $this->assertStringContainsString('A', $html);
    }
}
