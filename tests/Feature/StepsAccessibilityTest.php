<?php

namespace Zaimea\CommonMark\Steps\Tests\Feature;

use Zaimea\CommonMark\Steps\Tests\AbstractTestCase;
use Zaimea\CommonMark\Steps\Tests\GithubFlavoredMarkdownConverter;

class StepsAccessibilityTest extends AbstractTestCase
{
    public function test_items_have_unique_ids_and_aria_labels()
    {
        $md = <<<MD
::: steps
### One
Alpha

### Two
Beta
:::
MD;

        $converter = new GithubFlavoredMarkdownConverter();
        $html = $converter->convert($md);

        // find generated ids like id="steps-...-item-1" and aria-labelledby references
        $this->assertMatchesRegularExpression('/id="steps-[^"]+-item-1"/', $html);
        $this->assertMatchesRegularExpression('/aria-labelledby="steps-[^"]+-item-1-title"/', $html);
        $this->assertMatchesRegularExpression('/id="steps-[^"]+-item-2"/', $html);
        $this->assertMatchesRegularExpression('/aria-labelledby="steps-[^"]+-item-2-title"/', $html);
    }
}
