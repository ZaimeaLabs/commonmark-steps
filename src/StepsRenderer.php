<?php

namespace Zaimea\CommonMark\Steps;

use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;

final class StepsRenderer implements NodeRendererInterface
{
    /**
     * @param Steps $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        Steps::assertInstanceOf($node);

        // Render children once — this gives us HTML for the block body
        $rendered = $childRenderer->renderNodes($node->children());

        // Try to split the rendered content into steps using headings (###)
        $parts = preg_split('/\R(?=###\s+)/', $rendered) ?: [];

        $steps = [];

        foreach ($parts as $part) {
            $part = trim((string) $part);
            if ($part === '') {
                continue;
            }

            if (preg_match('/^###\s*(.+?)\s*\R(.*)$/s', $part, $pm)) {
                $title = trim($pm[1]);
                $body = trim($pm[2] ?? '');
            } else {
                // fallback: first line = title
                $lines = preg_split('/\R/', $part);
                $title = trim((string) array_shift($lines));
                $body = trim((string) implode("\n", $lines));
            }

            $steps[] = [
                'title' => $title,
                'body'  => $body,
            ];
        }

        // Merge attributes and ensure the 'step' class exists
        $attrs = $node->data->get('attributes') ?? [];
        $existingClass = trim($attrs['class'] ?? '');
        $type = $node->getType();
        $classes = trim(($existingClass ? $existingClass . ' ' : '') . 'step' . ($type ? ' ' . $type : ''));
        $attrs['class'] = $classes;

        // Add a generated ID for the container for better testing/accessibility
        if (!isset($attrs['id'])) {
            $attrs['id'] = 'steps-' . spl_object_hash($node);
        }

        // Build optional main title using block header title (if present)
        $blockTitle = $node->getTitle();
        $blockTitleEl = $blockTitle
            ? new HtmlElement('h2', ['class' => 'step-title mb-4 text-xl font-bold'], $blockTitle)
            : '';

        // Build ordered list with each step as an <li>
        $listItems = '';
        $i = 0;
        foreach ($steps as $s) {
            $i++;

            // add an indicator glyph (arrow) in a visually hidden span for accessibility, and visible symbol
            $titleContent = new HtmlElement(
                'span',
                ['class' => 'inline-block me-2', 'aria-hidden' => 'true'],
                '➡'
            );

            $h3 = new HtmlElement(
                'h3',
                ['class' => 'text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2'],
                $titleContent . ' ' . $s['title']
            );

            // body is already HTML produced by the child renderer. We keep it raw inside the div.
            $bodyEl = new HtmlElement(
                'div',
                [
                    'class' => 'mt-1 text-base text-gray-600 dark:text-gray-400',
                    'id' => $attrs['id'] . '-item-' . $i,
                    'role' => 'region',
                    'aria-labelledby' => $attrs['id'] . '-item-' . $i . '-title',
                ],
                // Keep the body as-is (rendered HTML). HtmlElement will not escape it again.
                $s['body']
            );

            // ensure the h3 has an id for aria-labelledby
            $h3WithId = new HtmlElement('h3', ['id' => $attrs['id'] . '-item-' . $i . '-title', 'class' => 'text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2'], $titleContent . ' ' . $s['title']);

            $liContent = $h3WithId . "\n" . $bodyEl;
            $li = new HtmlElement('li', ['class' => 'mb-10 ms-4'], $liContent);

            $listItems .= "\n" . $li;
        }

        $ol = new HtmlElement(
            'ol',
            ['class' => 'relative border-s border-gray-200 dark:border-gray-700'],
            trim($listItems) . "\n"
        );

        return new HtmlElement(
            'div',
            $attrs,
            "\n" . $blockTitleEl . "\n" . $ol . "\n"
        );
    }
}
