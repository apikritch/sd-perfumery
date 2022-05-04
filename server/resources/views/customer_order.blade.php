<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <title></title>
  <!--[if mso]>
  <noscript>
    <xml>
      <o:OfficeDocumentSettings>
        <o:PixelsPerInch>96</o:PixelsPerInch>
      </o:OfficeDocumentSettings>
    </xml>
  </noscript>
  <![endif]-->
  <style>
    table, td, div, h1, p {font-family: Arial, sans-serif;}
  </style>
</head>
<body style="margin:0;padding:0;">
  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
    <tr>
      <td align="center" style="padding:0;">
        <table role="presentation" style="width:800px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
          <tr>
            <td align="center" style="padding:40px 0 30px 0;background:#B8DDE3;">
                <h1 style="color: #153643;">Thank you for your order</h1>
              {{-- <img src="https://www.seekpng.com/png/full/430-4307046_forgot-password-icon-png-icon-for-username-and.png" alt="" width="128" style="height:auto;display:block;" /> --}}
            </td>
          </tr>
          <tr>
            <td style="padding:36px 30px 42px 30px; background:#FFFFFF;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;color:#153643;">
                <tr style="border-bottom: 1px solid black;">
                    <th colspan="5"><h2>Order Number: {{$details['id']}}</h2></th>
                </tr>
                <tr style="border-bottom: 1px solid #DEE2E6;text-align: left;">
                    <th colspan="1"><h4>Order Date: <span style="color:#985855;">{{$details['order_date']}}</h4></th>
                    <th colspan="1" style="padding-left: 40px;"><h4>Shipment Status: <span style="color:#639551;">{{$details['order_status']}}</span></h4></th>
                    <th colspan="3" style="padding-left: 40px;"><h4>Order Status: <span style="color:#639551;">{{$details['shippment_status']}}</span></h4></th>
                </tr>
                <tr style="border-bottom: 1px solid #DEE2E6;text-align: center;">
                    <th colspan="5"><h3>Tracking Number: </h3></th>
                </tr>
                <tr style="border-bottom: 1px solid black;">
                  <th></th>
                  <th style="padding: 20px;">Item</th>
                  <th style="padding: 20px; width: 80px;">Price</th>
                  <th style="padding: 20px; width: 80px;">Quantity</th>
                  <th style="padding: 20px; width: 80px;">Total</th>
                </tr>
                @foreach ($details['product'] as $product)
                <tr style="border-bottom: 1px solid #DEE2E6;">
                    <td><img src="{{$product->image}}" alt="" style="width: 80px;"></td>
                    <td style="padding: 20px;">{{$product->title}} | {{$product->type}} | {{$product->gender}} - {{$product->size}} by {{$product->brand}}</td>
                    @if ($product->price == $product->final_price)
                    <td style="padding: 20px;">Rs. {{number_format($product->price)}}</td>
                    <td style="padding: 20px;">{{$product->quantity}}</td>
                    <td style="padding: 20px;">Rs. {{number_format($product->total)}}</td>
                    @else
                    <td style="padding: 20px;"><s>Rs. {{number_format($product->price)}}</s><span style="color: red;"> Rs. {{number_format($product->final_price)}}</span></td>
                    <td style="padding: 20px;">{{$product->quantity}}</td>
                    <td style="padding: 20px;">Rs. {{number_format($product->total)}}</td>
                    @endif
                    
                </tr>
                @endforeach
                
                {{-- <tr style="border-bottom: 1px solid #DEE2E6;">
                    <td><img src="https://theparfumerie.b-cdn.net/wp-content/uploads/2021/08/3274872400733_P036175_IRRESISTIBLE_EAU-DE-PARFUM_80ml_a_01.jpg" alt="" style="width: 80px;"></td>
                    <td style="padding: 20px;">The Only One Intense | Eau De Parfum | Women - 100 by Dolce & Gabbana</td>
                    <td style="padding: 20px;">8450</td>
                    <td style="padding: 20px;">10</td>
                    <td style="padding: 20px;">84500</td>
                </tr>
                <tr style="border-bottom: 1px solid #DEE2E6;">
                    <td><img src="https://theparfumerie.b-cdn.net/wp-content/uploads/2021/08/3274872400733_P036175_IRRESISTIBLE_EAU-DE-PARFUM_80ml_a_01.jpg" alt="" style="width: 80px;"></td>
                    <td style="padding: 20px;">The Only One Intense | Eau De Parfum | Women - 100 by Dolce & Gabbana</td>
                    <td style="padding: 20px;">8450</td>
                    <td style="padding: 20px;">10</td>
                    <td style="padding: 20px;">84500</td>
                </tr> --}}
                
                <tr style="border-bottom: 1px solid #DEE2E6;">
                    <td colspan="2"><h4 style="margin:0;color:#153643;">Subtotal: </h4></td>
                    <td colspan="2" style="padding: 20px;"></td>
                    <td style="padding: 20px;">Rs. {{number_format($details['subtotal'])}}</td>
                </tr>
                <tr style="border-bottom: 1px solid #DEE2E6;">
                    <td colspan="2"><h4 style="margin:0;color:#153643;">Total Saving: </h4></td>
                    <td colspan="2" style="padding: 20px;"></td>
                    <td style="padding: 20px;"><span style="color: red">Rs. {{number_format($details['total_saving'])}}</span></td>
                </tr>
                <tr style="border-bottom: 1px solid #DEE2E6;">
                    <td colspan="2"><h4 style="margin:0;color:#153643;">{{$details['shipping_method']}} Shipping: </h4></td>
                    <td colspan="2" style="padding: 20px;"></td>
                    <td style="padding: 20px;">Rs. {{number_format($details['shipping_fee'])}}</td>
                </tr>
                <tr style="border-bottom: 1px solid #DEE2E6;">
                    <td colspan="2"><h4 style="margin:0;color:#153643;">Total: </h4></td>
                    <td colspan="2" style="padding: 20px;"></td>
                    <td style="padding: 20px;">Rs. {{number_format($details['order_total'])}}</td>
                </tr>
                
              </table>
            </td>
          </tr>



          <tr>
            <td style="padding:10px 30px 42px 30px;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                <tr>
                  <td style="padding:0;width:100%;background:white;">
                    <p style="margin:0;">
                      <h4 style="margin:0;color:#985855;">Payment Method</h4>
                    </p>
                  </td>
                </tr>
                <tr>
                    <td style="padding:0;width:100%;background:white" align="left">
                        <p style="margin:0;color:#153643;padding-right:10px;">
                            Bank: <span style="color:#985855;">{{$details['payment_bank']}}</span><span><br></span>
                            Account Name: <span style="color:#985855;">{{$details['payment_account_name']}}</span><span><br></span>
                            Account Details: <span style="color:#985855;">{{$details['payment_account_detail']}}</span><span><br></span>
                        </p>
                    </td>
                  </tr>
              </table>
            </td>
            
          </tr>
          <!--Delivery and Billing Section-->
          <tr>
            <td style="padding:10px 30px 42px 30px;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                <tr>
                  <td style="padding:0;width:50%;background:white;">
                    <p style="margin:0;">
                      <h4 style="margin:0;color:#985855;">Delivery Address</h4>
                    </p>
                  </td>
                  <td style="padding:0;width:50%;background:white" align="left">
                    <p style="margin:0;">
                      <h4 style="margin:0;color:#985855;">Billing Address</h4>
                    </p>
                  </td>
                </tr>
                <tr>
                    <td style="padding:0;width:50%;background:white" align="left">
                      <p style="margin:0;color:#153643;padding-right:10px;">
                            {{$details['delivery_first_name']}} {{$details['delivery_last_name']}}<br>
                            {{$details['delivery_phone']}}<br>
                            {{$details['delivery_address_1']}},
                            {{$details['delivery_city']}}, {{$details['delivery_state']}}, {{$details['delivery_postcode']}}
                            {{$details['delivery_country']}}
                      </p>
                    </td>
                    <td style="padding:0;width:50%;background:white" align="left">
                        <p style="margin:0;color:#153643;padding-right:10px;">
                            {{$details['billing_first_name']}} {{$details['billing_last_name']}}<br>
                            {{$details['billing_phone']}}<br>
                            {{$details['billing_address_1']}},
                            {{$details['billing_city']}}, {{$details['billing_state']}}, {{$details['billing_postcode']}}
                            {{$details['billing_country']}}
                        </p>
                    </td>
                  </tr>
              </table>
            </td>
            
          </tr>






          <tr>
            <td style="padding:30px;background:#7E979C;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                <tr>
                  <td style="padding:0;width:50%;" align="left">
                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                      &reg; Copyright 2021 SDPerfumerry.lk All Rights Reserved.
                    </p>
                  </td>
                  <td style="padding:0;width:50%;" align="right">
                    <table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
                      <tr>
                        <td style="padding:0 0 0 10px;width:38px;">
                          <a href="http://www.twitter.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/tw_1.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
                        </td>
                        <td style="padding:0 0 0 10px;width:38px;">
                          <a href="http://www.facebook.com/" style="color:#ffffff;"><img src="https://assets.codepen.io/210284/fb_1.png" alt="Facebook" width="38" style="height:auto;display:block;border:0;" /></a>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>






