<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        body{
            height: 100vh;
            width:100vw;
            font-size: 100%;
            background-image: url(../img/icloud.png);
            background-repeat: repeat-x;  
            background-size: auto 100%; 
            font-family: 'Helvetica Neue','Microsoft Yahei',SimHei,sans-serif;
            color:#fff;
            overflow:hidden;
        }
        .form {
            position:fixed;
            display: flex;
				flex-direction: column;
            height:80%;
			width:80%;
			/*background-color: rgba(255, 255, 255, 0.5);  半透明背景 */  
			background: linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.5)); /* 折射渐变 */
			/*box-shadow: 0px -10px 20px rgba(255, 255, 255, 0.5);  反射阴影 */
			box-shadow: 0rem 0rem 1rem rgba(255, 255, 255, 0.8); /* 高光阴影 */ 
			margin: 2% 8%;
			border-radius:1rem;
			padding:1%;
			font-weight: 400;
            font-size: 2rem;
            font-family: MyriadSetPro-Thin;
            line-height: 2rem;
		}
		.form>div{
		    width:100%;
		    margin:2rem 0rem;
		    display:flex;
			align-items: center;
			flex-wrap: wrap;
		}
		.form-label{
		    height: 2rem;
            color: #FFF;
            text-align: center;
            text-shadow: 0 0 1rem #111;
		}
		.radio{
		    width:2rem;
		    height:2rem
		}
		.form-value{
		    flex:1;
            font-size: 2rem;
            line-height: 3rem;
		    height: 3rem;
		    border-radius:.5rem;
		}
		.custom-file-input {  
          display: inline-block;  
          width: 100%; /* 或其他你想要的宽度 */  
          padding: 10px;  
          border-radius: 5px;  
          cursor: pointer;  
        }
        .submit{
            width:80%;
            height:4rem;
            font-size: 2rem;
            line-height:4rem;
            margin:auto 10%;
        }
    </style>
</head>
<body>

<?php
// 检查表单是否已提交
if(isset($_POST["submit"])) {
    // 检查文件是否成功上传
    if(isset($_FILES["image"])) {
        $file = $_FILES["image"];
        // 获取文件的信息
        $fileName = $file["name"];
        $fileTmpPath = $file["tmp_name"];
        $fileSize = $file["size"];
        $fileError = $file["error"];
        // 检查文件是否上传成功
        if($fileError === 0) {
            // 检查文件大小
            if($fileSize <= 128 * 1024) { // 128 KB
                // 获取表单中的其他数据
                $name = $_POST["name"];
                $redirect = $_POST["redirect"];
                $position = $_POST["position"];
                $time = time();
                // 确定文件的存储路径
                $uploadsImgDirectory = "img/png/";
                $destinationPath = $uploadsImgDirectory . $position .'_'.$time;

                // 将文件移动到目标路径
                move_uploaded_file($fileTmpPath, $destinationPath);

                // 将表单数据写入本地文件
                $data = '<li>
    <a href="'.(filter_var($redirect, FILTER_VALIDATE_URL)?'':'http://<?php echo $lanip ?>').$redirect.'" target="_blank"><img class="shake diy" src="img/png/'.$position .'_'.$time.'" /><strong>'.$name.'</strong></a>
</li>';
                $uploadsHtmlDirectory = "icons_$position/";
                $infoFilePath = $uploadsHtmlDirectory . $time.'.html';
                file_put_contents($infoFilePath, $data);

                echo "文件上传成功并数据写入成功！".(filter_var($redirect, FILTER_VALIDATE_URL)?'':'http://<?php echo $lanip ?>').$redirect;
            } else {
                echo "文件大小超过限制！";
            }
        } else {
            echo "文件上传失败！";
        }
    }
}

//$filePath = '/'; // 设置要删除的目录路径

if(isset($_GET['filename'])) {
    $filename = $_GET['filename'];
    $fileToDelete = $filename;

    if(is_file($fileToDelete)) {
        if(unlink($fileToDelete)) {
            echo "文件删除成功!";
            // 可以执行其他操作，如日志记录等
        } else {
            echo "文件删除失败!";
            // 可以执行其他操作，如日志记录等
        }
    } else {
        echo "文件不存在!";
        // 可以执行其他操作，如日志记录等
    }
}
?>

<form class="form" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
  <div>
    <label class="form-label" for="name">名称:</label>
    <input class="form-value" type="text" id="name" name="name">
  </div>
  <div>
    <label class="form-label" for="name">位置:</label>
    <input class="radio" type="radio" name="position" value="lan" checked>局域网 
    <input class="radio" type="radio" name="position" value="wan">外网 
  </div>
  <div>
    <label class="form-label" for="redirect">链接:</label>
    <input class="form-value"type="text" id="redirect" name="redirect">
  </div>
  
    
    <div onclick="document.getElementById('image').click()">  
     <label class="form-label" for="image">图标:</label>
      <span id="imageName">点击选择文件</span>  
      <input class="form-value" type="file" id="image" name="image" style="display: none;">  
    </div>
  <br><br>

  <input class="submit" type="submit" name="submit" value="提交">
</form>
<script>  
  function validateForm() {  
    // 获取表单元素  
    var nameInput = document.getElementById("name");  
    var redirectInput = document.getElementById("redirect");  
    var imageInput = document.getElementById("image");  
  
    // 检查名称是否为空  
    if (nameInput.value.trim() === "") {  
      alert("请填写名称！");  
      nameInput.focus();  
      return false;  
    }  
  
    // 检查跳转路径是否为空  
    if (redirectInput.value.trim() === "") {  
      alert("请填写链接！");  
      redirectInput.focus();  
      return false;  
    }  
  
    // 检查是否选择了图片  
    if (imageInput.files.length === 0) {  
      alert("请选择图片！");  
      imageInput.focus();  
      return false;  
    }  
    console.log(redirectInput.value);
    // 表单验证通过，允许提交  
    return true;  
  }  
  document.getElementById('image').addEventListener('change', function(e) {  
      var file = e.target.files[0];  
      if (file) {  
        var fileName = file.name; // 这就是文件名  
        console.log(fileName); // 在控制台打印文件名  
        document.getElementById("imageName").innerHTML = fileName
      }  
    });  
</script>
</body>
</html>
