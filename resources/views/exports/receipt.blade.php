<html>
<head>
    <style>
        @page {
            margin: 0;
            padding:0;
            size: 'A4 landscape';
        }
        
        body{
            margin:10px;
            padding: 0;
            font-family: sans-serif;
        }

        .text-center {
            text-align: center;
        }
        
        .bg-black {
            background-color: black !important;
            -webkit-print-color-adjust: exact; 
            color: white;
        }
        
        table {
            border-collapse: collapse;
            /*border: 1px solid #000;*/
            width: 100%;
            width:9.9cm;
            margin: 0 auto;
        }
        
        table tr td {
            /*border-bottom: 1px solid #000;*/
            padding: 8px 4px;
            
        }

        .border-none {
            border: none;
        }

        .text-right {
        	text-align: right !important;
        }

        .p-0 {
        	padding: 0 !important;
        }

      
    </style>
</head>
<body>
    <table>
    	<tr>
    		<td colspan="3" class="text-center p-0">
    			<div style="font-size: 20px;"><b>{{ $customer->campaign->name }}</b></div>
    		</td>
    	</tr>
        <tr>
            <td colspan="3" class="text-center border-none">
                <div style="font-size: 18px;"><b>{{ Auth::user()->company->name }}</b></div>
                <div style="font-size: 14px;"><b>CAMPAIGN MASTER</b></div>
            </td>
        </tr>
        <tr>
            <td width="48%" class="text-right">Receipt No</td>
            <td width="2%" class="text-center">:</td>
            <td width="48%">{{ $customer->id }}</td>
        </tr>
        <tr>
            <td width="48%" class="text-right">Customer Name</td>
            <td width="2%" class="text-center">:</td>
            <td width="48%">{{ $customer->name }}</td>
        </tr>
        <tr>
            <td width="48%" class="text-right">Trans Date & Time</td>
            <td width="2%" class="text-center">:</td>
            <td width="48%">{{ DATE('d-m-Y h:i a', strtotime($customer->redeem_date)) }}</td>
        </tr>
        <tr>
            <td width="48%" class="text-right">Vehicle Reg No</td>
            <td width="2%" class="text-center">:</td>
            <td width="48%">{{ $customer->reg_no }}</td>
        </tr>
        <tr>
            <td width="48%" class="text-right">Referral Code</td>
            <td width="2%" class="text-center">:</td>
            <td width="48%">{{ $customer->referral_code }}</td>
        </tr>
        <tr>
            <td width="48%" class="text-right">Labour Amount</td>
            <td width="2%" class="text-center">:</td>
            <td width="48%">{{ $customer->labour_amount }}</td>
        </tr>
        <tr>
            <td width="48%" class="text-right">Discount Amount</td>
            <td width="2%" class="text-center">:</td>
            <td width="48%">{{ $customer->redeem_amount }}</td>
        </tr>
        <tr>
            <td width="48%" class="text-right">Bill Amount</td>
            <td width="2%" class="text-center">:</td>
            <td width="48%">{{ $customer->total_amount - $customer->redeem_amount }}</td>
        </tr>
        
    </table>

    <script>
        window.onload = function(){
            window.print();
        }
    </script>
</body>
</html>