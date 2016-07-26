<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/3/7
 * Time: 上午11:50
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Swoole\Http;

use FastD\Swoole\Request;
use FastD\Swoole\Response;
use FastD\Swoole\Server;

/**
 * Class HttpServer
 *
 * @package FastD\Swoole\Server
 */
abstract class HttpServer extends Server
{
    /**
     * @param array $content
     * @return string
     */
    public function json(array $content)
    {
        return json_encode($content, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param $content
     * @return Response
     */
    public function html($content)
    {
        return $content;
    }

    /**
     * @return \swoole_server
     */
    public function initSwoole()
    {
        return new \swoole_http_server($this->getHost(), $this->getPort(), $this->mode, $this->sockType);
    }

    /**
     * @param \swoole_http_request $swoole_http_request
     * @param \swoole_http_response $swoole_http_response
     */
    public function onRequest(\swoole_http_request $swoole_http_request, \swoole_http_response $swoole_http_response)
    {
        try {
            $request = new Request($swoole_http_request, null, null);
            $content = $this->doRequest($request);
            $response = new Response($swoole_http_response, null, $content);
            $response->setCookies($request->cookie);
            $response->setHeaders($request->headers);
        } catch (\Exception $e) {
            $response = new Response($swoole_http_response, null, null);
            $response->setStatus(500);
        }
        $response->send();
        unset($request, $response);
    }

    /**
     * @param Request $request
     * @return Response
     */
    abstract public function doRequest(Request $request);

    /**
     * Nothing to do.
     *
     * @param \swoole_server $server
     * @param int $task_id
     * @param int $from_id
     * @param string $data
     * @return mixed
     */
    public function doTask(\swoole_server $server, int $task_id, int $from_id, string $data)
    {
        return;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function doWork(Request $request){}

    /**
     * @param Request $request
     * @return Response
     */
    public function doPacket(Request $request){}
}