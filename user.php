<?php
session_start();
include_once 'dbconnect.php';

//URLからユーザー名を引数として
if(isset($_GET['id'])){
	$id = $_GET['id'];
}

// ユーザーIDからユーザー名を取り出す
$query = "SELECT * FROM users WHERE user_id=".$_GET['id']."";
$result = $mysqli->query($query);

#$result = $mysqli->query($query);

if (!$result) {
	print('クエリーが失敗しました。' . $mysqli->error);
	$mysqli->close();
	exit();
}

// ユーザー情報の取り出し
while ($row = $result->fetch_assoc()) {
	$username = $row['username'];
	$email = $row['email'];
	$biography = $row['biography'];
}

// データベースの切断
$result->close();

?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?php echo $username; ?>のポートフォリオ</title>
<link rel="stylesheet" href="style.css">
<!-- Bootstrap読み込み（スタイリングのため） -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
</head>
</head>
<body>
<div class="col-xs-6 col-xs-offset-3">

<h1>プロフィール</h1>
名前：<?php echo $username; ?></br>
メールアドレス：<?php echo $email; ?></br>
biography：</br>
<?php echo nl2br($biography); ?></br>

<a href="home.php">ホームへ</a>

</div>
</body>
</html>
