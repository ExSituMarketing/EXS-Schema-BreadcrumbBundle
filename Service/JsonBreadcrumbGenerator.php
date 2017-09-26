<?php

namespace EXS\SchemaBreadcrumbBundle\Service;

/**
 * Class JsonBreadcrumbGenerator
 *
 * @package EXS\SchemaBreadcrumbBundle\Service
 */
class JsonBreadcrumbGenerator
{
    /**
     * @var array
     */
    private $baseSkeleton;

    /**
     * @var array
     */
    private $itemSkeleton;

    /**
     * GreadCrumbGenerator constructor.
     */
    public function __construct()
    {
        $this->baseSkeleton = [
            '@context' => 'http://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [],
        ];

        $this->itemSkeleton = [
            '@type' => 'ListItem',
            'position' => null,
            'item' => [
                '@id' => null,
                'name' => null,
            ]
        ];
    }

    /**
     * Format breadcrumb accordingly to http://schema.org/BreadcrumbList.
     *
     * @param array $items
     *
     * @return array|null
     */
    public function getBreadcrumb(array $items)
    {
        $breadcrumb = $this->baseSkeleton;

        foreach ($items as $i => $item) {
            if (
                isset($item['name'])
                && isset($item['url'])
            ) {
                $breadcrumbItem = $this->itemSkeleton;

                $breadcrumbItem['position'] = (int)($i + 1);
                $breadcrumbItem['item']['@id'] = (string)$item['url'];
                $breadcrumbItem['item']['name'] = (string)$item['name'];

                if (isset($item['image'])) {
                    $breadcrumbItem['item']['image'] = (string)$item['image'];
                }

                $breadcrumb['itemListElement'][] = $breadcrumbItem;
            }
        }

        return empty($breadcrumb['itemListElement']) ? null : $breadcrumb;
    }
}
