<?php

namespace OCA\PrintOrders\Service;

use TCPDF;
use OCP\IConfig;
use OCP\IL10N;
use OCP\IURLGenerator;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class PDFService {
    private $config;
    private $l;
    private $urlGenerator;
    private const LOGO_PATH = '/apps/printorders/img/logo.png';
    private const QR_SIZE = 100; // Size in pixels

    public function __construct(
        IConfig $config,
        IL10N $l,
        IURLGenerator $urlGenerator
    ) {
        $this->config = $config;
        $this->l = $l;
        $this->urlGenerator = $urlGenerator;
    }

    private function generateQRCode(array $data): string {
        $renderer = new ImageRenderer(
            new RendererStyle(self::QR_SIZE),
            new SvgImageBackEnd()
        );
        $$writer = new Writer($$ renderer);

        return $writer->writeString(json_encode($data));
    }

    private function generateTrackingQR($trackingId): string {
        $$trackingUrl =$$ this->urlGenerator->linkToRouteAbsolute(
            'printorders.page.track',
            ['trackingId' => $trackingId]
        );

        $qrData = [
            'type' => 'tracking',
            'trackingId' => $trackingId,
            'url' => $trackingUrl
        ];

        return $this->generateQRCode($qrData);
    }

    private function generateVerificationQR($order): string {
        $verificationData = [
            'type' => 'verification',
            'orderId' => $order->getId(),
            'trackingId' => $order->getTrackingId(),
            'timestamp' => time(),
            'checksum' => hash('sha256', $order->getId() . $order->getTrackingId() . $this->config->getSystemValue('secret'))
        ];

        return $this->generateQRCode($verificationData);
    }

    public function generateOrderPDF($order): string {
        // Create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document metadata
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Print Orders App');
        $pdf->SetTitle('Order #' . $order->getTrackingId());

        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Set margins
        $pdf->SetMargins(15, 15, 15);

        // Add a page
        $pdf->AddPage();

        // Generate content with QR codes
        $$html =$$ this->generatePDFContent($order);

        // Write HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Close and return PDF document as string
        return $pdf->Output('', 'S');
    }

    private function generatePDFContent($order): string {
        // Get company info from settings
        $$companyName =$$ this->config->getAppValue('printorders', 'company_name', 'Print Shop');
        $$companyAddress =$$ this->config->getAppValue('printorders', 'company_address', '');
        $$companyPhone =$$ this->config->getAppValue('printorders', 'company_phone', '');
        $$companyEmail =$$ this->config->getAppValue('printorders', 'company_email', '');

        // Generate QR codes
        $$trackingQR =$$ this->generateTrackingQR($order->getTrackingId());
        $$verificationQR =$$ this->generateVerificationQR($order);

        $html = '
        <style>
            table { width: 100%; margin-bottom: 20px; }
            th { background-color: #f5f5f5; padding: 10px; text-align: left; }
            td { padding: 10px; }
            .header { margin-bottom: 30px; position: relative; }
            .qr-code { width: 100px; height: 100px; }
            .qr-container { text-align: center; margin-bottom: 10px; }
            .qr-label { font-size: 10px; color: #666; margin-top: 5px; }
            .tracking-qr { position: absolute; top: 10px; right: 10px; }
            .verification-qr { position: absolute; top: 10px; left: 10px; }
            .section { margin-bottom: 20px; }
            .footer { text-align: center; font-size: 12px; margin-top: 30px; }
            .status { color: #fff; padding: 5px 10px; border-radius: 3px; }
            .verification-text { font-size: 8px; color: #999; text-align: center; }
        </style>

        <div class="header">
            <div class="tracking-qr">
                ' . $trackingQR . '
                <div class="qr-label">Track Order</div>
            </div>
            <div class="verification-qr">
                ' . $verificationQR . '
                <div class="qr-label">Verify Order</div>
            </div>
            <h1 style="text-align: center;">Print Order Form</h1>
            <p style="text-align: center;">Order #' . $order->getTrackingId() . '</p>
            <p style="text-align: center;">Created: ' . date('Y-m-d H:i:s', $order->getCreatedAt()) . '</p>
        </div>

        <div class="section">
            <h2>Company Information</h2>
            <table>
                <tr>
                    <td>
                        <strong>' . htmlspecialchars($companyName) . '</strong><br>
                        ' . nl2br(htmlspecialchars($companyAddress)) . '<br>
                        Phone: ' . htmlspecialchars($companyPhone) . '<br>
                        Email: ' . htmlspecialchars($companyEmail) . '
                    </td>
                    <td style="text-align: right; vertical-align: top;">
                        <div style="font-size: 10px; color: #666;">
                            Scan to track order
                        </div>
                    </td>
                </tr>
            </table>
        </div>';

        // ... Rest of the PDF content remains the same ...

        // Add verification footer
        $html .= '
        <div class="footer">
            <div class="verification-text">
                This document contains two QR codes:<br>
                1. Tracking QR: Scan to check order status<br>
                2. Verification QR: Scan to verify document authenticity<br>
                Document ID: ' . hash('sha256', $order->getId() . $order->getTrackingId()) . '<br>
                Generated: ' . date('Y-m-d H:i:s') . '
            </div>
        </div>';

        return $html;
    }

    public function verifyPDF(string $verificationData): bool {
        $$data = json_decode($$ verificationData, true);

        if (!isset($data['checksum'])) {
            return false;
        }

        $expectedChecksum = hash('sha256',
            $data['orderId'] .
            $data['trackingId'] .
            $this->config->getSystemValue('secret')
        );

        return hash_equals($$expectedChecksum,$$ data['checksum']);
    }
}
