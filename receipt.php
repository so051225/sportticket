<?php

include_once('config.php');
include_once(ROOT_PATH . 'dal\order_view.php'); 

$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);

$oid = date($queries['oid']);
$view = new OrderView();
$order = $view->get_order_by_id($oid);

?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
	<link rel="stylesheet" href="css/main.css">
	<script src="js/jquery-3.3.1.js"></script>
	<style type="text/css" media="print">
		@page {
			size: auto;   /* auto is the initial value */
			margin: 0 3mm;  /* this affects the margin in the printer settings */
		}
		.btn {
			display: none;
		}
		html {
			margin: 0px;  /* this affects the margin on the html before sending to printer */
		}
		body {
			/*border: solid 1px blue ;*/
			margin: 0; /* margin you want for the content */
		}
	</style>
	<style type="text/css">
		.btn {
			border: #0062cc;
			color: white;
			background-color: #0069d9;
			padding: 8px 10px;
			font-size: 16px;
			cursor: pointer;
			margin: 3px;
			width: 160px;
		}
		.btn:hover {
			background-color: #e0e0e0;
		}
		.btn-back {
			background-color: #dc3545;
		}
	</style>
</head>
<body>
	
	<table style="margin-left:5.4pt;border-collapse:collapse;border:none;">
    <tbody>
        <tr>
            <td style="width: 205.55pt;padding: 0cm 5.4pt;height: 410.6pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";text-indent:1.7pt;'><span style="font-family:標楷體;"><img width="250" src="data:image/png;base64,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" alt="image"></span></p>
				<p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:4.0pt;'><span style='font-size:9px;font-family:"Times New Roman","serif";'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:10.0pt;'><span style="font-family:標楷體;"><?php echo $order['site_name_zh']; ?> :</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:10.0pt;'><span style='font-size:15px;font-family:"Times New Roman","serif";'><?php echo $order['site_name_pt']; ?></span></p>
				<p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:4.0pt;'><span style='font-size:9px;font-family:"Times New Roman","serif";'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:4.0pt;'><span style='font-size:9px;font-family:"Times New Roman","serif";'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:10.0pt;'><span style="font-family:標楷體;">羽毛球</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:10.0pt;'><span style='font-size:15px;font-family:"Times New Roman","serif";'>Badminton</span><span style="font-size:15px;font-family:標楷體;">：</span><span style='font-size:15px;font-family:"Times New Roman","serif";'><?php echo $order['court_no']; ?></span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:4.0pt;'><span style='font-size:9px;font-family:"Times New Roman","serif";'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:10.0pt;'><span style="font-family:標楷體;">收據編號</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:10.0pt;'><span style='font-size:15px;font-family:"Times New Roman","serif";'>No. de recibo</span><span style="font-size:15px;font-family:標楷體;">：</span><span style='font-size:15px;font-family:"Times New Roman","serif";'><?php echo $order['order_no']; ?></span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:4.0pt;'><span style='font-size:9px;font-family:"Times New Roman","serif";'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:10.0pt;'><span style="font-family:  標楷體;">日期</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:10.0pt;'><span style='font-size:15px;font-family:"Times New Roman","serif";'>Data</span><span style="font-size:15px;font-family:標楷體;">：</span><span style='font-size:15px;font-family:"Times New Roman","serif";'><?php echo $order['receipt_date_str']; ?></span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:4.0pt;'><span style='font-size:9px;font-family:"Times New Roman","serif";'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:10.0pt;'><span style="font-family:標楷體;">時間</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:10.0pt;'><span style='font-size:15px;font-family:"Times New Roman","serif";'>Tempo</span><span style="font-size:15px;font-family:標楷體;">：</span><span style='font-size:15px;font-family:"Times New Roman","serif";'><?php echo $order['receipt_time_range_str']; ?></span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:4.0pt;'><span style='font-size:9px;font-family:"Times New Roman","serif";'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:10.0pt;'><span style="font-family:標楷體;">費用</span><span style='font-family:"Times New Roman","serif";'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:10.0pt;'><span style='font-size:15px;font-family:"Times New Roman","serif";'>Taxa</span><span style="font-size:15px;font-family:標楷體;">：</span><span style='font-size:15px;font-family:"Times New Roman","serif";'><?php echo $order['amount_str']; ?></span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:4.0pt;'><span style='font-size:9px;font-family:"Times New Roman","serif";'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:10.0pt;'><span style="font-family:  標楷體;">會員</span><span style='font-family:"Times New Roman","serif";'>/</span><span style="font-family:標楷體;">證件編號</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";line-height:10.0pt;'><span style='font-family:"Times New Roman","serif";'>Membro/ Documento de identifição n.<sup>o</sup></span><span style="font-family:  標楷體;">：</span><span style='font-family:"Times New Roman","serif";'><?php echo $order['customer_id']; ?></span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:4.0pt;'><span style='font-size:9px;font-family:"Times New Roman","serif";'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:10.0pt;'><span style="font-family:  標楷體;">人數</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;line-height:10.0pt;'><span style='font-family:"Times New Roman","serif";'>Emissão</span><span style="font-family:標楷體;">：</span><span style='font-family:"Times New Roman","serif";'><?php echo $order['people_count']; ?></span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;text-align:right;'><span style='font-size:9px;font-family:"Times New Roman","serif";'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;text-align:right;'><span style="font-size:11px;font-family:標楷體;">發出</span><span style="font-size:11px;font-family:標楷體;">：</span><span style="font-size:11px;font-family:標楷體;"><?php echo $order['site_name_zh']; ?></span><span style='font-size:11px;font-family:"Times New Roman","serif";'><br> <?php echo $order['site_name_pt']; ?><br>&nbsp;</span><span style="font-size:11px;font-family:標楷體;">付款時間</span><span style='font-size:11px;font-family:"Times New Roman","serif";'>Tempo de pagamento</span><span style="font-size:11px;font-family:標楷體;">：</span><span style='font-size:11px;font-family:"Times New Roman","serif";'><?php echo $order['recept_pay_time_date_str']; ?></span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;text-align:right;'><span style='font-size:11px;font-family:  "Times New Roman","serif";'><?php echo $order['recept_pay_time_str']; ?></span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Calibri","sans-serif";margin-left:1.7pt;'><span style="font-size:11px;font-family:標楷體;">穿著<u>鞋底為黑色、會留下痕跡</u>的運動鞋、</span><span style='font-size:11px;font-family:"Times New Roman","serif";'><br>&nbsp;</span><span style="font-size:11px;font-family:標楷體;">涼鞋或皮鞋者皆禁止在場內進行運動。</span><span style='font-size:11px;font-family:"Times New Roman","serif";'><br>&nbsp;Proibido praticar desporto na instalacao vestidos com sandalias, calcado inadequado ou sapatilhas com a sola preta e que deixam marcas no pavimento.</span></p>
            </td>
        </tr>
    </tbody>
</table>
	<button class="btn" onclick='window.print();'>列印</button>
	<button class="btn btn-back" onclick='window.location.href ="index.php";'>返回</button>
	<script>
		$(document).ready(function() {
			window.print();
			// setTimeout(print, 3000, 'print second time!');
			// window.print();
		});
		
	</script>
</body>
</html>
