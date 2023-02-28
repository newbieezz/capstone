<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>P-Store Mart</title>
</head>
<body> <br><br>
    <table style="width:700px;">
        <tr><td>&nbsp;</td></tr>
        <tr><td><img src="{{ asset('admin/images/logo.png') }}"></td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Hello {{ $name }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Thank you for your purchase! Your order details are as below : </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>Order no.  {{ $order_id }}</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>
            <table style="width:95%" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
                <tr bgcolor="#cccccc">
                    <td>Product Name</td>
                    <td>Product Code</td>
                    <td>Product Size</td>
                    <td>Product Quantity</td>
                    <td>Product Price</td>
                </tr>
                @foreach ($orderDetails['order_products'] as $order)
                <tr bgcolor="#cccccc">
                    <td>{{ $order['product_name'] }}</td>
                    <td>{{ $order['product_code'] }}</td>
                    <td>{{ $order['product_size'] }}</td>
                    <td>{{ $order['product_qty'] }}</td>
                    <td>{{ $order['product_price'] }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" align="right">Delivery Fee</td>
                    <td>₱ {{ $orderDetails['delivery_fee'] }}</td>
                </tr>
                <tr>
                    <td colspan="5" align="right">Total Amount</td>
                    <td>₱ {{ $orderDetails['grand_total'] }}</td>
                </tr>
            </table>
        </td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
    </table>
</body>
</html>

