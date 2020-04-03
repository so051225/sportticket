<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
		
		<script src="js/jquery-3.3.1.js"></script>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="css/bootstrap.min.css">		
		
		<title>新增票據</title>

		<?php
			include_once('global.php');				
			$globalObj = new GlobalCommon();
			$siteName = $globalObj->get_sitename();
			$siteId =  $globalObj->get_siteId();
		?>

		<script>
			Date.prototype.Format = function (fmt) {
				var o = {
					"M+": this.getMonth() + 1,
					"d+": this.getDate(),
					"h+": this.getHours(),
					"m+": this.getMinutes(),
					"s+": this.getSeconds(),
					"q+": Math.floor((this.getMonth() + 3) / 3),
					"S": this.getMilliseconds()
				};
				if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
				for (var k in o)
				if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
				return fmt;
			}
			Date.prototype.addHours = function(h) {
				this.setTime(this.getTime() + (h*60*60*1000));
				return this;
			}

			function formatDate(date) {
				var d = new Date(date),
					month = '' + (d.getMonth() + 1),
					day = '' + d.getDate(),
					year = d.getFullYear();

				if (month.length < 2) 
					month = '0' + month;
				if (day.length < 2) 
					day = '0' + day;

				return [year, month, day].join('-');
			}

			/*
			function get_available_datetime() {

				var date = new Date();
				var dateStr = date.Format("yyyy-MM-dd");

				var hours = date.getHours();
				var mins = date.getMinutes();

				var start = hours;
				var end = hours;

				if (mins > 50) {
					start = hours + 1;
					end = hours + 1;
				}

				var options = [];

				for (var i = start; i <= end; i++) {					
					var option_start_hour = i;
					var option_end_hour = i+1;
					var option_label =  dateStr + " " + option_start_hour + ":00 - " + option_end_hour + ":00";
					options.push({'label':option_label, 'start':option_start_hour, 'end':option_end_hour});
				}

				return options;
			}*/

			function get_label(hour) {
				var start = (hour.length < 2) ? '0' + hour : hour;
				var end = parseInt(hour) + 1;
				var date = new Date();
				var label = date.Format("yyyy-MM-dd");

				label = label + " " + start + ":00 - " + end + ":00";
				return label;
			}

			function init_time_options(hours) {
				var list = "";
				hours.forEach(function (hour, index) {
					var optionId = 'time_option_' + hour;
					var checked = (index == 0)? 'checked': '';
					list += '<input type="radio" id="time_option_' + hour + '" name="time_option" value="' + hour + '" ' + checked + '> ';
					list += '<label for="' + hour + '" id="label_' + hour + '">' +  get_label(hour) +  '</label>';
					list += '<input type="hidden" id="' + hour + '_end" name="' + hour + '_end">';					
					list += '<br>';
				});
				$('#time_options').html( list );
			}

			function sort_options(listId) {
				var selectList = $(listId + ' option');
				selectList.sort(function(a,b){
					a = a.value;
					b = b.value;

					return a-b;
				});
				$(listId).html(selectList);
			}

			function init_court_list(hour) {

				var API_GET_COURTS = "/sportticket/api/getCourtBySite.php?siteid=" + "<?php echo $config_siteid ?>";
				var API_CHECK_COURT_AVAILABLE = "/sportticket/api/checkCourtAvailable.php?hour=" + hour + "&cid=";

				$.getJSON( API_GET_COURTS )
					.done(function( courts ) {

						$('#court_id').empty();
						courts.forEach(function (court, index) {
							$.getJSON( API_CHECK_COURT_AVAILABLE + court['cid'])
								.done(function ( isAvailable ) {
									if (isAvailable) {
										var reservedStr = court['is_reserved'] == 0 ? "（預約場）" : "";
										$('#court_id').append('<option value="' + court['cid']  + '">' + court['court_no'] + reservedStr + '</option>');
									}
								})
								.fail(function( jqxhr, textStatus, error ) {
									var err = textStatus + ", " + error;
									console.log( "Check Court Available Failed: " + err );
								});
						});
					})
					.fail(function( jqxhr, textStatus, error ) {
						var err = textStatus + ", " + error;
						console.log( "Request Failed: " + err );
				});

				$( document ).ajaxStop(function(){
					if( $('#court_id').children('option').length === 0 ) {
						$('#court_id').hide();
						$('#courts_hint').html("現在沒有可租用場地");
						$('#submit_btn').prop('disabled', true);;
					} else {
						sort_options('#court_id');
					}
				});
			}

			function init_by_hours() {
				$.getJSON( "/sportticket/api/getAvailableHours.php" )
					.done(function( hours ) {
						init_time_options(hours);
						init_court_list(hours[0]);
					})
					.fail(function( jqxhr, textStatus, error ) {
						var err = textStatus + ", " + error;
						console.log( "Request Failed: " + err );
				});

				$('#time_options').change(function() {
					var time_option = $(this).val();
					init_court_list(time_option);
				});
			}

			function validataForm() {
				if ($('#court_id option:selected').text().indexOf("預約場") != -1) {
					if (confirm('本場地是預約場，**必須確定**場次沒有已預約！')) {
						return true;
					} else {
						return false;
					}
				}
				return true;
			}

			function initAmount(siteid) {

				$.getJSON( "/sportticket/api/getSiteAmount.php" )
					.done(function( amount ) {
						$("#amount_field").html(amount);
						$("#amount").val(amount);
					})
					.fail(function( jqxhr, textStatus, error ) {
						var err = textStatus + ", " + error;
						console.log( "Request Failed: " + err );
				});

				// var day = new Date().getDay();
				// var isWeekend = (day === 6) || (day === 0);
				// var amount = "20.0";
				// if (siteid === 1) {
				// 	amount = isWeekend ? "20.0" : "10.0";
				// } else {
				// 	amount = "20.0";
				// }
				// $("#amount_field").html(amount);
				// $("#amount").val(amount);
			}

			$( document ).ready(function() {
				init_by_hours();
				initAmount(<?php echo $siteId; ?>);
			});
		</script>
