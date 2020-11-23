<!doctype html>
<html lang="en">
<head>
    <title>PHP INVOICE</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css" rel="stylesheet">
* {
    margin: 0;
    padding: 0;
}
body {
    font-size: 12px;
    font-family: Arial, Helvetica, sans-serif;
}
.totals-row td {
    border-right: none !important;
    border-left: none !important;
}
td {
    white-space: nowrap;
}
.items-table td,
#notes {
    white-space: normal;
}
.totals-row td strong,
.items-table th {
    white-space: nowrap;
}
.invoice-wrap {
    margin: 0 auto;
    background: #FFF;
    color: #000
}
.invoice-inner {
}
.invoice-address {
    border-top: 3px double #000000;
    margin: 20px 0;
    padding-top: 25px;
}
.bussines-name {
    font-size: 18px;
    font-weight: 100
}
.invoice-name {
    font-size: 22px;
    font-weight: 700
}
.listing-table th {
    background-color: #e5e5e5;
    border-bottom: 1px solid #555555;
    border-top: 1px solid #555555;
    font-weight: bold;
    text-align: left;
    padding: 6px 4px
}
.listing-table td {
    border-bottom: 1px solid #555555;
    text-align: left;
    padding: 5px 6px;
    vertical-align: top
}
.total-table td {
    border-left: 1px solid #555555;
}
.total-row {
    background-color: #e5e5e5;
    border-bottom: 1px solid #555555;
    border-top: 1px solid #555555;
    font-weight: bold;
}
.row-items {
    margin: 5px 0;
    display: block
}
.notes-block {
    margin: 50px 0 0 0
}
/*tables*/

table td {
    vertical-align: top
}
.items-table {
    border: 1px solid #1px solid #555555;
    border-collapse: collapse;
    width: 100%
}
.items-table td,
.items-table th {
    border: 1px solid #555555;
    padding: 4px 5px;
    text-align: left
}
.items-table th {
    background: #f5f5f5;
}
.totals-row .wide-cell {
    border: 1px solid #fff;
    border-right: 1px solid #555555;
    border-top: 1px solid #555555
}
.invoice-wrap {
    margin-bottom: 20px;
}
</style>
</head>
<body>
    <div id="editor" class="edit-mode-wrap" style="margin-top: 20px">
        <div class="invoice-wrap">
            <div class="invoice-inner">
                <table border="0" cellpadding="0" cellspacing="0" class="is_logo" width="100%">
                    <tbody>
                        <tr>
                            <td align="center" valign="top">
                                <div><img alt="logo" id="logo" src="/php-invoice-html/templates/basic/logo.jpg" width="235" /></div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="invoice-address">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td align="left" valign="top" width="50%">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td valign="top"><strong><span class="editable-text" id="label_bill_to">Bill To</span></strong></td>
                                                <td align="left" valign="top">
                                                    <div>
                                                        <table border="0" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td align="left" style="padding-left:25px;">
                                                                        <span  id="client_info">[Client Name]<br>
                                                                        [Client Address line 1]<br>
                                                                        [City], [State] [Postal Code] [@username]
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td align="right" valign="top" width="50%">
                                    <table align="right" border="0" cellpadding="0" cellspacing="0" width="260">
                                        <tbody>
                                            <tr>
                                                <td align="right">
                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                        <tbody>
                                                            <tr>
                                                                <td align="right">
                                                                    <span  id="business_info"><p style="font-size: 14pt;">[Business Name]</p>
                                                                        [Business Address 1]<br>
                                                                        [City], [State] [Postal Code]<br>
                                                                        [Company Phone Number]<br>
                                                                        [Company Emaill Address]
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div style="clear:both">&nbsp;</div>
                                    &nbsp;&nbsp;

                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td align="right"><strong><span class="editable-text" id="label_invoice_no">Invoice no.</span></strong></td>
                                                <td align="left" style="padding-left:20px"><span class="editable-text" id="no">2001321</span></td>
                                            </tr>
                                            <tr>
                                                <td align="right"><strong><span class="editable-text" id="label_date">Date</span></strong></td>
                                                <td align="left" style="padding-left:20px"><span class="editable-text" id="date">5/24/2017</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="items-list">
                    <table class="table table-bordered table-condensed table-striped items-table">
                        <thead>
                            <tr>
                                <th>PRODUCT</th>
                                <th>QTY</th>
                                <th>VAT</th>
                                <th width="100">PRICE</th>
                                <th width="100">DISCOUNT</th>
                                <th width="100">TOTAL</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="totals-row">
                                <td colspan="4" class="wide-cell"></td>
                                <td><strong>Total</strong></td>
                                <td coslpan="2">Rs. 68</td>
                            </tr>
                            <tr class="totals-row">
                                <td colspan="4" class="wide-cell"></td>
                                <td><strong>Paid Amount </strong></td>
                                <td coslpan="2">Rs. 50</td>
                            </tr>
                            <tr class="totals-row">
                                <td colspan="4" class="wide-cell"></td>
                                <td><strong>Balance Due </strong></td>
                                <td coslpan="2">Rs. 18</td>
                            </tr>
                            </tfoot>
                            <tbody>
                                <tr>
                                    <td>Product name</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>Rs. 1</td>
                                    <td>Rs. 1</td>
                                    <td>Rs. 1</td>
                                </tr>
                                <tr>
                                    <td>Product name</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>Rs. 1</td>
                                    <td>Rs. 1</td>
                                    <td>Rs. 1</td>
                                </tr>
                                <tr>
                                    <td>Product name</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>Rs. 1</td>
                                    <td>Rs. 1</td>
                                    <td>Rs. 1</td>
                                </tr>
                                <tr>
                                    <td>Product name</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>Rs. 1</td>
                                    <td>Rs. 1</td>
                                    <td>Rs. 1</td>
                                </tr>
                            </tbody>
                    </table>
                </div>

                <div class="notes-block">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <div  id="notes" style="">Enter your Notes, Bank Details, or Terms</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>