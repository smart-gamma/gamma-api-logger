<?php

namespace spec\Gamma\ApiLogger\Listener;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Gamma\ApiLogger\Service\LoggerStopwatch;

class TrackDurationListenerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Gamma\ApiLogger\Listener\TrackDurationListener');
    }

    function let(LoggerStopwatch $loggerStopwatch)
    {
        $this->beConstructedWith($loggerStopwatch);
    }
}
