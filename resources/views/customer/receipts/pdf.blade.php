<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $payment->receipt_number }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
            margin: 30px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #111827;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .header p {
            margin: 5px 0 0;
            color: #4b5563;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            padding: 8px;
            border: 1px solid #d1d5db;
            vertical-align: top;
        }

        th {
            background-color: #f3f4f6;
            text-align: left;
        }

        .no-border td {
            border: none;
            padding: 5px 0;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
            background-color: #f3f4f6;
        }

        .paid-badge {
            display: inline-block;
            padding: 5px 10px;
            background-color: #dcfce7;
            color: #166534;
            border-radius: 5px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            color: #6b7280;
            font-size: 11px;
            border-top: 1px solid #d1d5db;
            padding-top: 15px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Workshop Repair Service Management System</h1>
        <p>Official Payment Receipt</p>
    </div>

    <div class="section">
        <table class="no-border">
            <tr>
                <td>
                    <strong>Receipt Number:</strong><br>
                    {{ $payment->receipt_number }}
                </td>
                <td class="text-right">
                    <span class="paid-badge">PAID</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Payment Information</div>

        <table>
            <tr>
                <th>Payment Number</th>
                <td>{{ $payment->payment_number }}</td>
            </tr>
            <tr>
                <th>Invoice Number</th>
                <td>{{ $payment->invoice->invoice_number }}</td>
            </tr>
            <tr>
                <th>Repair Code</th>
                <td>{{ $payment->invoice->repairRequest->repair_code }}</td>
            </tr>
            <tr>
                <th>Payment Date</th>
                <td>{{ $payment->paid_at ? $payment->paid_at->format('d M Y, h:i A') : '-' }}</td>
            </tr>
            <tr>
                <th>Payment Method</th>
                <td>{{ ucwords($payment->payment_method) }}</td>
            </tr>
            <tr>
                <th>Transaction Reference</th>
                <td>{{ $payment->transaction_reference }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Customer and Device Information</div>

        <table>
            <tr>
                <th>Customer Name</th>
                <td>{{ $payment->customer->user->name }}</td>
            </tr>
            <tr>
                <th>Customer Email</th>
                <td>{{ $payment->customer->user->email }}</td>
            </tr>
            <tr>
                <th>Device</th>
                <td>
                    {{ $payment->invoice->repairRequest->device->brand }}
                    {{ $payment->invoice->repairRequest->device->model }}
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Payment Breakdown</div>

        <table>
            <tr>
                <td>Diagnosis Fee</td>
                <td class="text-right">RM {{ number_format($payment->invoice->diagnosis_fee, 2) }}</td>
            </tr>
            <tr>
                <td>Service Charge</td>
                <td class="text-right">RM {{ number_format($payment->invoice->service_charge, 2) }}</td>
            </tr>
            <tr>
                <td>Spare Part Total</td>
                <td class="text-right">RM {{ number_format($payment->invoice->spare_part_total, 2) }}</td>
            </tr>
            <tr>
                <td>Additional Charge</td>
                <td class="text-right">RM {{ number_format($payment->invoice->additional_charge, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>Total Paid</td>
                <td class="text-right">RM {{ number_format($payment->amount_paid, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Thank you for using our workshop repair service.</p>
        <p>This receipt was generated automatically by the system after successful payment.</p>
    </div>

</body>
</html>