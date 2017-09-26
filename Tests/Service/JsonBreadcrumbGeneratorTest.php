<?php

namespace EXS\SchemaBreadcrumbBundle\Tests\Service;

use EXS\SchemaBreadcrumbBundle\Service\JsonBreadcrumbGenerator;

class JsonBreadcrumbGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testGetBreadcrumb()
    {
        $generator = new JsonBreadcrumbGenerator();

        $items = [
            [
                'name' => 'Category One',
                'url' => 'http://www.test.tld/category-one',
                'image' => 'http://www.test.tld/images/category-one.png',
            ],
            [
                'name' => 'Subcategory Two',
                'url' => 'http://www.test.tld/category-one/subcategory-two',
            ],
            [
                'name' => 'Element Three',
                'url' => 'http://www.test.tld/category-one/subcategory-two/element-three',
            ],
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
                        'image' => 'http://www.test.tld/images/category-one.png',
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

    public function testGetBreadcrumbWithAnEmptyArray()
    {
        $generator = new JsonBreadcrumbGenerator();

        $result = $generator->getBreadcrumb([]);

        $this->assertNull($result);
    }
}
