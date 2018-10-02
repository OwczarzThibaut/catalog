<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PreferredLocaleListener implements EventSubscriberInterface
{
    private $router;
    private $locales;

    public function __construct(UrlGeneratorInterface $router, $localesPattern)
    {
        $this->router = $router;
        $this->locales = explode('|', $localesPattern);
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        if ($event->getRequest()->getPathInfo() !== '/') {
            return;
        }

        $request = $event->getRequest();
        $locale = $request->getPreferredLanguage($this->locales);

        if (null === $locale) {
            return;
        }

        $homepage = $this->router->generate('home', ['_locale' => $locale]);
        $event->setResponse(RedirectResponse::create($homepage));
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 1024],
        ];
    }
}
