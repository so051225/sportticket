<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
		
		<!-- js datatable -->
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
		
		<link rel="stylesheet" href="css/main.css">
		<title>Sport Ticket</title>
	</head>
	
	<body>
		<header>
		  <div class="row">
			<?php
				include_once('global.php'); 
				$siteName = get_sitename();
				echo $siteName; 
			?>
			<button>新增</button>
		  </div>
		</header>

		<nav>
		  <div class="row">
			<ul>
			  <li>Link 1</li>
			  <li>Link 2</li>
			  <li>Link 3</li>
			</ul>
		  </div>
		</nav>

		<div class="row">
		  <table id="example" class="display" style="width:100%">
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
				</tr>
			</tfoot>
		</table>
		</div>

		<footer>
		  <div class="row">
			Copyright ID.
		  </div>
		</footer>
		<script>
			$(document).ready(function() {
				$('#example').DataTable();
			} );
		</script>
	</body>
</html>