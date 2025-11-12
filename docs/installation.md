---
title: How to install package
description: How to install package
github: https://github.com/zaimealabs/commonmark-steps/docs/edit/main/
---

# CommonMark Steps

[[TOC]]

## Introduction

A lightweight and flexible **League CommonMark extension** that adds support for the `::: steps` fenced block, transforming Markdown content into a structured, semantic, accessible **multi-step instructional component**.

- ✅ Automatic step extraction using Markdown headings (`### Step title`)
- ✅ Generates accessible HTML (`aria-labelledby`, `role="region"`)
- ✅ Adds container title from header info string (optional)
- ✅ Supports optional step types: `::: steps warning My Title`
- ✅ Valid `HtmlElement` output (no raw HTML strings)
- ✅ Fully compatible with all CommonMark core features
- ✅ Production-ready unit + feature test suite
- ✅ Zero dependencies outside League\CommonMark ecosystem

## Instalation

You can install the package via composer:

```bash
composer require zaimea/commonmark-steps
```

or via composer.json

```json
"repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/zaimea/commonmark-steps"
        }
    ]
```
