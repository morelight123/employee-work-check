<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>职级码表</title>
    <?php include __DIR__.'/../public/favicon.php';?>
    <link rel="stylesheet" type="text/css" href="<?php echo $assetUrl;?>/public/layui/css/layui.css" />
    <script type="text/javascript" src="<?php echo $assetUrl;?>/public/layui/layui.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $assetUrl;?>/css/public/global.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $assetUrl;?>/css/base/public.css" />
</head>
<body>
    <?php include __DIR__.'/../public/header.php';?>
    <div class="main container">
       <?php include __DIR__.'/../public/baseNav.php';?>
       <div class="content">
     
           <div class="table">
               <table>
			   
                   <tr>
                       <th>代码</th>
                       <th>职级名称</th>
                   </tr>
                  
				   
				   <?php
				   foreach($list as $key => $item) { ?>
					 <tr>
                       <td> <?php echo $key; ?></td>
                       <td><?php echo $item; ?></td>
					   </tr>
				  <?php  } ?>
				   
                   
               </table>
           </div>
       </div>
    </div>

</body>

</html>