</head>
<body>
		<header>
		<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
			<h5 class="my-0 mr-md-auto font-weight-normal">
				<?php						
					echo $siteName . " - 新增票據"; 
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
		</div>
	</header>
	<div class="container">
		<div class="card bg-default">
			<div class="card-body">
				<form id="order_form" class="form-group" action="./api/postOrder.php" method="POST" onsubmit="return validataForm()" autocomplete="off">
					<p>證件類型選擇：</p>
					<div>
						<input type="radio" id="id" name="id_type" value="ID" checked>
						<label for="id">身份證號碼</label><br>
						<input type="radio" id="esport_id" name="id_type" value="ESPORT_ID">
						<label for="esport_id">運動易會員</label><br>
						<input type="radio" id="other_id" name="id_type" value="OTHER_ID">
						<label for="other_id">其他</label>
					</div>

					<div>
						<input type="text" name="id_value" id="id_no" placeholder="請輸入證件號碼" required>
						<span style="color: red; font-size: 15px;">不需要輸入括號</span>
					</div>
					<hr>
					<div>
						<label for="courts">場地：</label>
						<select name="court_id" id="court_id"></select>
						<p id="courts_hint" style="color: red; font-size: 15px;"></p>
					</div>
					<hr>
					<div>
						<label for="time_options">場次：</label>
						<div id='time_options'></div>
					</div>
					<hr>

					<div>
						<label for="quantity">人數：</label>
						<input type="number" id="quantity" name="quantity" min="1" value="1">
					</div>
					<hr>
					<div>
						金額： <span id="amount_field"></span>
						<input type="hidden" id="amount" name="amount" value="">
					</div>
					<label for="pay_method">支付方式：</label>
						<select name="pay_method" id="pay_method">
							<option value="現金" selected="selected">現金</option>
							<option value="MPay">MPay</option>
							<option value="澳門通卡">澳門通卡</option>
							<option value="雲閃付">雲閃付</option>
							<option value="銀聯閃付卡">閃付卡</option>
							<option value="代金券">代金券</option>
						</select>
					</div>
				</form>		
			</div>
			<button class="btn btn-primary m-2" type="submit" form="order_form" id="submit_btn"><i class="fa fa-print"></i> 確認</button>
			<button class="btn btn-danger m-2" onclick="window.location.href ='index.php'"><i class="fa fa-home"></i> 返回</button>
		</div>
	</div>
</body>
</html>