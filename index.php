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
		<!--<link rel="stylesheet" href="css/font.css">-->
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
		<title>Sport Ticket</title>
		<script>
			// handle form
			
			function getToday() {
				var today = new Date();
				var dd = String(today.getDate()).padStart(2, '0');
				var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
				var yyyy = today.getFullYear();
				return yyyy + '-' + mm + '-' + dd;
			}
		</script>
	</head>
	
	<body>
		<header>
		  <div class="row">
			<?php
				include_once('global.php');				
				$globalObj = new GlobalCommon();
				$siteName = $globalObj->get_sitename();
				echo $siteName; 
			?>
			<button id="create-ticket" class="btn"><i class="fa fa-plus"></i> 新增</button>
		  </div>
		</header>

		<nav>
		  <div class="row">

			<div id='court-list'>				
			</div>
	
			<div id="dialog-form" title="新增" style="display:none">
			  <form>
				<fieldset>
				  <label for="name">Name</label>
				  <input type="text" name="name" id="name" value="Jane Smith" class="text ui-widget-content ui-corner-all">
				  <label for="email">Email</label>
				  <input type="text" name="email" id="email" value="jane@smith.com" class="text ui-widget-content ui-corner-all">
				  <label for="password">Password</label>
				  <input type="password" name="password" id="password" value="xxxxxxx" class="text ui-widget-content ui-corner-all">
			 
				  <!-- Allow form submission with keyboard without duplicating the dialog button -->
				  <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
				</fieldset>
			  </form>
			</div>
		  </div>
		</nav>

		<div class="row">
		  <table id="tickettable" class="display cell-border" style="width:100%">
        <thead>
            <tr>
				<th>操作</th>
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
		  <div class="row">
			版權所有© 2020 澳門特別行政區政府　
		  </div>
		</footer>
		<script>
			$(document).ready(function() {
				var today = getToday();

				
				// render js datatable
				$('#tickettable').DataTable( {
					"paging":   false,

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
								return '<button class="btn" onclick="window.open(\'' + url + '\', \'_blank\')"><i class="fa fa-print"></i></button>';
							}
						},
						{ "data": "order_no", "width": "10%" },
						{ "data": "court_type", "width": "10%" },
						{ "data": "court_no", "width": "10%" },
						{ "data": "pay_time_str", "width": "15%" },
						{ "data": "time_range_str", "width": "10%" },
						{ "data": "people_count", "width": "10%" },
						{ "data": "amount", "width": "10%" },
						{ "data": "pay_method", "width": "15%" },						
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