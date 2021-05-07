<!DOCTYPE html>
<html>
<body>

<table>
    <tr>
        <td width="25">ID</td>
        <td>: {{$detail['promo_payment_gateway_code']}}</td>
    </tr>
    <tr>
        <td width="25">Name</td>
        <td>: {{$detail['name']}}</td>
    </tr>
    <tr>
        <td>Payment Gateway</td>
        <td>: {{$detail['payment_gateway']}}</td>
    </tr>
    <tr>
        <td>Periode</td>
        <td>: {{date('d-M-Y', strtotime($detail['start_date']))}} / {{date('d-M-Y', strtotime($detail['end_date']))}}</td>
    </tr>
    <tr>
        <td>Total Limit</td>
        <td>: {{$detail['limit_promo_total']}}</td>
    </tr>
    <tr>
        <?php
        $var = [
            'day' => 'Limit maximum per day',
            'week' => 'Limit maximum per week',
            'month' => 'Limit maximum per month',
            'account' => 'Limit maximum per account'
        ];
        ?>
        <td>Additional Limit</td>
        <td>:
            @if(empty($detail['limit_promo_additional']))
                -
            @else
                {{$detail['limit_promo_additional']}} ({{$var[$detail['limit_promo_additional_type']]??""}})</td>
        @endif
    </tr>
    <tr>
        <td>Cashback</td>
        <td>: @if($detail['cashback_type'] == 'Nominal') {{ number_format($detail['cashback'],0,",","") }} @else {{ $detail['cashback'] }} @endif {{$detail['cashback_type']}}</td>
    </tr>
    <tr>
        <td>Maximum Cashback</td>
        <td>: {{number_format($detail['maximum_cashback'])}}</td>
    </tr>
    <tr>
        <td>Minimum Transaction</td>
        <td>: {{number_format($detail['minimum_transaction'])}}</td>
    </tr>
    <tr>
        <td>Charged Payment Gateway</td>
        <td>: @if($detail['charged_type'] == 'Nominal') {{ number_format($detail['charged_payment_gateway'],0,",","") }} @else {{ $detail['charged_payment_gateway'] }} @endif {{$detail['charged_type']}}</td>
    </tr>
    <tr>
        <td>Charged Jiwa Group</td>
        <td>: @if($detail['charged_type'] == 'Nominal') {{ number_format($detail['charged_jiwa_group'],0,",","") }} @else {{ $detail['charged_jiwa_group'] }} @endif {{$detail['charged_type']}}</td>
    </tr>
    <tr>
        <td>Charged Central</td>
        <td>: @if($detail['charged_type'] == 'Nominal') {{ number_format($detail['charged_central'],0,",","") }} @else {{ $detail['charged_central'] }} @endif {{$detail['charged_type']}}</td>
    </tr>
    <tr>
        <td>Charged Outlet</td>
        <td>: @if($detail['charged_type'] == 'Nominal') {{ number_format($detail['charged_outlet'],0,",","") }} @else {{ $detail['charged_outlet'] }} @endif {{$detail['charged_type']}}</td>
    </tr>
</table>
<br>

<table style="border: 1px solid black">
    <thead>
        <tr>
            <th style="background-color: #dcdcdc;" width="25"> Customer name</th>
            <th style="background-color: #dcdcdc;" width="25"> Customer phone</th>
            <th style="background-color: #dcdcdc;" width="25"> Customer account PG</th>
            <th style="background-color: #dcdcdc;" width="25"> Receipt number </th>
            <th style="background-color: #dcdcdc;" width="25"> Outlet </th>
            <th style="background-color: #dcdcdc;" width="25"> Chasback Received </th>
        </tr>
    </thead>
    <tbody>
    @if(!empty($data))
        @foreach($data as $key => $res)
            <tr style="background-color: #fbfbfb;">
                <td> {{ $res['customer_name'] }} </td>
                <td> {{ $res['customer_phone'] }} </td>
                <td> {{ $res['payment_gateway_user'] }} </td>
                <td> {{ $res['transaction_receipt_number'] }} </td>
                <td> {{ $res['outlet_code'] }} - {{ $res['outlet_name'] }} </td>
                <td> {{ number_format($res['total_received_cashback'],2,",",".") }} </td>
            </tr>
        @endforeach
    @else
        <tr style="text-align: center"><td colspan="5">Data Not Available</td></tr>
    @endif
    </tbody>
</table>

</body>
</html>

