<!DOCTYPE html>
<html lang="nl">

    <head>
        <meta charset="UTF-8">
        <title>Bestelling PDF</title>
        <style>
            @page {
                size: 8.5cm 10cm;
                margin: 0.5cm;
            }

            body {
                width: 7.5cm;
                height: 9cm;
                margin: 0;
                padding: 0;
                font-family: 'Segoe UI', Arial, sans-serif;
                font-size: 12px;
                color: #222;
                background: #fff;
            }

            .header {
                text-align: center;
                margin-bottom: 10px;
            }

            .logo {
                display: block;
                margin: 0 auto 4px auto;
                width: 40px;
                height: 40px;
                object-fit: contain;
            }

            .order-title {
                font-size: 16px;
                font-weight: bold;
                margin-bottom: 2px;
                letter-spacing: 1px;
            }

            .order-date {
                font-size: 11px;
                color: #666;
                margin-bottom: 10px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 10px;
                background: #fafafa;
                border-radius: 4px;
                overflow: hidden;
            }

            th,
            td {
                padding: 4px 6px;
            }

            th {
                border-bottom: 1px solid #bbb;
                background: #f0f0f0;
                text-align: left;
                font-size: 12px;
                font-weight: 600;
            }

            td {
                vertical-align: top;
                font-size: 12px;
            }

            .text-right {
                text-align: right;
            }

            .desc {
                font-size: 9px;
                color: #888;
                margin-top: 2px;
            }

            .total-row {
                border-top: 2px solid #000;
                font-weight: bold;
                background: #f6f6f6;
            }

            .page-break {
                page-break-after: always;
            }

            .footer {
                text-align: center;
                font-size: 10px;
                color: #aaa;
                margin-top: 10px;
            }
        </style>
    </head>

    <body>
        <div class="header">
            <img class="logo" src="{{ asset('assets/img/dragon-small.png') }}" alt="Gouden Draak Logo">
            <div class="order-title">Bestelling #{{ $order->id ?? '' }}</div>
            <div class="order-date">{{ $order->date_placed ?? '' }}</div>
        </div>

        @php
            $total = 0;
            $order->load(['items.menuItem', 'parts.items.menuItem']);
        @endphp

        @if ($order->parts && $order->parts->count())
            <h2 style="margin-bottom: 6px; font-size: 15px; color: #333;">Rekening gesplitst in {{ $order->parts->count() }} delen:</h2>
            @foreach ($order->parts as $part)
                @if ($part->items->count())
                    <div style="margin-bottom: 10px;">
                        <div style="font-weight: bold; color: #444;">Deel {{ $part->part_number }}</div>
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 45%;">Naam</th>
                                    <th class="text-right" style="width: 15%;">Aantal</th>
                                    <th class="text-right" style="width: 20%;">Prijs</th>
                                    <th class="text-right" style="width: 20%;">Subtotaal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $partTotal = 0; @endphp
                                @foreach ($part->items as $item)
                                    @php
                                        $menuItem = $item->menuItem;
                                        $lineTotal = $menuItem->price * $item->amount;
                                        $partTotal += $lineTotal;
                                    @endphp
                                    <tr>
                                        <td>{!! $menuItem->name !!}</td>
                                        <td class="text-right">{{ $item->amount }}</td>
                                        <td class="text-right">&euro;{{ number_format($menuItem->price, 2) }}</td>
                                        <td class="text-right">&euro;{{ number_format($lineTotal, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="total-row">
                                    <td colspan="3">Totaal deel {{ $part->part_number }}</td>
                                    <td class="text-right">&euro;{{ number_format($partTotal, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            @endforeach
        @else
            <table>
                <thead>
                    <tr>
                        <th style="width: 45%;">Naam</th>
                        <th class="text-right" style="width: 15%;">Aantal</th>
                        <th class="text-right" style="width: 20%;">Prijs</th>
                        <th class="text-right" style="width: 20%;">Subtotaal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        @php
                            $menuItem = $item->menuItem;
                            $lineTotal = $menuItem->price * $item->amount;
                            $total += $lineTotal;
                        @endphp

                        <tr>
                            <td>
                                <div>{!! $menuItem->name !!}</div>

                                @if ($menuItem->description)
                                    <div class="desc">{!! $menuItem->description !!}</div>
                                @endif
                            </td>
                            <td class="text-right">{{ $item->amount }}</td>
                            <td class="text-right">&euro;{{ number_format($menuItem->price, 2) }}</td>
                            <td class="text-right">&euro;{{ number_format($lineTotal, 2) }}</td>
                        </tr>

                        @if ($loop->last)
                            <tr class="total-row">
                                <td colspan="3">Totaal</td>
                                <td class="text-right">&euro;{{ number_format($total, 2) }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif

        <div class="footer">
            Bedankt voor uw bestelling!

            @if (isset($qrCode))
                <div style="margin-top: 8px;">
                    <div>Geef uw mening:</div>
                    <img src="{{ $qrCode }}" alt="Review QR Code" style="width:60px;height:60px;display:block;margin:4px auto 0 auto;">
                </div>
            @endif
        </div>
    </body>

</html>
