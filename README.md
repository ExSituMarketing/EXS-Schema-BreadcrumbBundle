# EXS-Schema-BreadcrumbBundle

## What is this bundle doing ?

This bundle generates the `<script>` tag containing the json object required to define the `BreadcrumbList` object as defined by schema.org

Source: http://schema.org/BreadcrumbList

## Installation

Require the bundle in your project

```
$ composer require exs/schema-breadcrumb-bundle
```

Enable the bundle

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new EXS\SchemaBreadcrumbBundle\EXSSchemaBreadcrumbBundle(),
        // ...
    );
}
```

## Usage

Example :
```twig
<!DOCTYPE html>
<html>
    <head>
        ...
        {{ getJsonBreadcrumb([
            {'url': 'http://www.test.tld/category-one', 'name': 'Category One'},
            {'url': 'http://www.test.tld/category-one/subcategory-two', 'name': 'Subcategory Two'},
            {'url': 'http://www.test.tld/category-one/subcategory-two/element-three', 'name': 'Element Three'}
        ]) }}
    </head>
    <body>
        ...
    </body>
</html>
```
