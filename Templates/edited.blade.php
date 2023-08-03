<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $invoice->name }}</title>
    <style>
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .header {
            width: 100%;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .left-container {
            float: left;
            width: 250pt;
        }

        .header-right-container {
            float: right;
        }

        .float-left {
            float: left !important;
        }


        .border-none {
            border: none !important;
        }

        .p-0 {
            padding: 0 !important;
        }

        .m-5 {
            margin: 5px !important;
        }

        .ml-10 {
            margin-left: 10px !important;
        }

        .ml-30 {
            margin-left: 28px !important;
        }

        .ml-40 {
            margin-left: 40px !important;
        }

        .font-strong {
            font-weight: bold !important;
        }

        .w-100 {
            width: 100% !important;
        }

        .v-top {
            vertical-align: top !important;
        }

        h1, h2, h3, h4, h5, h6, p, span, div {
            font-family: DejaVu Sans;
            font-size: 12px;
            font-weight: normal;
        }

        th, td {
            font-family: DejaVu Sans;
            font-size: 12px;
        }

        .panel {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .panel-default {
            border-color: #ddd;
        }

        .panel-body {
            padding: 15px;
        }

        table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 0px;
            border-spacing: 0;
            border-collapse: collapse;
            background-color: transparent;

        }

        thead {
            text-align: left;
            display: table-header-group;
            vertical-align: middle;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        .well {
            min-height: 20px;
            padding: 19px;
            margin-bottom: 20px;
            background-color: #f5f5f5;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
        }

        .success-text {
            color: green
        }

        .warning-text {
            color: #F59E0B;
        }

        .danger-text {
            color: #EF4444;
        }

        .refunded-text {
            color: rgba(0, 0, 0, 0.7);
        }

    </style>
    @if($invoice->duplicate_header)
        <style>
            @page {
                margin-top: 140px;
            }

            header {
                top: -100px;
                position: fixed;
            }
        </style>
    @endif
</head>
<body>
<header class="header">

    <div class="left-container">
        <img class="img-rounded" height="{{ $invoice->logo_height }}" src="{{ $invoice->logo }}">
    </div>
    <div class="header-right-container">
        <strong>{{ $invoice->business_details->get('name') }}</strong><br/>
        {{ $invoice->business_details->get('line1') }}<br/>
        {{ $invoice->business_details->get('line2') }}<br/>
    </div>
    <div style="clear: both;"></div>
</header>
<main>
    <div style="clear:both; position:relative;">
        <table>
            <tr>
                <td class="border-none p-0 v-top" style="">
                    <div class="panel panel-default" style="height: 130px;">
                        <div class="panel-body">
                            <h4 style="margin-bottom: 10px;margin-top:0;">Invoice To:</h4>
                            {!! $invoice->customer_details->count() == 0 ? '<i>No customer details</i><br />' : '' !!}
                            <strong>{{ $invoice->customer_details->get('company') }}</strong><br/>
                            {{ $invoice->customer_details->get('streetAddress') }}<br/>
                            {!! empty($invoice->customer_details->get('streetExtra')) ? '' : $invoice->customer_details->get('streetExtra') . "<br>" !!}
                            {{ $invoice->customer_details->get('city') }} {{ $invoice->customer_details->get('state') }} {{ $invoice->customer_details->get('country') }}
                            {{ $invoice->customer_details->get('postCode') }}
                            <br/>
                        </div>
                    </div>
                </td>
                <td class="p-0 v-top border-none" style="position: relative;">
                    <div class="panel ml-40 panel-default" style="height: 130px;">
                        <div class="panel-body">
                            <div class="w-100 m-5">
                                <span class="font-strong">Date</span>
                                <span class="ml-40">: </span>
                                <span class="">{{ $invoice->date->formatLocalized('%A %d %B %Y') }}</span>
                            </div>

                            @if ($invoice->due_date)
                                <b>Due date: </b>{{ $invoice->due_date->formatLocalized('%A %d %B %Y') }}<br/>
                            @endif
                            @if ($invoice->number)
                                <div class="w-100" style="margin: 5px 5px 5px 5px!important;">
                                    <span class="font-strong">Invoice #</span>
                                    <span class="ml-10">: </span>
                                    <span>{{ $invoice->number }}</span>
                                </div>
                            @endif
                            <div class="w-100 m-5">
                                <span class="font-strong">Currency</span>
                                <span class="ml-10">: </span>
                                <span class="">{{ $invoice->currency  }}</span>
                            </div>
                            <div class="w-100" style="margin: 5px 5px 15px 5px!important;">
                                <span class="font-strong">Status</span>
                                <span class="ml-30">: </span>
                                <span class="{{$invoice->statusClass}} font-strong">{{ $invoice->status  }}</span>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

    </div>
    <h4>Items:</h4>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th style="width: 20pt;">#</th>
            <th>Item Name</th>
            <th style="width: 100pt; text-align: center;">Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoice->items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->get('name') }}</td>
                <td style="text-align: center;">{{ $item->get('totalPrice') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div style="clear:both; position:relative;">
        @if($invoice->notes)
            <div style="position:absolute; left:0pt; width:250pt;">
                <h4>Notes:</h4>
                <div class="panel panel-default">
                    <div class="panel-body">
                        {{ $invoice->notes }}
                    </div>
                </div>
            </div>
        @endif
        <div style="margin-left: 300pt;">
            <h4>Total:</h4>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td><b>TOTAL</b></td>
                    <td>{{ $invoice->totalPriceFormatted() }}</td>
                </tr>
                <tr>
                    <td><b>PAID</b></td>
                    <td>{{ $invoice->totalPaidFormatted() }}</td>
                </tr>
                <tr>
                    <td><b>DUE</b></td>
                    <td><b>{{ $invoice->currentDueFormatted() }}</b></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="" style="margin: 20px 0 20px 0;">
        <h4>Payments</h4>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 20pt;">#</th>
                <th>Date</th>
                <th style="width: 150pt;">Description</th>
                <th>ID</th>
                <th style="width: 100pt; text-align: center;">Amount</th>
            </tr>
            </thead>
            <tbody>
            @if (count($invoice->payments) > 0)
                @foreach ($invoice->payments as $payment)
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $payment['updated_at']->formatLocalized('%d %B %Y') }}</td>
                    <td>{{ $payment['description'] }}</td>
                    <td>{{ $payment['charge_id'] }}</td>
                    <td style="text-align: center;">{{ $invoice->formatCCY($payment['amount']) }}</td>
                @endforeach
            @else
                <td colspan="5">No payments found!</td>
            @endif
            </tbody>
        </table>
    </div>
    @if ($invoice->footnote)
        <br/><br/>
        <div class="well">
            {{ $invoice->footnote }}
        </div>
    @endif
</main>

<!-- Page count -->
<script type="text/php">
            if (isset($pdf) && $GLOBALS['with_pagination'] && $PAGE_COUNT > 1) {
                $pageText = "{PAGE_NUM} of {PAGE_COUNT}";
                $pdf->page_text(($pdf->get_width()/2) - (strlen($pageText) / 2), $pdf->get_height()-20, $pageText, $fontMetrics->get_font("DejaVu Sans, Arial, Helvetica, sans-serif", "normal"), 7, array(0,0,0));
            }


































</script>
</body>
</html>
