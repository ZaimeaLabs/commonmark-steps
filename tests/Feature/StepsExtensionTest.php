<?php

namespace Tests\Feature;

use Zaimea\CommonMark\Steps\Tests\AbstractTestCase;
use Zaimea\CommonMark\Steps\Tests\GithubFlavoredMarkdownConverter;

class StepsExtensionTest extends AbstractTestCase
{
    public function test_steps_rendered_to_ordered_list()
    {
        $md = <<<MD
::: steps
### Step A U+C704
This is markdown inside step A.
This is **markdown** inside step A.

### Step B
Line B1
Line B2
:::
MD;

        $converter = new GithubFlavoredMarkdownConverter();
        $html = $converter->convert($md);

        // Basic assertions to ensure structure exists
        $this->assertStringContainsString('<div', $html);
        $this->assertStringContainsString('class="step"', $html); // small chance of spacing differences
        $this->assertStringContainsString('<ol', $html);
        $this->assertStringContainsString('<li', $html);

        // Check that titles are present
        $this->assertStringContainsString('Step A U+C704', $html);
        $this->assertStringContainsString('Step B', $html);

        // Check that bold markdown was rendered inside the first step body
        $this->assertStringContainsString('<strong>markdown</strong>', $html);

        // Ensure order: Step A appears before Step B
        $posA = strpos($html, 'Step A U+C704');
        $posB = strpos($html, 'Step B');
        $this->assertIsInt($posA);
        $this->assertIsInt($posB);
        $this->assertTrue($posA < $posB, 'Step A should come before Step B in rendered HTML');
    }
}
