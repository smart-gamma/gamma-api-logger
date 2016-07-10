<?php

namespace Gamma\Framework\Service;

use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;

interface LoggerStopwatchInterface
{

    /**
     * @see Stopwatch::start
     * @param string $eventName
     * @return false|StopwatchEvent
     */
    public function start($eventName);

    /**
     * @see Stopwatch::stop
     * @param string $eventName
     * @param array  $extraParams
     * @return false|StopwatchEvent
     */
    public function stop($eventName, array $extraParams = array());
}
