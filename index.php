<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
		
		<!-- js datatable -->
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
		
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<!--
		<script src="js/jquery/external/jquery/jquery.js"></script>
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/js/foundation.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/css/foundation.css">-->
		<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

		<!--<link rel="stylesheet" href="css/font.css">-->
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<title>Sport Ticket</title>
		<script>
			// handle form
			
			function getToday() {
				
				var value = document.getElementById('thisDate').value;
				
				if (!!value) {				
					return value;
				} else {					
					var today = new Date();
					var dd = String(today.getDate()).padStart(2, '0');
					var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
					var yyyy = today.getFullYear();
					return yyyy + '-' + mm + '-' + dd;
				}

			}
		</script>
	</head>
	
	<body>
		
		<header>
			<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
				<h5 class="my-0 mr-md-auto font-weight-normal">
					<?php
						include_once('global.php');				
						$globalObj = new GlobalCommon();
						$siteName = $globalObj->get_sitename();
						echo $siteName; 
					?>
				</h5>
				<?php
					$queries = array();
					parse_str($_SERVER['QUERY_STRING'], $queries);
					
					if (array_key_exists('date', $queries)) {
						$dateStr = date($queries['date']);
					} else {
						$dateNow = new DateTime("now", new DateTimeZone('Asia/Hong_Kong') );
						$dateStr = date_format($dateNow, 'Y-m-d');
					} 
				
					echo '<input type="hidden" id="thisDate" name="thisDate" value="' . $dateStr . '">';
				?>
				
				<input type="hidden" id="cancelOid" name="cancelOid" value="">
				<button id="create-ticket" class="btn btn-primary" onclick="window.location.href ='order_form.php'"><i class="fa fa-plus"></i> 新增</button>
			</div>
		</header>

		<nav>
		  <div class="row">
			<div id='court-list'>				
			</div>
	
			<div id="dialog-form" title="新增" style="display:none">
			 
			</div>
		  </div>
		</nav>

		<div class="container">
			 <table id="tickettable" class="display cell-border" style="width:100%">
				<thead>
					<tr>
						<th>操作</th>
						<th>狀態</th>
						<th>票號</th>
						<th>類型</th>
						<th>場號</th>
						<th>發票時間</th>
						<th>進場時間</th>
						<th>人數</th>
						<th>費用</th>
						<th>付款方式</th>
						
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>操作</th>
						<th>狀態</th>
						<th>票號</th>
						<th>類型</th>
						<th>場號</th>
						<th>發票時間</th>
						<th>進場時間</th>
						<th>人數</th>
						<th>費用</th>
						<th>付款方式</th>				
					</tr>
				</tfoot>
			</table>
		</div>

		<footer>
		  <div class="row col-12 myrow">
			<p class='text-center'> 版權所有© 2020 </p>
		  </div>
		</footer>
		<script>
			function cancelOrder(elem, oid) {
				var cancelOid = oid;
				var r = confirm("確定取消!");
				if (r == true) {
					$.post("api/cancelOrder.php", {oid: cancelOid}, function(data, status){
						location.reload(); 
					});
				}
			}
		
			$(document).ready(function() {
				var today = getToday();
				console.log(today);
				
				// render js datatable
				var table =  $('#tickettable').DataTable( {
					"paging":   false,
					"order": [[ 2, "desc" ]],
					"ajax": "api/order.php?date="+today ,					
					"columns": [
						{
							"class": "details-control",
							"orderable": false,
							"data": null,
							"defaultContent": "",
							"width": "10%",
							"render": function ( data, type, row, meta ) {								
								url = encodeURI("receipt.php?oid=" + row['oid']);
								btnPrint = '<button type="button" class="btn btn-primary" onclick="window.open(\'' + url + '\', \'_blank\')"><i class="fa fa-print"></i></button>';							
								
								btnCancel = '<button type="button" class="btn btn-danger" onclick="cancelOrder(this, \'' + row['oid'] + '\')"><i class="fa fa-minus-square"></i></button>';
								
								if (row['order_status'] == 1) {
									btnCancel = '';
								}								
								return '<div> ' + btnPrint + '   ' + btnCancel + '</div>';
							}
						},
						{ 
							"data": "status_str", "width": "8%",
						},
						{ "data": "order_no", "width": "8%" },
						{ "data": "court_type", "width": "8%" },
						{ "data": "court_no", "width": "5%" },
						{ "data": "pay_time_str", "width": "10%" },
						{ "data": "time_range_str", "width": "10%" },
						{ "data": "people_count", "width": "8%" },
						{ "data": "amount", "width": "10%" },
						{ "data": "pay_method", "width": "10%" },						
					]
				});
				
				// get court list
				$.getJSON( "http://localhost/sportticket/api/getCourtBySite.php?siteid=1" )
					.done(function( data ) {
						console.log( data);
						list = '<ul>';
						$.each(data, function( i, item) {
							list += "<li> " + item['court_no'] + '</li>';							
						});
						list += '</ul>';
						// $('#court-list').html( list );
					})
					.fail(function( jqxhr, textStatus, error ) {
						var err = textStatus + ", " + error;
						console.log( "Request Failed: " + err );
				});
			} );
		</script>
	</body>
</html>