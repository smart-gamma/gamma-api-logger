<?php

namespace spec\Gamma\ApiLogger\Service;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;
use Symfony\Component\Stopwatch\Stopwatch;


class LoggerStopwatchSpec extends ObjectBehavior
{
    const LOGGER_ENABLED = true;
    const LOGGER_DISABLED = false;

    function it_is_initializable()
    {
        $this->shouldHaveType('Gamma\ApiLogger\Service\LoggerStopwatch');
    }

    function it_implements_stopwatch_logger_interface()
    {
        $this->shouldImplement('Gamma\ApiLogger\Service\LoggerStopwatchInterface');
    }

    function let(Stopwatch $stopwatch, LoggerInterface $logger)
    {
        $this->beConstructedWith($stopwatch, $logger, self::LOGGER_ENABLED);
    }
}
