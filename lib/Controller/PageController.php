<?php

declare(strict_types=1);

namespace OCA\PrintOrders\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;
use OCP\Util;

class PageController extends Controller 
{
    public function __construct(string $AppName, IRequest $request) 
    {
        parent::__construct($AppName, $request);
    }

    /**
     * @NoCSRFRequired
     * @NoAdminRequired
     */
    public function index(): TemplateResponse 
    {
        Util::addScript('printorders', 'main');
        return new TemplateResponse('printorders', 'index');
    }
}