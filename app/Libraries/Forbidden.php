<?php

namespace App\Libraries;

use CodeIgniter\Debug\BaseExceptionHandler;
use CodeIgniter\Debug\ExceptionHandlerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class Forbidden extends BaseExceptionHandler implements ExceptionHandlerInterface
{
    public function handle(
        Throwable $exception,
        RequestInterface $request,
        ResponseInterface $response,
        int $statusCode,
        int $exitCode
    ): void {
        // ================================================================
        // ==> PERUBAHAN DI SINI <==
        // Alih-alih mencari view dinamis berdasarkan status code,
        // kita langsung menunjuk ke file view custom kita.
        $this->render($exception, $statusCode, APPPATH . 'Views/errors/forbidden_page.php');
        // ================================================================

        exit($exitCode);
    }
}
