<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>考核结果分析</title>
    <?php include __DIR__.'/../public/favicon.php';?>
    <link rel="stylesheet" type="text/css" href="<?php echo $assetUrl;?>/public/layui/css/layui.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assetUrl;?>/public/iconfont/iconfont.css" />
    <script type="text/javascript" src="<?php echo $assetUrl;?>/public/layui/layui.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $assetUrl;?>/css/public/global.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assetUrl;?>/css/result/public.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assetUrl;?>/css/base/org.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assetUrl;?>/css/result/details.css" />
    <style type="text/css">
        .tip b{color:#30a1f2;font-size:16px;}
    </style>
</head>
<body>
    <?php include __DIR__.'/../public/header.php';?>
    <?php if(!empty($__task__)){?>
    <div class="title">
        <div class="main row">
            <div class="assessName" title="<?php if(!empty($__task__)) echo $__task__['title'];?>  考核时间：<?php if(!empty($__task__)) echo $__task__['start_time'].' 一 '.$__task__['end_time'];?>">当前考核任务：<?php if(!empty($__task__)) echo $__task__['title'];?><label>考核时间：<?php if(!empty($__task__)) echo $__task__['start_time'].' 一 '.$__task__['end_time'];?></label></div>
        </div>
    </div>
    <?php }?>
    <div class="container row main">
        <?php include __DIR__.'/../public/resultLeft.php';?>
        <div class="right">
            <div class="content">
                <form class="layui-form" method="get" action="normal">
                    <div class="layui-form-item">
                    <div class="layui-input-inline" style="width:auto;"><input type="radio" data="1" lay-filter="type" name="like[write]" value="1" title="打分主体" <?php if(!empty($distinction)&&$distinction==1){ echo 'checked';} ?>></div>
                    <div class="layui-input-inline" style="width:auto;"><input type="radio" data="2" lay-filter="type" name="like[write]" value="2" title="考核对象" <?php if(!empty($distinction)&&$distinction==2){ echo 'checked';} ?> ></div>
                    <div class="layui-input-inline" style="width:300px;"><input type="text" placeholder="请输入打分主体" class="layui-input" id="searchContent" name="username" value="<?php echo empty($username)?'':$username ?>" lay-verify="required" /></div>
                        <!-- <a href="javascript:;" class="layui-btn layui-btn-normal" id="search">搜索</a> -->
                        <button class="layui-btn layui-btn-normal" lay-submit="" id="search">搜索</button>
                        <p class="errMes"></p>
                        <input type="hidden" class="searchType" value="<?php echo empty($distinction)?'':$distinction?>">
                        <input type="hidden" name="show" id="show" value="<?php echo empty($username)?'':$username ?>">
                    </div>
                </form>
                <p class="tip"></p>
                <div class="table">
                    <table>
                        <tr>
                            <th style="width:35px;">序号</th>
                            <th>部门</th>
                            <th>姓名</th>
                            <th>职务</th>
                            <th style="width:80px;">是否打分</th>
                        </tr>
                        <tr id="msg" <?php if(!empty($list))echo "style='display:none;'";?>><td colspan="7" style="text-align:center;color:red;">暂无数据</td></tr>
						<?php 
						$i=1;
						if ($list) {
						foreach ($list as $key => $value) { ?>
							<tr>
							<td><?php echo $i ?></td>
							<td><?php echo $value['name'] ?></td>
							<td><?php echo $value['username'] ?></td>
							<td><?php echo $value['place'] ?></td>
							<td><?php echo $value['status'] ?></td>
							</tr>
						<?php ++$i;}
						}  
						//else { ?>
						<!--<tr><td></td>
						<td></td>
						<td align="center">无任何搜索结果！</td>
						<td></td>
						<td></td></tr>
						<?php //} ?>       -->

                        <!--<tr>
                            <td>1</td>
                            <td>人事</td>
                            <td>姓名1</td>
                            <td>处长</td>
                            <td>√</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>人事</td>
                            <td>姓名1</td>
                            <td>处长</td>
                            <td></td>
                        </tr>
						-->
                    </table>
                </div>
                <div class="tip" style="display:none;">
                    <i class="layui-icon">&#xe645;</i>
                    请输入想查看的对象
                </div>
            </div>            
        </div>
    </div>
<script type="text/javascript">
layui.use(['form', 'jquery','layer'], function(){ 
    var $=layui.jquery;
    var form = layui.form();
    var layer=layui.layer;
    var show=$("#show").val();

    var href=location.href;
    if(href.indexOf("username=")>-1){
        $(".table").show();
        $(".tip").hide();
    }else{
        $(".table").hide();
        $(".tip").show();
    }
    $("#search").click(function(){
        if($(".searchType").val()==""){
            $(".errMes").text("请选择打分主体或考核对象");
            return false;
        }
    });
    
    if(show!==''){
        var txt=$.trim($("#searchContent").val());  
        $(".errMes").text("");
        if($(".searchType").val()=="1"){
            $(".tip").html("当前打分主体是<b>"+txt+"</b>，打分情况如下：");
        }else{
            $(".tip").html("当前考核对象是<b>"+txt+"</b>，被打分情况如下:");  
        }
    }
    

    form.on('radio(type)', function(data){ 
        if($(this).is(":checked")){
            $("#searchContent").attr("placeholder","请输入"+$(this).attr("title"));
            $(".searchType").val($(this).attr("data"));
            $(".errMes").text("");
        }
    });
});
        
    </script>
</body>
</html>