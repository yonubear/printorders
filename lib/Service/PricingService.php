<?php

namespace OCA\PrintOrders\Service;

class PricingService {
    // Other methods...

    public function calculatePrice(array $orderData): array {
        $selectedPaper = array_filter($paperGrades, function($grade) use ($orderData) {
            return $grade['id'] === $orderData['paperGradeId'];
        });
        $selectedPaper = reset($selectedPaper);

        // Calculate square footage
        $sqft = ($orderData['width'] * $orderData['length']) / 144;
        $paperCost = $sqft * $selectedPaper['pricePerSqFt'] * $orderData['quantity'];

        // Calculate color costs
        $colorCost = 0;
        if ($orderData['colorOption'] === 'fullColor') {
            $colorCost = $sqft * 0.25 * $orderData['quantity'];
        } elseif ($orderData['colorOption'] === 'spotColor') {
            $colorCost = $sqft * 0.15 * $orderData['quantity'];
        }

        // Calculate finishing costs
        $finishingCost = 0;
        $finishing = json_decode($orderData['finishing'], true) ?? [];
        
        foreach ($finishing as $finish) {
            switch ($finish) {
                case 'stapling':
                    $finishingCost += 0.05 * $orderData['quantity'];
                    break;
                case 'binding':
                    $finishingCost += 2.00 * $orderData['quantity'];
                    break;
                case 'lamination':
                    $finishingCost += $sqft * 0.50 * $orderData['quantity'];
                    break;
                case 'folding':
                    $finishingCost += 0.03 * $orderData['quantity'];
                    break;
            }
        }

        // Double-sided pricing adjustment
        if ($orderData['sides'] === 'double') {
            $paperCost *= 1.2; // 20% increase for double-sided
        }

        $subtotal = $paperCost + $colorCost + $finishingCost;
        $tax = $subtotal * 0.10; // 10% tax

        return [
            'sqft' => $sqft,
            'paperCost' => $paperCost,
            'colorCost' => $colorCost,
            'finishingCost' => $finishingCost,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $subtotal + $tax
        ];
    }

    public function getPriceBreakdown(array $orderData): array {
        $price = $this->calculatePrice($orderData);
        
        $breakdown = [
            [
                'label' => 'Paper Cost',
                'description' => sprintf('%.2f sq.ft @ $%.2f/sq.ft', 
                    $price['sqft'], 
                    $orderData['paperGrade']['pricePerSqFt']
                ),
                'amount' => $price['paperCost']
            ]
        ];

        if ($price['colorCost'] > 0) {
            $breakdown[] = [
                'label' => 'Color Printing',
                'description' => $orderData['colorOption'] === 'fullColor' 
                    ? 'Full Color' 
                    : 'Spot Color',
                'amount' => $price['colorCost']
            ];
        }

        if ($price['finishingCost'] > 0) {
            $breakdown[] = [
                'label' => 'Finishing',
                'description' => implode(', ', json_decode($orderData['finishing'], true)),
                'amount' => $price['finishingCost']
            ];
        }

        return $breakdown;
    }
}