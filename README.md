# EXS-Schema-BreadcrumbBundle

[![Build Status](https://travis-ci.org/ExSituMarketing/EXS-Schema-BreadcrumbBundle.svg?branch=master)](https://travis-ci.org/ExSituMarketing/EXS-Schema-BreadcrumbBundle)

## What is this bundle doing ?

This bundle generates the `<script>` tag containing the json object required to define the `BreadcrumbList` object as defined by schema.org

Source: http://schema.org/BreadcrumbList

## Installation

Add the bundle with composer :

```
$ composer require exs/schema-breadcrumb-bundle
```

Enable the bundle in the kernel :

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
            {
                'name': 'Category One',
                'url': 'http://www.test.tld/category-one',
                'image': 'http://www.test.tld/images/category-one.png'
            },
            {
                'name': 'Subcategory Two',
                'url': 'http://www.test.tld/category-one/subcategory-two'
            },
            {
                'name': 'Element Three',
                'url': 'http://www.test.tld/category-one/subcategory-two/element-three'
            }
        ]) }}
    </head>
    <body>
        ...
    </body>
</html>
```

The order of the elements in the array is used to define the order of elements in the breadcrumb.

The example above will generate the ld+json tag as :

```html
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "item": {
                "@id": "http://www.test.tld/category-one",
                "name": "Category One",
                "image": "http://www.test.tld/images/category-one.png"
            }
        },
        {
            "@type": "ListItem",
            "position": 2,
            "item": {
                "@id": "http://www.test.tld/category-one/subcategory-two",
                "name": "Subcategory Two"
            }
        },
        {
            "@type": "ListItem",
            "position": 3,
            "item": {
                "@id": "http://www.test.tld/category-one/subcategory-two/element-three",
                "name": "Element Three"
            }
        }
    ]
}
</script>
```

And will be interpreted by search engines as a breadcrumb like :

```text
Category One > Subcategory Two > Element Three
``` 
