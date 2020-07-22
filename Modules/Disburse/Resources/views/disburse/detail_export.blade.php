<!DOCTYPE html>
<html>
<body>

<table>
    <tr>
        <td width="30">Date</td>
        <td>: {{ date('d M Y H:i', strtotime($disburse['created_at'])) }}</td>
    </tr>
    <tr>
        <td width="30">Outlet</td>
        <td>: {{$disburse['outlet_code']}} - {{$disburse['outlet_name']}}</td>
    </tr>
    <tr>
        <td width="30">Status</td>
        @if($disburse['disburse_status'] == 'Fail')
            <td>: <b  style="color: red">{{ $disburse['disburse_status'] }}</b></td>
        @else
            <td>: <b style="color: green">{{ $disburse['disburse_status'] }}</b></td>
        @endif
    </tr>
    <tr>
        <td width="30">Bank Name</td>
        <td>: {{$disburse['bank_name']}}</td>
    </tr>
    <tr>
        <td width="30">Account Number</td>
        <td>: {{$disburse['beneficiary_account_number']}}</td>
    </tr>
    <tr>
        <td width="30">Recipient Name</td>
        <td>: {{$disburse['beneficiary_name']}}</td>
    </tr>
    <tr>
        <td width="30" style="font-size: 22px"><b>Nominal</b></td>
        <td style="font-size: 22px"><b>: {{number_format($disburse['disburse_nominal'], 2)}}</b></td>
    </tr>
</table>
<br>

<table style="border: 1px solid black">
    <thead>
    <tr>
        <th style="background-color: #dcdcdc;"> Recipient Number </th>
        <th style="background-color: #dcdcdc;" width="20"> Transaction Date </th>
        <th style="background-color: #dcdcdc;" width="20"> Income Outlet </th>
        <th style="background-color: #dcdcdc;" width="20"> Sub Total </th>
        <th style="background-color: #dcdcdc;" width="20"> Grand Total </th>
        <th style="background-color: #dcdcdc;" width="20"> Fee Item </th>
        <th style="background-color: #dcdcdc;" width="20"> Discount </th>
        <th style="background-color: #dcdcdc;" width="20"> Delivery </th>
        <th style="background-color: #dcdcdc;" width="20"> Payment Charge </th>
        <th style="background-color: #dcdcdc;" width="20"> Point Use Charge </th>
        <th style="background-color: #dcdcdc;" width="20"> Subcriptions Charge </th>
    </tr>
    </thead>
    <tbody>
    @if(!empty($list_trx))
        @foreach($list_trx as $val)
            <tr>
                <td style="text-align: left">
                    {{ $val['transaction_receipt_number']??'' }}
                </td>
                <td style="text-align: left">{{ date('d M Y H:i', strtotime($val['transaction_date'])) }}</td>
                <td style="text-align: left">{{number_format($val['income_outlet'], 2)}}</td>
                <td style="text-align: left">{{number_format($val['transaction_subtotal'], 2)}}</td>
                <td style="text-align: left">{{number_format($val['transaction_grandtotal'], 2)}}</td>
                <td style="text-align: left">{{number_format($val['fee_item'], 2)}}</td>
                <td style="text-align: left">{{number_format($val['discount'], 2)}}</td>
                <td style="text-align: left">{{number_format($val['transaction_shipment_go_send'], 2)}}</td>
                <td style="text-align: left">{{number_format($val['payment_charge'], 2)}}</td>
                <td style="text-align: left">{{number_format($val['point_use_expense'], 2)}}</td>
                <td style="text-align: left">{{number_format($val['subscription'], 2)}}</td>
            </tr>
        @endforeach
    @else
        <tr><td colspan="10" style="text-align: center">Data Not Available</td></tr>
    @endif
    </tbody>
</table>

</body>
</html>

