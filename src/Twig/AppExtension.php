<?php

namespace App\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

class AppExtension extends \Twig_Extension
{
    private $router;
    private $requestStack;
    private $allowedLocales;

    public function __construct(RouterInterface $router, RequestStack $requestStack, $allowedLocales)
    {
        $this->router = $router;
        $this->requestStack = $requestStack;
        $this->allowedLocales = $allowedLocales;
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('i18n_link', [$this, 'i18nLink'], ['is_safe' => ['html']])
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('i18n_links', [$this, 'i18nLinks'], ['is_safe' => ['html']])
        ];
    }

    public function i18nLink($label, $locale)
    {
        $requestAttributes = $this->requestStack->getMasterRequest()->attributes;
        $routeParams = $requestAttributes->get('_route_params');
        $routeParams['_locale'] = $locale;

        return sprintf(
            '<a href="%s">%s</a>',
            $this->router->generate(
                $requestAttributes->get('_route'),
                $routeParams
            ),
            $label
        );
    }

    public function i18nLinks()
    {
        $labels = [
            'fr' => 'French',
            'en' => 'English'
        ];

        $html = '';
        foreach (explode('|', $this->allowedLocales) as $locale) {
            $html .= sprintf('<li>%s</li>', $this->i18nLink($labels[$locale], $locale));
        }

        return $html;
    }

    public function getName()
    {
        return 'app';
    }
}
