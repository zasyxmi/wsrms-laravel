<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Device Ready for Pickup</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.6;">
    <h2>Workshop Repair Service</h2>

    <p>Hi {{ $payment->customer->user->name }},</p>

    <p>
        Your repair request
        <strong>{{ $payment->invoice->repairRequest->repair_code }}</strong>
        has been completed, and your payment for invoice
        <strong>{{ $payment->invoice->invoice_number }}</strong>
        has been received successfully.
    </p>

    <p>
        Your repaired device is now ready for pickup at our workshop.
    </p>

    <h3>Pickup and Payment Details</h3>

    <table style="border-collapse: collapse; width: 100%; max-width: 600px;">
        <tr>
            <td style="border: 1px solid #ddd; padding: 8px;">Device</td>
            <td style="border: 1px solid #ddd; padding: 8px;">
                {{ $payment->invoice->repairRequest->device->brand }}
                {{ $payment->invoice->repairRequest->device->model }}
            </td>
        </tr>

        <tr>
            <td style="border: 1px solid #ddd; padding: 8px;">Receipt Number</td>
            <td style="border: 1px solid #ddd; padding: 8px;">
                {{ $payment->receipt_number }}
            </td>
        </tr>

        <tr>
            <td style="border: 1px solid #ddd; padding: 8px;">Amount Paid</td>
            <td style="border: 1px solid #ddd; padding: 8px;">
                RM {{ number_format($payment->amount_paid, 2) }}
            </td>
        </tr>

        <tr>
            <td style="border: 1px solid #ddd; padding: 8px;">Paid At</td>
            <td style="border: 1px solid #ddd; padding: 8px;">
                {{ $payment->paid_at ? $payment->paid_at->format('d M Y, h:i A') : '-' }}
            </td>
        </tr>
    </table>

    <p>
        Please bring your receipt or payment reference when collecting your device.
    </p>

    <p>
        Thank you for using our workshop repair service.
    </p>

    <p>
        Regards,<br>
        Workshop Repair Service Team
    </p>
</body>
</html>