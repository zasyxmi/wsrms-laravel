<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Repair Request Approved</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.6; margin: 0; padding: 0;">
    <div style="max-width: 640px; margin: 0 auto; padding: 24px;">
        <h2 style="margin-top: 0; color: #1f2937;">WSRMS Workshop</h2>

        <p>Hi {{ $repairRequest->customer->user->name }},</p>

        <p>
            Your repair request has been approved. Please bring your device to our workshop
            for physical inspection and diagnosis.
        </p>

        <p>
            The online request records the initial symptoms only. The actual technical issue
            will be confirmed after our technician checks the device.
        </p>

        <table style="border-collapse: collapse; width: 100%; margin: 20px 0;">
            <tr>
                <td style="border: 1px solid #ddd; padding: 10px; font-weight: bold; width: 35%;">Repair Request</td>
                <td style="border: 1px solid #ddd; padding: 10px;">{{ $repairRequest->repair_code }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #ddd; padding: 10px; font-weight: bold;">Device Type</td>
                <td style="border: 1px solid #ddd; padding: 10px;">{{ $repairRequest->device->device_type ?? '-' }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #ddd; padding: 10px; font-weight: bold;">Device</td>
                <td style="border: 1px solid #ddd; padding: 10px;">
                    {{ trim(($repairRequest->device->brand ?? '') . ' ' . ($repairRequest->device->model ?? '')) ?: '-' }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #ddd; padding: 10px; font-weight: bold;">Assigned Technician</td>
                <td style="border: 1px solid #ddd; padding: 10px;">
                    {{ $repairRequest->technician?->user?->name ?? 'Pending assignment' }}
                </td>
            </tr>
        </table>

        <p>
            Thank you,<br>
            WSRMS Workshop
        </p>
    </div>
</body>
</html>
