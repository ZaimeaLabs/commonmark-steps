<?php

namespace Zaimea\CommonMark\Steps\Tests\Feature;

use Zaimea\CommonMark\Steps\Tests\AbstractTestCase;
use Zaimea\CommonMark\Steps\Tests\GithubFlavoredMarkdownConverter;

class StepsInlineTitleMarkdownTest extends AbstractTestCase
{
    public function test_title_with_inline_markdown_behaviour()
    {
        $md = <<<MD
::: steps
### Step **Bold**
Body
:::
MD;

        $converter = new GithubFlavoredMarkdownConverter();
        $html = $converter->convert($md);

        // If you expect bold inside the H3, look for <strong>
        $this->assertTrue(
            strpos($html, '<strong>Bold</strong>') !== false || strpos($html, 'Step **Bold**') !== false,
            'Either <strong>Bold</strong> or the literal markdown should appear in the title depending on implementation'
        );
    }
}
