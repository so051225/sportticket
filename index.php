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
		
		<title>Sport Ticket</title>
		<script>
			// handle form
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
			<button id="create-ticket">新增</button>
		  </div>
		</header>

		<nav>
		  <div class="row">
			<ul>
			</ul>
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
		  <table id="tickettable" class="display" style="width:100%">
			<thead>
				<tr>
					<th>票號</th>
					<th>類型</th>
					<th>場號</th>
					<th>發票時間</th>
					<th>進場時間</th>
					<th>人數</th>
					<th>費用</th>
					<th>付款方式</th>
					<th>取消</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>4741775</td>					
					<td>羽毛球</td>
					<td>A</td>
					<td>08:46:15</td>
					<td>2020-03-31 08:00~09:00</td>
					<td>3</td>
					<td>$20</td>
					<td>現金</td>
					<td><button>取消</button></td>
				</tr>
				<tr>
					<td>4741775</td>					
					<td>羽毛球</td>
					<td>A</td>
					<td>08:46:15</td>
					<td>2020-03-31 08:00~09:00</td>
					<td>3</td>
					<td>$20</td>
					<td>現金</td>
					<td><button>取消</button></td>
				</tr>
				<tr>
					<td>4741775</td>					
					<td>羽毛球</td>
					<td>A</td>
					<td>08:46:15</td>
					<td>2020-03-31 08:00~09:00</td>
					<td>3</td>
					<td>$20</td>
					<td>現金</td>
					<td><button>取消</button></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th>票號</th>
					<th>類型</th>
					<th>場號</th>
					<th>發票時間</th>
					<th>進場時間</th>
					<th>人數</th>
					<th>費用</th>
					<th>付款方式</th>
					<th>取消</th>
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
				$('#tickettable').DataTable();
			} );
		</script>
	</body>
</html>