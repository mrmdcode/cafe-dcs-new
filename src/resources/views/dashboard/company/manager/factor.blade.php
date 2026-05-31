<!DOCTYPE html>
<html dir="rtl" lang="fa">

<head>
    <meta charset="UTF-8">
    <title>فاکتور سفارش #{{ $order->id }}</title>
    <style>
       
        body {
            font-family: 'Vazir', Tahoma, sans-serif;
            margin: 0;
            padding: 20px;
            background: #fff;
        }

        .factor-box {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .totals {
            margin-top: 20px;
            text-align: left;
            font-size: 16px;
        }

        .totals div {
            margin-bottom: 6px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        @media print {
            body {
                padding: 0;
                margin: 0;
            }

            .factor-box {
                border: none;
                box-shadow: none;
                padding: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="factor-box">
        <div class="header">
            <div class="company-name">{{ $company->name ?? 'شرکت' }}</div>
            <div>فاکتور رسمی</div>
        </div>

        <div class="info-row">
            <span><strong>شماره سفارش:</strong> {{ $order->id }}</span>
            <span><strong>تاریخ:</strong> {{ $order->created_at->format('Y/m/d H:i') }}</span>
        </div>
        <div class="info-row">
            <span><strong>میز:</strong> {{ $order->table->name ?? '-' }}</span>
            <span><strong>پذیرنده:</strong> {{ $order->order_recipient->name ?? '-' }}</span>
        </div>
        <div class="info-row">
            <span><strong>مشتری:</strong> {{ $order->customer->name ?? 'عمومی' }}</span>
            <span><strong>وضعیت:</strong>
                @switch($order->status)
                    @case('registration')
                        در حال ثبت
                    @break

                    @case('cancelled')
                        لغو شده
                    @break

                    @case('edit')
                        در حال ویرایش
                    @break

                    @case('finish')
                        آماده تحویل
                    @break

                    @case('paid')
                        پرداخت شده
                    @break

                    @default
                        {{ $order->status }}
                @endswitch
            </span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام محصول</th>
                    <th>تعداد</th>
                    <th>قیمت واحد (ریال)</th>
                    <th>قیمت کل (ریال)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ number_format($item['qty']) }}</td>
                        <td>{{ number_format($item['price']) }}</td>
                        <td>{{ number_format($item['total']) }}</td>
                    </tr>
                    @if ($item['description'])
                        <tr>
                            <td colspan="5" style="background:#fcfcfc; text-align:right;">
                                توضیحات: {{ $item['description'] }}
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">هیچ آیتمی یافت نشد</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="totals">
            <div>جمع کل: {{ number_format($subtotal) }} ریال</div>
            <div>تخفیف: {{ number_format($discount) }} ریال</div>
            <div><strong>قابل پرداخت: {{ number_format($grandTotal) }} ریال</strong></div>
        </div>

        <div class="footer">
            با تشکر از شما - بازگشت شما مایه افتخار ماست
            <br>
            <button class="no-print" onclick="window.print()" style="margin-top:15px; padding:5px 15px;">چاپ
                فاکتور</button>
        </div>
    </div>
</body>

</html>
