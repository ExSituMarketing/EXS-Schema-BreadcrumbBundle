<?php

namespace EXS\SchemaBreadcrumbBundle\Tests\Service\Twig;

use EXS\SchemaBreadcrumbBundle\Service\JsonBreadcrumbGenerator;
use EXS\SchemaBreadcrumbBundle\Service\Twig\BreadcrumbExtension;

class BreadcrumbExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetFunctions()
    {
        $generator = $this->prophesize(JsonBreadcrumbGenerator::class);

        $extension = new BreadcrumbExtension($generator->reveal());

        $result = $extension->getFunctions();

        $this->assertCount(1, $result);
        $this->assertEquals('getJsonBreadcrumb', $result[0]->getName());
    }

    public function testGetJsonBreadcrumb()
    {
        $items = [
            ['url' => 'http://www.test.tld/category-one', 'name' => 'Category One'],
            ['url' => 'http://www.test.tld/category-one/subcategory-two', 'name' => 'Subcategory Two'],
            ['url' => 'http://www.test.tld/category-one/subcategory-two/element-three', 'name' => 'Element Three'],
        ];

        $breadcrumbArray = [
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

        $generator = $this->prophesize(JsonBreadcrumbGenerator::class);
        $generator->getBreadcrumb($items)->willReturn($breadcrumbArray)->shouldBeCalledTimes(1);

        $extension = new BreadcrumbExtension($generator->reveal());

        $result = $extension->getJsonBreadcrumb($items);

        $expected = '<script type="application/ld+json">{"@context":"http:\/\/schema.org","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"item":{"@id":"http:\/\/www.test.tld\/category-one","name":"Category One"}},{"@type":"ListItem","position":2,"item":{"@id":"http:\/\/www.test.tld\/category-one\/subcategory-two","name":"Subcategory Two"}},{"@type":"ListItem","position":3,"item":{"@id":"http:\/\/www.test.tld\/category-one\/subcategory-two\/element-three","name":"Element Three"}}]}</script>';

        $this->assertEquals($expected, $result);
    }
}
