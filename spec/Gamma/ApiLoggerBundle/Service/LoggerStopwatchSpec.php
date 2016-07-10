<?php

namespace spec\Gamma\ApiLoggerBundle\Service;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;

class LoggerStopwatchSpec extends ObjectBehavior
{
    const LOGGER_ENABLED = true;
    const LOGGER_DISABLED = false;
    const TEST_API_METHOD = "testName";
    const EXPECTED_DURATION = 100;

    function it_is_initializable()
    {
        $this->shouldHaveType('Gamma\ApiLogger\Service\LoggerStopwatch');
    }

    function it_implements_stopwatch_logger_interface()
    {
        $this->shouldImplement('Gamma\ApiLogger\Service\LoggerStopwatchInterface');
    }

    function let(Stopwatch $stopwatch, LoggerInterface $logger, StopwatchEvent $event)
    {
        $event->getDuration()->willReturn(self::EXPECTED_DURATION);
        $stopwatch->start(self::TEST_API_METHOD)->willReturn($event);
        $stopwatch->stop(self::TEST_API_METHOD)->willReturn($event);
        $this->beConstructedWith($stopwatch, $logger, self::LOGGER_ENABLED);
    }

    function it_starts_logging_if_enabled(Stopwatch $stopwatch)
    {
        $stopwatch->start(self::TEST_API_METHOD)->shouldBeCalled();
        $this->start(self::TEST_API_METHOD);
    }

    function it_does_not_start_logging_if_disabled(Stopwatch $stopwatch, LoggerInterface $logger)
    {
        $this->beConstructedWith($stopwatch, $logger, self::LOGGER_DISABLED);
        $stopwatch->start(self::TEST_API_METHOD)->shouldNotBeCalled();
        $this->start(self::TEST_API_METHOD);
    }

    function it_stops_logging_if_enabled(Stopwatch $stopwatch, StopwatchEvent $event, LoggerInterface $logger)
    {
        $stopwatch->stop(self::TEST_API_METHOD)->shouldBeCalled();
        $logger->info(self::TEST_API_METHOD.",                ".self::EXPECTED_DURATION."ms", Argument::any())->shouldBeCalled();
        $this->stop(self::TEST_API_METHOD)->shouldReturn($event);
    }

    function it_breaks_stop_action_if_disabled(Stopwatch $stopwatch, LoggerInterface $logger)
    {
        $this->beConstructedWith($stopwatch, $logger, self::LOGGER_DISABLED);
        $stopwatch->stop(self::TEST_API_METHOD)->shouldNotBeCalled();
        $this->stop(self::TEST_API_METHOD);
    }
}
