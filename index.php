<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
		
		<!-- js datatable -->
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
		
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>

		<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	

		<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
		

		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<?php
			include_once('global.php');				
			$globalObj = new GlobalCommon();
			$siteName = $globalObj->get_sitename();
			
			$queries = array();
			parse_str($_SERVER['QUERY_STRING'], $queries);					
			
			if (array_key_exists('date', $queries)) {
				$dateStr = date($queries['date']);
			} else {
				$dateNow = new DateTime("now", new DateTimeZone('Asia/Hong_Kong') );
				$dateStr = date_format($dateNow, 'Y-m-d');
			} 
			
			echo '<title>' . $siteName . ' ' . $dateStr . '</title>'; 
		?>
					
		
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
			
			
			function getPrintOid() {
				
				var elem = document.getElementById('thisPrintOid');
				if (!!elem) {
					var value = elem.value;
				
					if (!!value) {				
						return value;
					} else {					
						return null;
					}
				} else {
					return null;
				}
			}
			
		</script>
	</head>
	
	<body>
		
		<header>
			<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
				<h5 class="my-0 mr-md-auto font-weight-normal">
					<?php
						echo $siteName; 
					?>
				</h5>
				<?php					
					echo '<input type="hidden" id="thisDate" name="thisDate" value="' . $dateStr . '">';
					
					if (array_key_exists('print_oid', $queries)) {
						$thisPrintOid = date($queries['print_oid']);
						echo '<input type="hidden" id="thisPrintOid" name="thisPrintOid" value="' . $thisPrintOid . '">';
					}
				?>
				
				<input type="hidden" id="cancelOid" name="cancelOid" value="">
				<button id="create-ticket" class="btn btn-success" onclick="window.location.href ='order_form.php'"><i class="fa fa-plus"></i> 新增</button>
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
					dom: 'Bfrtip',
					buttons: [
						'excelHtml5'
					],
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
				
				// open print
				var printOid = getPrintOid();
				if (printOid != null) {
					url = encodeURI("receipt.php?oid=" + printOid);
					window.open( url, '_blank');
				}
			} );
		</script>
	</body>
</html>