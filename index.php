<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
		
		<!-- js datatable -->
		<link rel="stylesheet" href="css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">			
		
		<script src="js/jquery-3.3.1.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.buttons.min.js"></script>
		<script src="js/jszip.min.js"></script>
		<script src="js/buttons.html5.min.js"></script>
		
		
		<?php
			include_once('global.php');				
			$globalObj = new GlobalCommon();
			$siteName = $globalObj->get_sitename();
			
			$exportFileName = $globalObj->get_siteid() . '_' . $globalObj->get_today();
			
			$queries = array();
			parse_str($_SERVER['QUERY_STRING'], $queries);					
			
			// date
			if (array_key_exists('date', $queries)) {
				$dateStr = date($queries['date']);
			} else {
				$dateStr = $globalObj->get_today();
			}
			
			// isMonthStr
			if (array_key_exists('ismonth', $queries)) {
				$isMonthStr = $queries['ismonth'];				
				if('Y' !== $isMonthStr) {
					$isMonthStr =  'N';
				}
			} else {
				$isMonthStr = 'N';
			}
			
			
			if ($isMonthStr === 'N')
				$siteNameStr = $siteName . ' (' . $dateStr . ')'; 
			else
				$siteNameStr = $siteName . ' (過去三十日記錄)'; 
			
			echo '<title>' . $siteNameStr . '</title>';
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
			
			function getIsMonth() {
				var value = document.getElementById('isMonth').value;
				
				if (!!value) {				
					return value;
				} else {
					return 'N';
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
						echo $siteNameStr; 
					?>
				</h5>
				<?php					
					echo '<input type="hidden" id="thisDate" name="thisDate" value="' . $dateStr . '">';
					echo '<input type="hidden" id="isMonth" name="isMonth" value="' . $isMonthStr . '">';
					
					if (array_key_exists('print_oid', $queries)) {
						$thisPrintOid = date($queries['print_oid']);
						echo '<input type="hidden" id="thisPrintOid" name="thisPrintOid" value="' . $thisPrintOid . '">';
					}
				?>
				
				<input type="hidden" id="cancelOid" name="cancelOid" value="">
				
				<?php if ($isMonthStr == 'N'): ?>
					<button id="create-ticket" class="btn btn-success m-1" onclick="window.location.href ='order_form.php'">+ 新增</button>
					<button id="create-ticket" class="btn btn-primary m-1" onclick="window.location.href ='index.php?ismonth=Y'">過往三十日記錄</button>
				<?php else: ?>
					<button id="create-ticket" class="btn btn-danger m-1" onclick="window.location.href ='/sportticket'">返回</button>
				<?php endif; ?>
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
			 <table id="tickettable" class="display cell-border " style="width:100%">
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
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>				
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
				var r = confirm("確定取消票據?");
				if (r == true) {
					$.post("api/cancelOrder.php", {oid: cancelOid}, function(data, status){
						location.reload(); 
					});
				}
			}
		
			$(document).ready(function() {
				var today = getToday();
				var isMonth = getIsMonth();
				console.log('today :' + today);
				console.log('isMonth :' + isMonth);
				
				var api = "api/order.php?date=" + today;
				if (isMonth === 'Y')
					api +="&ismonth=Y"
				
				// render js datatable
				var table =  $('#tickettable').DataTable( {
					"paging":   false,
					"order": [[ 2, "desc" ]],
					"ajax": api ,
					'bom': true,
					dom: 'Bfrtip',
					buttons: [
						{
							extend: 'excelHtml5', 
							title: '<?php echo $exportFileName; ?>'
						}
					],
					"footerCallback": function ( row, data, start, end, display ) {
						var api = this.api(), data;
						
						// Remove the formatting to get integer data for summation
						var intVal = function ( i ) {
							return typeof i === 'string' ?
								i.replace(/[\$,]/g, '')*1 :
								typeof i === 'number' ?
									i : 0;
						};
						
						var total = 0;
						
						if (data.length > 0) {
							console.log(data);
							for (var i = 0; i < data.length; i++) {
								if (data[i]['order_status'] === 0) {
									total += intVal(data[i]['amount']);
								}
							}
						}
											
						$( api.column( 8 ).footer() ).html(
							'合計:' + total
						);
					},
					"columns": [
						{
							"class": "details-control",
							"orderable": false,
							"data": null,							
							"defaultContent": "",
							"width": "10%",
							"render": function ( data, type, row, meta ) {								
								url = encodeURI("receipt.php?oid=" + row['oid']);
								btnPrintOnClick = "window.location.href='" + url +"'";
								
								// onclick="window.open(\'' + url + '\', \'_blank\')"
								
								<?php if ($isMonthStr == 'N'): ?>
									btnPrint = '<button type="button" class="btn btn-primary m-1 btn-sm" onclick="' + btnPrintOnClick + '">列印</button>';									
									btnCancel = '<button type="button" class="btn btn-danger m-1 btn-sm" onclick="cancelOrder(this, \'' + row['oid'] + '\')">取消</button>';
								<?php else: ?>
									btnPrint = '';
									btnCancel = '';
								<?php endif;?>
								
								if (row['order_status'] == 1) {
									btnCancel = '';
								}								
								return '<div> ' + btnPrint + btnCancel + '</div>';
							}
						},
						{ 
							"data": "status_str", "width": "5%",
						},
						{ "data": "order_no", "width": "8%" },
						{ "data": "court_type", "width": "8%" },
						{ "data": "court_no", "width": "5%" },
						{ "data": "pay_time_str", "width": "10%" },
						{ "data": "time_range_str", "width": "10%" },
						{ "data": "people_count", "width": "5%" },
						{ "data": "amount", "width": "8%" },
						{ "data": "pay_method", "width": "5%" },						
					]
				});
				
				// open print
				var printOid = getPrintOid();
				if (printOid != null) {
					url = encodeURI("receipt.php?oid=" + printOid);
					//window.open( url, '_blank');
				}
				
			} );
		</script>
	</body>
</html>