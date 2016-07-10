<?php

namespace spec\Gamma\ApiLogger\Service;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use spec\Memio\SpecGen\Marshaller\Model\ArgumentCollectionSpec;
use spec\Prophecy\Exception\Prediction\AggregateExceptionSpec;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;
use Gamma\ApiLogger\Service\LoggerStopwatchSlow;

class LoggerStopwatchSlowSpec extends ObjectBehavior
{
    const SLOW_DURATION_LIMIT = 1000;
    const SLOW_CALL_DURATION = 1200;
    const QUICK_CALL_DURATION = 100;
    const LOGGER_ENABLED = true;
    const TEST_API_METHOD = "testName";

    private function getActionName()
    {
        return LoggerStopwatchSlow::EVENT_PREFIX.self::TEST_API_METHOD;
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Gamma\ApiLogger\Service\LoggerStopwatchSlow');
    }

    function it_implements_stopwatch_logger_interface()
    {
        $this->shouldImplement('Gamma\ApiLogger\Service\LoggerStopwatchInterface');
    }

    function let(Stopwatch $stopwatch, LoggerInterface $logger, StopwatchEvent $event)
    {
        $event->getDuration()->willReturn(self::SLOW_CALL_DURATION);
        $stopwatch->start($this->getActionName())->willReturn($event);
        $stopwatch->stop($this->getActionName())->willReturn($event);
        $this->beConstructedWith($stopwatch, $logger, self::LOGGER_ENABLED, self::SLOW_DURATION_LIMIT);
    }

    function it_logs_api_call_if_it_is_over_given_limit(Stopwatch $stopwatch, LoggerInterface $logger, StopwatchEvent $event)
    {
        $stopwatch->stop($this->getActionName())->shouldBeCalled();
        $logger->error($this->getActionName().",                ".self::SLOW_CALL_DURATION."ms", Argument::any())->shouldBeCalled();
        $this->stop(self::TEST_API_METHOD)->shouldReturn($event);
    }

    function it_skips_logging_api_call_if_it_is_lower_given_limit(Stopwatch $stopwatch, LoggerInterface $logger, StopwatchEvent $event)
    {
        $event->getDuration()->willReturn(self::QUICK_CALL_DURATION);
        $stopwatch->start($this->getActionName())->willReturn($event);
        $stopwatch->stop($this->getActionName())->willReturn($event);
        $this->beConstructedWith($stopwatch, $logger, self::LOGGER_ENABLED, self::SLOW_DURATION_LIMIT);

        $stopwatch->stop($this->getActionName())->shouldBeCalled();
        $logger->error(Argument::any(), Argument::any())->shouldNotBeCalled();
        $this->stop(self::TEST_API_METHOD)->shouldReturn($event);
    }
}
