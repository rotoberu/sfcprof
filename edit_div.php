<?php
 ini_set('display_errors', "On");
?>

<?php
session_start();
if( isset($_SESSION['user']) != "") {
	// ログイン済みの場合はリダイレクト
	#header("Location: home.php");
}

// DBとの接続
include_once 'dbconnect.php';

// 現在データベースに格納されている情報の取り出し
$query = "SELECT * FROM users WHERE user_id=".$_SESSION['user']."";
$result = $mysqli->query($query);

if (!$result) {
	print('クエリーが失敗しました。' . $mysqli->error);
	$mysqli->close();
	exit();
}
while ($row = $result->fetch_assoc()) {
	$username = $row['username'];
	$biography = $row['biography'];
}

?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>プロフ更新</title>
<link rel="stylesheet" href="style.css">

<!-- Bootstrap読み込み（スタイリングのため） -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
</head>
<body>
<div class="col-xs-6 col-xs-offset-3">

<?php
// signupがPOSTされたときに下記を実行
if(isset($_POST['update'])) {

	$username = $mysqli->real_escape_string($_POST['username']);
  $biography = $mysqli->real_escape_string($_POST['biography']);

	#$email = $mysqli->real_escape_string($_POST['email']);
	#$password = $mysqli->real_escape_string($_POST['password']);
	#$password = password_hash($password, PASSWORD_BCRYPT);

	// POSTされた情報をDBに格納する
  $query = "SELECT * FROM users WHERE user_id=".$_SESSION['user']."";
  $result = $mysqli->query($query);
  while ($row = $result->fetch_assoc()) {
  	$user_id = $row['user_id'];
  }

  $filepath = $up_dir . $_FILES["upfile"]["name"];
  if (move_uploaded_file($_FILES["upfile"]["tmp_name"], $filepath)) {
    chmod($filepath, 0644);
    print ( "ファイル\"". $_FILES["upfile"]["name"] . "\"をアップロードしました。<br><br>\n");
    return true;
  } else {
    print ( "アップロードエラー：ファイルのアップロードに失敗しました<br>\n");
    return false;
  }

  $query = "UPDATE users SET username = '$username', biography = '$biography'  WHERE user_id= '$user_id'";
	if($mysqli->query($query)) {  ?>
		<div class="alert alert-success" role="alert">登録しました</div>
		<?php } else { ?>
		<div class="alert alert-danger" role="alert">エラーが発生しました。</div>
		<?php
	}
} ?>

<form method="post" enctype="multipart/form-data">
  <h1>更新ページ</h1>
  <h3>ユーザーネーム</h3>
	<div class="form-group">
		<input type="text" class="form-control" name="username" value="<?php echo $username ?>" placeholder="ユーザー名" required />
	</div>
  <h3>アイコン</h3>
  <div class="form-group">
    <input type="file" name="upfile" size="30" />
  </div>
  <h3>biography</h3>
  <div class="form-group">
    <textarea class="form-control" name="biography" placeholder="biography" required  cols="50" rows="10" ><?php echo $biography ?></textarea>
  </div>
	<!--   <div class="form-group">
      <input type="text" class="form-control" name="biography" value="<?php echo $biography ?>" placeholder="biography" required />
    </div>
  <div class="form-group">
		<input type="email"  class="form-control" name="email" placeholder="メールアドレス" required />
	</div>
	<div class="form-group">
		<input type="password" class="form-control" name="password" placeholder="パスワード" required />
	</div> -->
  <button type="submit" class="btn btn-default" name="update">アップデート</button>
  <a href="home.php">戻る</a>
</form>

</div>
</body>
</html>
