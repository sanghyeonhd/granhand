<?php
require_once "../inc/config_default.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?=$G_ADMINNAME;?> Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta content="" name="description" />
<meta content="themes-lab" name="author" />
<link rel="shortcut icon" href="<?=$G_FAIMG;?>">
<link href="/assets/css/layout.css" rel="stylesheet">
</head>
<body>
<div class="min-h-screen flex flex-col items-center justify-center bg-gray-50">
	<div class="w-full max-w-md space-y-8 p-8">
		<div class="text-center mb-20">
			<h2 class="text-2xl font-bold tracking-tight">GRANHAND</h2>
		</div>
		<form class="space-y-6" method="post" action="/exec/proc.php?act=member&han=adminlogin">
			<div class="space-y-2">
				<label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="«Routrl7»-form-item">아이디</label>
				<input class="flex w-full rounded-md border bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm h-12 undefined" placeholder="아이디를 입력해 주세요." id="«Routrl7»-form-item" aria-describedby="«Routrl7»-form-item-description" aria-invalid="false" name="id" value="">
			</div>
			<div class="space-y-2">
				<label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70" for="«R18utrl7»-form-item">비밀번호</label>
				<input type="password" class="flex w-full rounded-md border bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm h-12 undefined" placeholder="비밀번호를 입력해 주세요." id="«R18utrl7»-form-item" aria-describedby="«R18utrl7»-form-item-description" aria-invalid="false" name="passwd" value="">
			</div>
			<button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 px-4 py-2 w-full bg-[#DBD7D0] text-white hover:bg-gray-300 h-12" type="submit">로그인</button>
		</form>
	</div>
</div>
</body>
</html>
