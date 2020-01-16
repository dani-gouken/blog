<?php
namespace Oxygen;

use Oxygen\Contracts\EmitterContract;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class Emitter implements EmitterContract
{
    /**
     * @param ResponseInterface $response
     */
    public function emit(ResponseInterface $response):void
    {
        if (headers_sent()) {
            throw new RuntimeException('Headers were already sent. The response could not be emitted!');
        }
        $statusLine = sprintf(
            'HTTP/%s %s %s',
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        );
        header($statusLine, true);
        foreach ($response->getHeaders() as $name => $values) {
            $responseHeader = sprintf(
                '%s: %s',
                $name,
                $response->getHeaderLine($name)
            );
            header($responseHeader, false);
        }
        echo $response->getBody();
        exit();
    }
}
