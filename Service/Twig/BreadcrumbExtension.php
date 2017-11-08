<?php

namespace EXS\SchemaBreadcrumbBundle\Service\Twig;

use EXS\SchemaBreadcrumbBundle\Service\JsonBreadcrumbGenerator;

/**
 * Class BreadcrumbExtension
 *
 * @package EXS\SchemaBreadcrumbBundle\Service\Twig
 */
class BreadcrumbExtension extends \Twig_Extension
{
    /**
     * @var JsonBreadcrumbGenerator
     */
    private $generator;

    /**
     * BreadcrumbExtension constructor.
     *
     * @param JsonBreadcrumbGenerator $generator
     */
    public function __construct(JsonBreadcrumbGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('getJsonBreadcrumb', [$this, 'getJsonBreadcrumb'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Returns script tag to add in the header.
     *
     * @param array $items
     *
     * @return string
     */
    public function getJsonBreadcrumb(array $items)
    {
        if (null === $breadcrumb = $this->generator->getBreadcrumb($items)) {
            return '';
        }

        return sprintf(
            '<script type="application/ld+json">%s</script>',
            json_encode($breadcrumb)
        );
    }

    public function getName()
    {
        // TODO: Implement getName() method.
        return 'BreadcrumbExtension';
    }
}
