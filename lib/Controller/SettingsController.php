<?php
namespace OCA\PrintOrders\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCP\IConfig;

class SettingsController extends Controller {
    private $config;
    private $userId;

    public function __construct(
        string $AppName,
        IRequest $request,
        IConfig $config,
        $userId
    ) {
        parent::__construct($AppName, $request);
        $this->config = $config;
        $this->userId = $userId;
    }

    /**
     * @NoAdminRequired
     */
    public function getPaperGrades(): DataResponse {
        $paperGrades = $this->config->getAppValue('printorders', 'paper_grades', '[]');
        return new DataResponse(json_decode($paperGrades, true));
    }

    /**
     * @NoAdminRequired
     */
    public function setPaperGrades(array $paperGrades): DataResponse {
        $this->config->setAppValue(
            'printorders',
            'paper_grades',
            json_encode($paperGrades)
        );
        return new DataResponse(['status' => 'success']);
    }

    /**
     * @NoAdminRequired
     */
    public function getPricing(): DataResponse {
        $pricing = $this->config->getAppValue('printorders', 'pricing', '[]');
        return new DataResponse(json_decode($pricing, true));
    }

    /**
     * @NoAdminRequired
     */
    public function setPricing(array $pricing): DataResponse {
        $this->config->setAppValue(
            'printorders',
            'pricing',
            json_encode($pricing)
        );
        return new DataResponse(['status' => 'success']);
    }
}
