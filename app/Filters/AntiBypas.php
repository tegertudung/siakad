<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;


class AntiBypas implements FilterInterface

{
    /**
     * @param RequestInterface|\CodeIgniter\HTTP\IncomingRequest $request
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Jika request BUKAN AJAX, lempar error 404
        if (!$request->isAJAX()) {
            return redirect()->to(base_url('blocked'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu melakukan apa-apa setelah request
    }
}
