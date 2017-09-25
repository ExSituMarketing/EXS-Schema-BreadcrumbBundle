<?php

namespace EXS\SchemaBreadcrumbBundle\Tests\Service;

use EXS\SchemaBreadcrumbBundle\Service\JsonBreadcrumbGenerator;

class JsonBreadcrumbGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testGetBreadcrumb()
    {
        $generator = new JsonBreadcrumbGenerator();

        $items = [
            ['url' => 'http://www.test.tld/category-one', 'name' => 'Category One'],
            ['url' => 'http://www.test.tld/category-one/subcategory-two', 'name' => 'Subcategory Two'],
            ['url' => 'http://www.test.tld/category-one/subcategory-two/element-three', 'name' => 'Element Three'],
        ];

        $expected = [
            '@context' => 'http://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'item' => [
                        '@id' => 'http://www.test.tld/category-one',
                        'name' => 'Category One',
                    ]
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'item' => [
                        '@id' => 'http://www.test.tld/category-one/subcategory-two',
                        'name' => 'Subcategory Two',
                    ]
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'item' => [
                        '@id' => 'http://www.test.tld/category-one/subcategory-two/element-three',
                        'name' => 'Element Three',
                    ]
                ],
            ],
        ];

        $result = $generator->getBreadcrumb($items);

        $this->assertEquals($expected, $result);
    }
}
