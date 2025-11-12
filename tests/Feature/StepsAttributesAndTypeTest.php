<?php

namespace Zaimea\CommonMark\Steps\Tests\Feature;

use Zaimea\CommonMark\Steps\Tests\AbstractTestCase;
use Zaimea\CommonMark\Steps\Tests\GithubFlavoredMarkdownConverter;

class StepsAttributesAndTypeTest extends AbstractTestCase
{
    public function test_type_from_header_appears_as_class()
    {
        $md = <<<MD
::: steps mytype
### Title One
Content
:::
MD;

        $converter = new GithubFlavoredMarkdownConverter();
        $html = $converter->convert($md);

        // class should contain 'step' and 'mytype'
        $this->assertStringContainsString('step', $html);
        $this->assertStringContainsString('mytype', $html);
    }
}
