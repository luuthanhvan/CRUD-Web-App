<?php 
	// connect đến CSDL
	$connection = new mysqli("localhost", "root", "", "thongtinbenh"); // có bieesnconnection, lớp có sẵn trong php là mysqli có 4 tham số là tên miền localhost, tên ng dùng root, mậu khẩu là rỗng, tên cơ sở dữ liệu thongtinbenh, quy định truyền tham số là phải đúng thứ tự
	$connection->set_charset("utf8"); // có tiếng việt
?>