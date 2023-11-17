<?
session_start();
if(!isset($_SESSION['user_id'])){
	header('Location: auth/');
	exit;
} else {
?>
<html>
	<head>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	</head>
	
	<body>
		<div id="sectionTable">
			<div id="Table">
				
				<div id="LineRow">
					<!-- <form onsubmit="return false" method="GET">
						<input type="submit" name="status" value="ВСЕ" id="complite" class="statusForm">
						<input type="submit" name="status" value="АКТИВНЫЕ" id="active" class="statusForm">
						<input type="submit" name="status" value="ВЫПОЛНЕННЫЕ" id="complite" class="statusForm">
						<input type="submit" name="status" value="УДАЛЕННЫЕ" id="delite" class="statusForm">
						
					</form> -->
					
					<button id="newtaskButton" onclick="Createtask()">СОЗДАТЬ ЗАДАЧУ</button>
					
					<form id="create_tesk" onsubmit="return false" method="POST">
					<input type="hidden" name="task_from" value="<?=$_SESSION['user_id']?>">
					  <div id="CreateTask">
						<div id="titleNewTask">
							<div id="priorityItemCreateTask" class="ItemtitleTaskRow shadow">
							<select name="priority">
								<option value="1">НИЗКАЯ</option>
								<option value="2">СРЕДНЯЯ</option>
								<option value="3">ВЫСОКАЯ</option>
							</select>
							</div>
							<select name='task_for'>
								<!-- userlist -->
							</select>
							<div id="titleItemCreateTask" class="ItemtitleTaskRow shadow">
							<input type="text" id="titleInput" name="title">
							</div>
							<div id="saveItemCreateTask" class="ItemtitleTaskRow shadow">
							<!-- <input type="hidden" name="formPost" value="СОЗДАТЬ"> -->
							<input type="submit" value="СОЗДАТЬ" id="CreateTaskButton">
							</div>
						</div>
						<textarea rows="25" id="taskInput" name="task" class="shadow"></textarea>
					  </div>
					</form>
					<div id="filter">
						<span onclick="get_filtered(0)">ВСЕ</span>
						<span onclick="get_filtered(1)">АКТИВНЫЕ</span>
						<span onclick="get_filtered(2)">ВЫПОЛНЕННЫЕ</span>
						<span onclick="get_filtered(3)">УДАЛЕННЫЕ</span>
					</div>
				</div>
				<div id="task_list"></div>
			</div>
		</div>
		<script src="script.js"></script>
		<script>
			function next_page(page) {
				console.log(page);
				$('.rowNewTask').css('display','none');
				$('div[page="'+page+'"]').css('display','block');
			}
			function get_filtered(code) {
				$('#hrefs').remove();
				$('.rowNewTask').remove();
				if (code == 0) {
					var filter = {par:'get_task_list',data:{get:{}}};
					// console.log(filter);
				} else {
					var filter = {par:'get_task_list',data:{get:{status:code}}};
				}
				$.post('api.php', filter, function(data){
					// console.log(data);
					json = JSON.parse(data)['data'];
					var page = 1;
					var item = 0;
					for (let key in json) {
						item ++;
						if((item % 10) == 0 ){
						page++;
						}
						// console.log(item);
						$('#task_list').append(`
							<div page=${page} id="LineRow${json[key]['id']}" class='rowNewTask'>
							<form onsubmit='return false' method='POST'>
								<div id='numItemtitleTaskRow'>${json[key]['id']}</div>
								<div id='titleTaskRow'>
									<div id='dateItemtitleTaskRow' class='ItemtitleTaskRow'>${json[key]['date_create']}</div>
									<div id='titleItemtitleTaskRow' class='ItemtitleTaskRow'>${json[key]['title']}</div>
									<div id='priorityItemtitleTaskRow' class='ItemtitleTaskRow'>${json[key]['priority']}</div>
								</div>
								<h3 style='margin:15px; color:#636363'>[${json[key]['status']}]здача от ${json[key]['task_from']} для ${json[key]['task_for']}</h3>
								<div id='taskRow'>${json[key]['task']}</div>
								<div id='bottomTaskRow${json[key]['id']}' class='bottomRow'>
									<div id='CompliteItemBottomTaskRow${json[key]['id']}' class='itemBottomTaskRow'>
										<span id='editStatusBottomTaskRow${json[key]['id']}' onclick='editStatusButtomClick(${json[key]['id']})'>СМЕНИТЬ СТАТУС</span>
										<div id='editStatus${json[key]['id']}' class='editStatus'>
												<select name='status'>
													<option value='1'>активный</option>
													<option value='2'>выполнен</option>
													<option value='3'>удалить</option>
													<option value='0'>DROP</option>
													</select>
												<input type='hidden' name='title' value='${json[key]['title']}'>
												<input type='hidden' name='id' value='${json[key]['id']}'>
												<input type='hidden' name='task_from' value='${json[key]['task_from']}'>
												<input type='hidden' name='task_for' value='${json[key]['task_for']}'>
												<input type='hidden' name='formPost' value='ИЗМЕНИТЬ СТАТУС'>
												<input type='submit' value='ИЗМЕНИТЬ СТАТУС' id='editFormStatus'>
											
										</div>
									</div>
									<div id='editItemBottomTaskRow${json[key]['id']}' class='itemBottomTaskRow'>
										<span id='editBottomTaskRow${json[key]['id']}' onclick='buttomClickEdit(${json[key]['id']})'>ИЗМЕНИТЬ</span>
										
										<input type='hidden' name='formPost' value='СОХРАНИТЬ'>
										<input id='saveBottomTaskRow${json[key]['id']}' class='saveBottomTaskRow' type='submit' value='СОХРАНИТЬ' id='editForm'>
									</div>
								</div>
							</form>
							</div>
						`);	
						if (page >= 2) {
							$("#LineRow"+json[key]['id']).css('display','none');
						}
					}
					$('#task_list').append(`
						<div id="hrefs"></div>
					`);
					for (let i = 1; i<=page ; i++){
						$('#hrefs').append(`
							<span id="page" onclick="next_page(${i})" >${i}</span>
						`);
					}
				});
			}
			get_filtered(0);
			
			$("document").ready(function(){
				$("#create_tesk").on("submit",function () {
					var post = $(this).serializeArray();
					  var postArray = {};
					  $.each(post, function(index, field) {
						postArray[field.name] = field.value;
					  });
					var filter = {par:'create',data:{create:postArray}};
					console.log(filter);
					$.post('api.php', filter, function(data){
						console.log(data);
						location.reload();
					})
				});
			});
			$("#editFormStatus").click(function() {
			  console.log('editFormStatusq');
			  var post = $(this).serializeArray();
				var postArray = {};
				$.each(post, function(index, field) {
				  postArray[field.name] = field.value;
				});
				console.log(postArray);
			});
			
			$(".saveBottomTaskRow").click(function() {
			  console.log('saveBottomTaskRow1');
			  var post = $(this).serializeArray();
				var postArray = {};
				$.each(post, function(index, field) {
				  postArray[field.name] = field.value;
				});
				console.log(postArray);
			});
		</script>
		<style>
			#filter span{
				width: 24%;
				background: #373737;
				border: none;
				border-radius: 3px;
				color: #f0f0f0;
				height: 25px;
				margin: 10px 0;
			}
			#filter{
				display: flex;
				justify-content: space-around;
			}
			#hrefs{
				text-align: center;
				margin: 15px;
			}
			#page{
				text-decoration: none;
				color:#f0f0f0;
				font-size: 20px;
				padding: 5px;
			}
			*{
				margin: 0;
				padding: 0;
			}
			body{
				background: #1c1c1c;
				color: #f0f0f0;
			}
			textarea {
			  resize: none;
			  border: none;
			  border-radius: 3px;
			  background: rgb(55, 55, 55);
			  color: #f0f0f0;
			}
			input{
				border: none;
				border-radius: 3px;
				background: #373737;
				color: #f0f0f0;
			}
			.shadow{
				/* box-shadow: 0px 0px 6px 4px rgba(55, 55, 55, 0.5); */
			}
			.statusForm{
				width: 24%;
				background: #373737;
				border: none;
				border-radius: 3px;
				color:  #f0f0f0;
				height: 25px;
				margin: 10px 0;
				
			}
			#Table{
				width: 80%;
				margin: 0 10%;
			}
			#sectionTable{
				width: 100%;
			}
			
			#LineRow{
				width: 100%;
				text-align: center;
			}
			.rowNewTask{
				border: 3px solid #373737;
				border-radius: 3px;
				margin-top: 15px;
				padding: 3px;
				z-index: 100;
			}
			#titleInput{
				height: 27px;
			}
			#CreateTaskButton{
				height: 27px;
			}
			#CreateTask{
				padding-top: 10px;
				display: none;
				text-align: center;
				background: rgba(227, 44, 99, 0.815);
				border-radius: 3px;
				/* box-shadow: 0px 0px 6px 4px rgba(255, 217, 0, 0.415); */
				
			}
			#taskInput {
				width: 97%;
				margin: 1.5%;
			}
			#priorityItemCreateTask{
				width: 10%;
				/* margin-left: 3%; */
			}
			#priorityItemCreateTask select{
				width: 100%;
				text-align: center;
			}
			
			#titleItemCreateTask{
				width: 68%;
			}
			#titleItemCreateTask input{
				width: 100%;
			}
			#saveItemCreateTask{
				width: 8%;
				/* margin-right: 3%; */
			}
			#saveItemCreateTask input{
				width: 100%;
			}
			
			#newtaskButton{
				width: 100%;
				display: inline-block;
				  background-color: rgba(227, 44, 99, 0.815);
				  font-weight: bold;
				  border-radius: 3px;
				  border-color: rgba(227, 44, 99, 0.815);
				  transition: background-color 0.5s ease;
				  height: 35px;
				  color: #f0f0f0;
				  text-shadow: -1px -1px 0 #7c7c7c, 1px -1px 0 #7c7c7c, -1px 1px 0 #7c7c7c, 1px 1px 0 #7c7c7c;
			}
			#titleTaskRow{
				min-height: 25px;
				width: 100%;
				background: #373737;
				padding: 3px 0;
				border-radius: 3px; 
			}
			/* #titleTaskRow input{
				display: none;
			}
			.rowNewTask textarea{
				display: none;
			} */
			
			#numItemtitleTaskRow{
				width: 0%;
				position: absolute;
				font-size: 140px;
				z-index: -1;
				color: rgba(227, 44, 99, 0.815);
				font-weight: 900;
				opacity:0.15;
			}
			#dateItemtitleTaskRow{
				width: 12%;
				text-align:center;
				font-size: 12px;
			}
			#titleItemtitleTaskRow{
				width: 70%;
				text-align:center;
				font-size: 18px;
				margin: 4px;
			}
			/* #titleItemtitleTaskRow input{
				max-width: 70%;
			} */
			#priorityItemtitleTaskRow{
				width: 10%;
				text-align:center;
				font-size: 12px;
			}
			#editFormStatus{
				width: 83%;
				height: 27px;
			}
			
			#taskRow{
				width: 95%;
				padding: 20px 10px;
			}
			.bottomRow{
				text-align: center;
			}
			
			.ItemtitleTaskRow{
				vertical-align: middle;
				display: inline-block;
				text-align:center;
			}
			#bottomTaskRow{
				text-align:center;
			}
			.editStatus{
				display: none;
			}
			.itemBottomTaskRow{
				display: inline-block;
				width: 49%;
			}
			select[name="status"]{
				border: none;
				border-radius: 3px;
				height: 27px;
				background: #373737;
				color: #f0f0f0;
				text-align: center;
			}
			select[name="priority"]{
				border: none;
				border-radius: 3px;
				height: 27px;
				background: #373737;
				color: #f0f0f0;
				text-align: center;
			}
			select[name="task_for"]{
				border: none;
				border-radius: 3px;
				height: 27px;
				background: #373737;
				color: #f0f0f0;
				text-align: center;
			}
			.itemBottomTaskRow span{
				width: 100%;
				background: #373737;
				border: none;
				border-radius: 3px;
				color: #f0f0f0;
				display: block;
				padding: 4px 0;
			}
			.itemBottomTaskRow input{
				width: 100%;
				background: #373737;
				border: none;
				border-radius: 3px;
				height: 25px;
				color: #f0f0f0;
			}
			.saveBottomTaskRow{
				display: none;
			}
		</style>
		<script>
			function Createtask() {
				let newtaskButton = document.getElementById('newtaskButton');
				newtaskButton.style.display = 'none';
				let newtaskBlock = document.getElementById('CreateTask');
				newtaskBlock.style.display = 'block';
			}
			function editStatusButtomClick(param) {
				let statusId = 'editStatusBottomTaskRow'+param;
				let statusIdSelector = 'editStatus'+param;
				console.log(statusId);
				let statusIdbutton = document.getElementById(statusId);
				statusIdbutton.style.display = 'none';
				let statusIdselector = document.getElementById(statusIdSelector);
				statusIdselector.style.display = 'block';
			}
			function buttomClickEdit(param) {
				
				let itemId = 'LineRow' + param;
				let itemIdButton = 'editBottomTaskRow' + param;
				let itemIdButtonSave = 'saveBottomTaskRow' + param;
				
				let selector = '#' + itemId + ' #titleItemtitleTaskRow';
				var element = document.querySelector(selector);
				console.log(element.textContent);
				var input = document.createElement('input');
				input.type = 'text';
				input.value = element.textContent;
				input.id = 'titleItemtitleTaskRow';
				input.className = 'ItemtitleTaskRow';
				input.name = 'title';
				element.replaceWith(input);
				
				let selector1 = '#' + itemId + ' #taskRow';
				var element1 = document.querySelector(selector1);
				newStr = element1.outerHTML.replace(/<br>/g, "\n");
				newStr = newStr.replace(/<div id="taskRow">/g, "\n");
				newStr = newStr.replace(/<\/div>/g, "\n");
				var textarea = document.createElement('textarea');
				textarea.type = 'text';
				textarea.value = newStr;
				textarea.id = 'taskInput';
				textarea.rows = 15;
				textarea.name = 'task';
				element1.replaceWith(textarea);
				
				let editButtomClickEdit = document.getElementById(itemIdButton);
				editButtomClickEdit.style.display = 'none';
				
				let saveButtomClickEdit = document.getElementById(itemIdButtonSave);
				saveButtomClickEdit.style.display = 'block';
				
			}
			
			var url = window.location.href;
			console.log(url);
			var elementId = url.split("#")[1];
			console.log(elementId);
			var element = document.getElementById(elementId);
			console.log(element);
			if (element) {
				element.style.border = "3px solid rgba(255, 217, 0, 1)";
			}
		</script>
	</body>
</html>
<?}