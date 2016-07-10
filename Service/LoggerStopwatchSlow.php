<?php

namespace Gamma\Framework\Service;

use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;

/**
 * Wrapper for basic Symfony's Stopwatch service
 * It adds logging functionality for slow API calls
 */
class LoggerStopwatchSlow extends LoggerStopwatch implements LoggerInterface
{
    const EVENT_PREFIX = 'slow:';

    /**
     * @var bool
     */
    private $slowTimeLimit;

    /**
     * @param Stopwatch       $stopwatch
     * @param LoggerInterface $logger
     * @param bool            $stopwatchEnabled
     * @param int             $slowTimeLimit
     */
    public function __construct(Stopwatch $stopwatch, LoggerInterface $logger, $stopwatchEnabled = false, $slowTimeLimit)
    {
        $this->slowTimeLimit = $slowTimeLimit;
        parent::__construct($stopwatch, $logger, $stopwatchEnabled);
    }

    /**
     * Save event data to the log
     *
     * @param StopwatchEvent $event
     * @param string         $eventName
     * @param array          $params
     */
    protected function logEvent(StopwatchEvent $event, $eventName, array $params)
    {
        if($event->getDuration() > $this->slowTimeLimit) {
            $this->logger->error($eventName . ',                ' . $event->getDuration() . 'ms', $params);
        }
    }
}
