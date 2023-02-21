<?php

declare(strict_types=1);

namespace Setono\GoogleAnalyticsBundle\EventSubscriber\Filter;

use Setono\GoogleAnalyticsBundle\Event\FilterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class FilterEmptyUserAgentSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            FilterEvent::class => 'filter',
        ];
    }

    public function filter(FilterEvent $event): void
    {
        $request = $this->requestStack->getMainRequest();
        if (null === $request) {
            return;
        }

        $userAgent = $request->headers->get('User-Agent');
        if (!is_string($userAgent) || '' === $userAgent) {
            $event->stopPropagation();
        }
    }
}
