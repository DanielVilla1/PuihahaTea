<?php

namespace App\Services;

class PaymentService
{
    /**
     * Simulate payment authorization capturing minimal meta info.
     * Returns array with ok, reference, sanitized data.
     */
    public function authorize(int $customerId, string $method, array $data): array
    {
        if ($customerId <= 0) {
            return ['ok' => false, 'error' => 'Invalid customer'];
        }
        $method = strtolower(trim($method));
        if (! in_array($method, ['credit', 'debit', 'ebank'], true)) {
            return ['ok' => false, 'error' => 'Unsupported method'];
        }
        // Basic normalization
        $clean = [];
        switch ($method) {
            case 'credit':
            case 'debit':
                $holder = trim((string) ($data['card_holder'] ?? ''));
                $last4  = preg_replace('/[^0-9]/', '', (string) ($data['card_last4'] ?? ''));
                $last4  = substr($last4, -4);
                if ($holder === '' || strlen($last4) !== 4) {
                    return ['ok' => false, 'error' => 'Card details incomplete'];
                }
                $clean = ['card_holder' => $holder, 'card_last4' => $last4];
                break;
            case 'ebank':
                $bank = trim((string) ($data['bank_name'] ?? ''));
                $ref  = trim((string) ($data['bank_ref'] ?? ''));
                if ($bank === '' || $ref === '') {
                    return ['ok' => false, 'error' => 'Bank info required'];
                }
                $clean = ['bank_name' => $bank, 'bank_ref' => $ref];
                break;
        }
        $reference = strtoupper($method) . '-' . substr(sha1(json_encode([$customerId, $method, $clean, microtime(true)])), 0, 12);
        return [
            'ok' => true,
            'reference' => $reference,
            'method' => $method,
            'meta' => $clean,
        ];
    }
}
