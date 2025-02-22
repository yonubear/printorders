<?php

namespace OCA\PrintOrders\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCA\PrintOrders\Service\PDFService;

class VerificationController extends Controller {
    private $pdfService;

    public function __construct(
        string $AppName,
        IRequest $request,
        PDFService $pdfService
    ) {
        parent::__construct($AppName, $request);
        $this->pdfService = $pdfService;
    }

    /**
     * @PublicPage
     * @NoCSRFRequired
     */
    public function verify(string $data): DataResponse {
        try {
            $isValid = $this->pdfService->verifyPDF($data);

            return new DataResponse([
                'status' => 'success',
                'valid' => $isValid,
                'message' => $isValid ? 'Document is valid' : 'Invalid document'
            ]);
        } catch (\Exception $e) {
            return new DataResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}