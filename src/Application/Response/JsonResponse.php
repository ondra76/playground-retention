<?php
declare(strict_types=1);


namespace Application\Response;

use Application\Response\Exception\PrintingResponseTwiceException;
use Application\Response\Exception\UnsupportedResponseCodeException;
use function http_response_code;
use function json_encode;
use function json_last_error_msg;

final class JsonResponse implements ResponseInterface
{


    /**
     * @var int
     */
    private $code;
    /**
     * @var array<string,mixed>
     */
    private $data;
    /**
     * @var bool
     */
    private $isPrinted;

    /**
     * @param array<string,mixed> $data
     */
    public function __construct(
        int $code,
        array $data
    ) {
        if (false === in_array($code, ResponseInterface::CODES_SUPPORTED)) {
            throw new UnsupportedResponseCodeException($code);
        }
        $this->code = $code;
        $this->data = $data;
        $this->isPrinted = false;
    }

    public function printAndExit(): void
    {
        if (true === $this->isPrinted) {
            throw new PrintingResponseTwiceException();
        }
        $this->isPrinted = true;
        header("Content-Type: application/json");

        $json = json_encode($this->data);
        if ($json === false) {
            $json = json_encode(["encodingError" => json_last_error_msg()]);
            if ($json === false) {
                $json = '{"encodingError":"unknown"}';
            }

            http_response_code(ResponseInterface::CODE_INTERNAL_ERROR);
            echo $json;
            exit();
        }

        http_response_code($this->code);
        echo $json;
        exit();
    }
}
