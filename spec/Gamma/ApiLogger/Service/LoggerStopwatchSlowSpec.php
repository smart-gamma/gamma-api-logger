<?php

namespace spec\Gamma\ApiLogger\Service;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class LoggerStopwatchSlowSpec extends ObjectBehavior
{
    const SLOW_DURATION_LIMIT = 1000;
    const LOGGER_ENABLED = true;

    function it_is_initializable()
    {
        $this->shouldHaveType('Gamma\ApiLogger\Service\LoggerStopwatchSlow');
    }

    function it_implements_stopwatch_logger_interface()
    {
        $this->shouldImplement('Gamma\ApiLogger\Service\LoggerStopwatchInterface');
    }

    function let(Stopwatch $stopwatch, LoggerInterface $logger)
    {
        $this->beConstructedWith($stopwatch, $logger, self::LOGGER_ENABLED, self::SLOW_DURATION_LIMIT);
    }
}
