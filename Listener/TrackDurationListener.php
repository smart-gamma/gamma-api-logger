<?php

namespace Gamma\ApiLogger\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class TrackDurationListener
{
    private $stopwatchLogger;
    private $uri;
    private $requestApiContent;
    private $requestMethod;

    /**
     * TrackDurationListener constructor.
     * @param $stopwatchLogger
     */
    public function __construct($stopwatchLogger)
    {
        $this->stopwatchLogger = $stopwatchLogger;
    }

    /**
     * @param GetResponseEvent $event
     * @return void | bool
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return false;
        }

        $request = $event->getRequest();
        $this->uri   = $request->getRequestUri();

        if (!preg_match('/\/api/', $this->uri)) {
            return false;
        }

        $this->stopwatchLogger->start($this->uri);
        $this->requestMethod = $request->getMethod();
        $receivedRawData = $request->getContent();

        if($receivedRawData) {
            $parsedData = json_decode($receivedRawData, true);
            $this->requestApiContent = $parsedData;
        }
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$event->isMasterRequest() || !preg_match('/\/api/', $this->getUri())) {
            return;
        }

        $params = array('method' => $this->requestMethod);
        $response  = $event->getResponse();

        if($this->requestApiContent) {
            $params['request'] = $this->requestApiContent;
        }
        $params['response'] = json_decode($response->getContent(), true);

        $this->stopwatchLogger->stop($this->getUri(), $params);
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param $uri
     * @return string
     */
    public function setUri($uri)
    {
        return $this->uri = $uri;
    }
}
