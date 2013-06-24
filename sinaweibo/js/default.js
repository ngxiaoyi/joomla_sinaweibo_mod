$(function() {          

	$("#postweibo").click(function(){
		if($("#weibotext").val()==''){
			alert("微博内容不能为空！");
			return;
		}
		$("#sendform").hide();
		$("#waiting").show();
		$("#sendform").submit();
		$("#sendform")[0].reset();
		$("#waiting").hide();
		$("#sendform").show();

	});

});