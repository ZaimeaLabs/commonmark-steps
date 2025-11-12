<?php

namespace Zaimea\CommonMark\Steps;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;

class StepsExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        // Add parser that recognizes the opening fence
        $environment->addBlockStartParser(new StepsStartParser());

        // Add renderer for Step nodes
        $environment->addRenderer(Steps::class, new StepsRenderer());
    }
}
