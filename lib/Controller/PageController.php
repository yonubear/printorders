<?php
declare(strict_types=1);

namespace OCA\PrintOrders\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Controller;
use OCP\Util;

class PageController extends Controller {

    public function __construct($appName, IRequest $request) {
        parent::__construct($appName, $request);
    }

    /**
     * @NoCSRFRequired
     * @NoAdminRequired
     */
    public function index() {
        Util::addScript('printorders', 'main');
        Util::addStyle('printorders', 'main');
        return new TemplateResponse('printorders', 'index');
    }
}