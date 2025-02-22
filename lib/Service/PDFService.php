<?php

namespace OCA\PrintOrders\Service;

class PDFService {
    // Other methods...

    public function verifyPDF(string $verificationData): bool {
        $data = json_decode($verificationData, true);

        if (!isset($data['checksum'])) {
            return false;
        }

        $expectedChecksum = hash('sha256',
            $data['orderId'] .
            $data['trackingId'] .
            $this->config->getSystemValue('secret')
        );

        return hash_equals($expectedChecksum, $data['checksum']);
    }
}