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

			function get_label(hour) {
				var start = (hour.length < 2) ? '0' + hour : hour;
				var end = parseInt(hour) + 1;
				var date = new Date();
				var label = date.Format("yyyy-MM-dd");

				label = label + " " + start + ":00 - " + end + ":00";
				return label;
			}

			function onChange(obj) {
				var time_option = obj.value;
				init_court_list(time_option);
			}

			function init_time_options(hours) {
				var list = "";

				for (var hour = hours[0]; hour <= hours[1]; ++hour) {
					var optionId = 'time_option_' + hour;
					var checked = (hour == hours[0])? 'checked': '';
					list += '<input onchange="onChange(this)" type="radio" id="time_option_' + hour + '" name="time_option" value="' + hour + '" ' + checked + '> ';
					list += '<label for="' + hour + '" id="label_' + hour + '">' +  get_label(hour) +  '</label>';
					list += '<input type="hidden" id="' + hour + '_end" name="' + hour + '_end">';					
					list += '<br>';
				}

				$('#time_options').html( list );
			}
			
			function init_court_list(hour) {

				var API_GET_AVILABLE_COURT = "/sportticket/api/getAvailableCourt.php?siteid=" + "<?php echo $config_siteid ?>";
				
				$.getJSON( API_GET_AVILABLE_COURT ).done(function( hour_courts ) {
					// ui
					var html = "";
					if (!hour_courts || !hour_courts[hour] || hour_courts[hour].length == 0) {
						html = '<span style="color: red; font-size: 15px;">沒有可租用場地</span>';
						$('#submit_btn').prop('disabled', true);
					} else {
						//<select name="court_id" id="court_id"></select>
						html += '<select name="court_id" id="court_id">';
						courts = hour_courts[hour];						
						courts.forEach(function (court, index) {
							var selected = (index == 0)? 'selected' : ''; 
							var reservedStr = court['is_reserved'] == 0 ? "（預約場）" : "";
							var optionStr = '<option ' + selected + ' value="' + court['cid']  + '">' + court['court_no'] + reservedStr + '</option>';
							
							html += optionStr;
						});
						html += '</select>';

					}	
					$('#court_id').html(html);
				})
				.fail(function( jqxhr, textStatus, error ) {
						var err = textStatus + ", " + error;
						console.log( "Request Failed: " + err );
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
                        <div id='court_id'></div>
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
                </form>
            </div>
        </div>
        <button class="btn btn-primary m-2" type="submit" form="order_form" id="submit_btn">確認</button>
        <button class="btn btn-danger m-2" onclick="window.location.href ='index.php'">返回</button>
    </div>
    </div>
</body>

</html>