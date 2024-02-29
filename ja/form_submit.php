<?php header("Content-Type:text/html;charset=utf-8"); ?>
<?php //error_reporting(E_ALL | E_STRICT);
mb_language("uni") ;
mb_internal_encoding("utf-8");

// if($_SERVER["REQUEST_METHOD"] != "POST"){
//     header('Location: index'); 
//     exit;
// }
##-----------------------------------------------------------------------------------------------------------------##
#
#  PHPメールプログラム　フリー版 ver2.0.3 最終更新日2022/02/01
#　改造や改変は自己責任で行ってください。
#	
#  HP: http://www.php-factory.net/
#
#  重要！！サイトでチェックボックスを使用する場合のみですが。。。
#  チェックボックスを使用する場合はinputタグに記述するname属性の値を必ず配列の形にしてください。
#  例　name="当サイトをしったきっかけ[]"  として下さい。
#  nameの値の最後に[と]を付ける。じゃないと複数の値を取得できません！
#
##-----------------------------------------------------------------------------------------------------------------##
if (version_compare(PHP_VERSION, '5.1.0', '>=')) {//PHP5.1.0以上の場合のみタイムゾーンを定義
	date_default_timezone_set('Asia/Tokyo');//タイムゾーンの設定（日本以外の場合には適宜設定ください）
}
/*-------------------------------------------------------------------------------------------------------------------
* ★以下設定時の注意点　
* ・値（=の後）は数字以外の文字列（一部を除く）はダブルクオーテーション「"」、または「'」で囲んでいます。
* ・これをを外したり削除したりしないでください。後ろのセミコロン「;」も削除しないください。
* ・また先頭に「$」が付いた文字列は変更しないでください。数字の1または0で設定しているものは必ず半角数字で設定下さい。
* ・メールアドレスのname属性の値が「Email」ではない場合、以下必須設定箇所の「$Email」の値も変更下さい。
* ・name属性の値に半角スペースは使用できません。
*以上のことを間違えてしまうとプログラムが動作しなくなりますので注意下さい。
-------------------------------------------------------------------------------------------------------------------*/


//---------------------------　必須設定　必ず設定してください　-----------------------

//サイトのトップページのURL　※デフォルトでは送信完了後に「トップページへ戻る」ボタンが表示されますので
$site_top = "../ja/";

//管理者のメールアドレス ※メールを受け取るメールアドレス(複数指定する場合は「,」で区切ってください 例 $to = "aa@aa.aa,bb@bb.bb";)
$to = "info@murasaki-japanese.com";

//送信元メールアドレス（管理者宛て、及びユーザー宛メールの送信元メールアドレスです）
//必ず実在するメールアドレスでかつ出来る限り設置先サイトのドメインと同じドメインのメールアドレスとすることを強く推奨します
//管理者宛てメールの返信先（reply）はユーザーのメールアドレスになります。
$from = "info@murasaki-japanese.com";

//フォームのメールアドレス入力箇所のname属性の値（name="○○"　の○○部分）
$Email = "Email";
//---------------------------　必須設定　ここまで　------------------------------------


//---------------------------　セキュリティ、スパム防止のための設定　------------------------------------

//スパム防止のためのリファラチェック（フォーム側とこのファイルが同一ドメインであるかどうかのチェック）(する=1, しない=0)
//※有効にするにはこのファイルとフォームのページが同一ドメイン内にある必要があります
$Referer_check = 1;

//リファラチェックを「する」場合のドメイン ※設置するサイトのドメインを指定して下さい。
//もしこの設定が間違っている場合は送信テストですぐに気付けます。
$Referer_check_domain = "murasaki-japanese.com";

/*セッションによるワンタイムトークン（CSRF対策、及びスパム防止）(する=1, しない=0)
※ただし、この機能を使う場合は↓の送信確認画面の表示が必須です。（デフォルトではON（1）になっています）
※【重要】ガラケーは機種によってはクッキーが使えないためガラケーの利用も想定してる場合は「0」（OFF）にして下さい（PC、スマホは問題ないです）*/
$useToken = 1;
//---------------------------　セキュリティ、スパム防止のための設定　ここまで　------------------------------------


//---------------------- 任意設定　以下は必要に応じて設定してください ------------------------

// Bccで送るメールアドレス(複数指定する場合は「,」で区切ってください 例 $BccMail = "aa@aa.aa,bb@bb.bb";)
$BccMail = "murasaki.japanese.form@gmail.com";



// 送信確認画面の表示(する=1, しない=0)
$confirmDsp = 1;

// 送信完了後に自動的に指定のページ(サンクスページなど)に移動する(する=1, しない=0)
// CV率を解析したい場合などはサンクスページを別途用意し、URLをこの下の項目で指定してください。
// 0にすると、デフォルトの送信完了画面が表示されます。
$jumpPage = 0;

// 送信完了後に表示するページURL（上記で1を設定した場合のみ）※httpから始まるURLで指定ください。（相対パスでも基本的には問題ないです）
$thanksPage = "";

// 必須入力項目を設定する(する=1, しない=0)
$requireCheck = 1;

/* 必須入力項目(入力フォームで指定したname属性の値を指定してください。（上記で1を設定した場合のみ）
値はシングルクォーテーションで囲み、複数の場合はカンマで区切ってください。フォーム側と順番を合わせると良いです。 
配列の形「name="○○[]"」の場合には必ず後ろの[]を取ったものを指定して下さい。*/
// $form_type = $_POST['form_type'];

$form_type = $_POST['form_type'];

switch($form_type) {
	case 'inquiry': //お問い合わせ
		$require = array('Subject', 'Sei', 'Mei', 'Email', 'Inquiry');
		$output_th = array(
			'Subject' => 'サービス種別',
			'Sei' => '姓',
			'Mei' => '名',
			'Sei_kana' => 'せい',
			'Mei_kana' => 'めい',
			'Email' => 'メールアドレス',
			'Phone' => '電話番号',
			'How' => '当校をどのようにしてお知りになりましたか？',
			'Inquiry' => 'お問い合わせ内容'
		);
		// 管理者宛に送信されるメールのタイトル（件名）
		$subject = "お問い合わせ";

		//自動返信メールテキスト
		$remail_text = <<< TEXT

		この度はお問い合わせフォームをご送信いただき、ありがとうございます。
		このメールは送信完了確認の自動返信メールです。
		お送りいただいた内容をこちらで確認でき次第、担当者よりご返信いたします。

		お送りいただいた内容は下記の通りです。

		TEXT;
		break;

	case 'trial': //無料体験レッスン
		$require = array('Sei', 'Mei', 'Email', 'Level', 'Courses', 'Trial_style', 'First_date', 'First_time');
		$output_th = array(
			'Sei' => '姓',
			'Mei' => '名',
			'Sei_kana' => 'せい',
			'Mei_kana' => 'めい',
			'Email' => 'メールアドレス',
			'Phone' => '電話番号',
			'Nationality' => '国籍',
			'Level' => '現在の日本語レベル',
			'Courses' => 'ご興味のあるコース',
			'Trial_style' => '体験レッスンのご希望実施方法',
			'First_date' => '体験レッスンのご希望日（第1希望）',
			'First_time' => '体験レッスンのご希望時間（第1希望）',
			'Second_date' => '体験レッスンのご希望日（第2希望）',
			'Second_time' => '体験レッスンのご希望時間（第2希望）',
			'Third_date' => '体験レッスンのご希望日（第3希望）',
			'Third_time' => '体験レッスンのご希望時間（第3希望）',
			'How' => '当校をどのようにしてお知りになりましたか？',
			'Inquiry' => 'ご質問・ご要望'
		);

		$subject = "無料体験レッスン・カウンセリング";
	
		$remail_text = <<< TEXT
	
		この度は無料体験レッスン・カウンセリングにお申し込みいただき、ありがとうございます。
		このメールは送信完了確認の自動返信メールです。
		お送りいただいた内容をこちらで確認でき次第、担当者よりご返信いたします。
	
		お送りいただいた内容は下記の通りです。
	
		TEXT;
		break;

	case 'seminars':
		$require = array('Seminar', 'Sei', 'Mei', 'Email');
		$output_th = array(
			'Seminar' => 'ご希望内容',
			'Sei' => '姓',
			'Mei' => '名',
			'Sei_kana' => 'せい',
			'Mei_kana' => 'めい',
			'Email' => 'メールアドレス',
			'Phone' => '電話番号',
			'Zip' => '郵便番号',
			'Address' => '住所',
			'How' => '当校をどのようにしてお知りになりましたか？',
			'Inquiry' => 'ご質問・ご要望'
		);

		$subject = "セミナーお申し込み";

		$remail_text = <<< TEXT

		この度は日本語教師向け研修お申し込みフォームをご送信いただき、ありがとうございます。
		このメールは送信完了確認の自動返信メールです。
		お送りいただいた内容をこちらで確認でき次第、担当者よりご返信いたします。

		お送りいただいた内容は下記の通りです。

		TEXT;
		break;
}




//----------------------------------------------------------------------
//  自動返信メール設定(START)
//----------------------------------------------------------------------

// 差出人に送信内容確認メール（自動返信メール）を送る(送る=1, 送らない=0)
// 送る場合は、フォーム側のメール入力欄のname属性の値が上記「$Email」で指定した値と同じである必要があります
$remail = 1;

//自動返信メールの送信者欄に表示される名前　※あなたの名前や会社名など（もし自動返信メールの送信者名が文字化けする場合ここは空にしてください）
$refrom_name = "MURASAKI JAPANESE INSTITUTE";

// 差出人に送信確認メールを送る場合のメールのタイトル（上記で1を設定した場合のみ）
$re_subject = "フォームの送信が完了いたしました";

//フォーム側の「名前」箇所のname属性の値　※自動返信メールの「○○様」の表示で使用します。
//指定しない、または存在しない場合は、○○様と表示されないだけです。あえて無効にしてもOK
$dsp_name = 'Sei';

//自動返信メールの冒頭の文言 ※日本語部分のみ変更可
// $remail_text = <<< TEXT

// フォームをご送信いただき、ありがとうございます。
// このメールは送信完了確認の自動返信メールです。
// お送りいただいた内容をこちらで確認でき次第、担当者よりご返信いたします。

// お送りいただいた内容は下記の通りです。

// TEXT;


//自動返信メールに署名（フッター）を表示(する=1, しない=0)※管理者宛にも表示されます。
$mailFooterDsp = 1;

//上記で「1」を選択時に表示する署名（フッター）（FOOTER～FOOTER;の間に記述してください）
$mailSignature = <<< FOOTER

──────────────────────
株式会社むらさきジャパニーズインスティテュート
〒105-0001　東京都港区虎ノ門2-5-5 ニュー虎ノ門ビル ３階
URL: https://www.murasaki-japanese.com/ja/
──────────────────────

FOOTER;


//----------------------------------------------------------------------
//  自動返信メール設定(END)
//----------------------------------------------------------------------

//メールアドレスの形式チェックを行うかどうか。(する=1, しない=0)
//※デフォルトは「する」。特に理由がなければ変更しないで下さい。メール入力欄のname属性の値が上記「$Email」で指定した値である必要があります。
$mail_check = 1;

//全角英数字→半角変換を行うかどうか。(する=1, しない=0)
$hankaku = 1;

//全角英数字→半角変換を行う項目のname属性の値（name="○○"の「○○」部分）
//※複数の場合にはカンマで区切って下さい。（上記で「1」を指定した場合のみ有効）
//配列の形「name="○○[]"」の場合には必ず後ろの[]を取ったものを指定して下さい。
$hankaku_array = array('Phone');

//-fオプションによるエンベロープFrom（Return-Path）の設定(する=1, しない=0)　
//※宛先不明（間違いなどで存在しないアドレス）の場合に 管理者宛に「Mail Delivery System」から「Undelivered Mail Returned to Sender」というメールが届きます。
//サーバーによっては稀にこの設定が必須の場合もあります。
//設置サーバーでPHPがセーフモードで動作している場合は使用できませんので送信時にエラーが出たりメールが届かない場合は「0」（OFF）として下さい。
$use_envelope = 0;

//機種依存文字の変換
/*たとえば㈱（かっこ株）や①（丸1）、その他特殊な記号や特殊な漢字などは変換できずに「？」と表示されます。それを回避するための機能です。
確認画面表示時に置換処理されます。「変換前の文字」が「変換後の文字」に変換され、送信メール内でも変換された状態で送信されます。（たとえば「㈱」の場合、「（株）」に変換されます） 
必要に応じて自由に追加して下さい。ただし、変換前の文字と変換後の文字の順番と数は必ず合わせる必要がありますのでご注意下さい。*/

//変換前の文字
$replaceStr['before'] = array('①','②','③','④','⑤','⑥','⑦','⑧','⑨','⑩','№','㈲','㈱','髙');
//変換後の文字
$replaceStr['after'] = array('(1)','(2)','(3)','(4)','(5)','(6)','(7)','(8)','(9)','(10)','No.','（有）','（株）','高');

//------------------------------- 任意設定ここまで ---------------------------------------------


// 以下の変更は知識のある方のみ自己責任でお願いします。

//----------------------------------------------------------------------
//  関数実行、変数初期化
//----------------------------------------------------------------------
//トークンチェック用のセッションスタート
if ($useToken == 1 && $confirmDsp == 1) {
	session_name('PHPMAILFORMSYSTEM');
	session_start();
}
$encode = "UTF-8";//このファイルの文字コード定義（変更不可）
if (isset($_GET)) $_GET = sanitize($_GET);//NULLバイト除去//
if (isset($_POST)) $_POST = sanitize($_POST);//NULLバイト除去//
if (isset($_COOKIE)) $_COOKIE = sanitize($_COOKIE);//NULLバイト除去//
if ($encode == 'SJIS') $_POST = sjisReplace($_POST,$encode);//Shift-JISの場合に誤変換文字の置換実行
$funcRefererCheck = refererCheck($Referer_check,$Referer_check_domain);//リファラチェック実行

//変数初期化
$sendmail = 0;
$empty_flag = 0;
$post_mail = '';
$errm ='';
$header ='';

if ($requireCheck == 1) {
	$requireResArray = requireCheck($require, $output_th);//必須チェック実行し返り値を受け取る
	$errm = $requireResArray['errm'];
	$empty_flag = $requireResArray['empty_flag'];
}
//メールアドレスチェック
if (empty($errm)) {
	foreach ($_POST as $key=>$val) {
		if ($val == "confirm_submit") $sendmail = 1;
		if ($key == $Email) $post_mail = h($val);
		if ($key == $Email && $mail_check == 1 && !empty($val)) {
			if (!checkMail($val)) {
				$errm .= "<p class=\"error_messe\">ご入力いただいたメールアドレスが有効ではありません。</p>\n";
				$empty_flag = 1;
			}
		}
	}
}

if (($confirmDsp == 0 || $sendmail == 1) && $empty_flag != 1) {
	
	//トークンチェック（CSRF対策）※確認画面がONの場合のみ実施
	if ($useToken == 1 && $confirmDsp == 1) {
		if (empty($_SESSION['mailform_token']) || ($_SESSION['mailform_token'] !== $_POST['mailform_token'])) {
			exit('Invalid Transition');
		}
		if (isset($_SESSION['mailform_token'])) unset($_SESSION['mailform_token']);//トークン破棄
		if (isset($_POST['mailform_token'])) unset($_POST['mailform_token']);//トークン破棄
	}
	
	//差出人に届くメールをセット
	if ($remail == 1) {
		$userBody = mailToUser($_POST, $dsp_name, $remail_text, $mailFooterDsp, $mailSignature, $encode, $output_th);
		$reheader = userHeader($refrom_name,$from,$encode);
		$re_subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($re_subject,"JIS",$encode))."?=";
	}
	//管理者宛に届くメールをセット
	$adminBody = mailToAdmin($_POST, $subject, $mailFooterDsp, $mailSignature, $encode, $confirmDsp, $output_th);
	$header = adminHeader($post_mail,$BccMail);
	$subject = "=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($subject,"JIS",$encode))."?=";
	
	//-fオプションによるエンベロープFrom（Return-Path）の設定(safe_modeがOFFの場合かつ上記設定がONの場合のみ実施)
	if ($use_envelope == 0) {
		mail($to,$subject,$adminBody,$header);
		if ($remail == 1 && !empty($post_mail)) mail($post_mail,$re_subject,$userBody,$reheader);
	} else {
		mail($to,$subject,$adminBody,$header,'-f'.$from);
		if ($remail == 1 && !empty($post_mail)) mail($post_mail,$re_subject,$userBody,$reheader,'-f'.$from);
	}

} else if ($confirmDsp == 1) { 

	/*　▼▼▼送信確認画面のレイアウト※編集可　オリジナルのデザインも適用可能▼▼▼　*/
	?>
	<!DOCTYPE HTML>
	<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
		<meta name="format-detection" content="telephone=no">
		<title>Confirm</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Noto+Sans:wght@200;300;400&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="../css/reset.css">
		<link rel="stylesheet" href="../css/inquiry.css">
	</head>
	<body>

	<div class="form-head">
        <img src="../img/footer_mji-logo.png">
    </div>
	<div class="form-area" id="formWrap">
		<?php if($empty_flag == 1) { ?>
			<h1 class="message">エラー</h1>
			<div class="error-contents">
				<p>フォームが正しく入力されておりません。下記のエラー内容をご確認いただき、再度入力してください。</p>
				<div class=error-detail>
					<?php echo $errm; ?><br /><br /><input type="button" value="前のページに戻る" onClick="history.back()" class="reset-button">
				</div>
			</div>
		<?php } else { ?>
			<h1>内容のご確認</h1>
			<p>ご入力いただいた内容をご確認いただき、問題がなければ「送信」をクリックしてください。</p>
			<form action="<?php echo str_replace('.php', '', h($_SERVER['SCRIPT_NAME'])); ?>" method="POST" class="form-contents">
				<input type="hidden" name="form_type" value="<?php echo $form_type; ?>" checked="checked">
				<table class="formTable">
					<?php echo confirmOutput($_POST, $output_th);//入力内容を表示?>
				</table>
				<p class="buttons">
					<input type="hidden" name="mail_set" value="confirm_submit">
					<input type="hidden" name="httpReferer" value="<?php echo h($_SERVER['HTTP_REFERER']);?>">
					<input type="submit" value="送信" class="confirm-button">
					<input type="button" value="前のページに戻る" onClick="history.back()" class="reset-button">
				</p>
			</form>
		<?php } ?>
	</div>

	<footer>
		<p>&copy; MURASAKI JAPANESE INSTITUTE</p>
	</footer>
	</body>
	</html>
	<?php
	/* ▲▲▲送信確認画面のレイアウト　※オリジナルのデザインも適用可能▲▲▲　*/
}

if (($jumpPage == 0 && $sendmail == 1) || ($jumpPage == 0 && ($confirmDsp == 0 && $sendmail == 0))) { 

	/* ▼▼▼送信完了画面のレイアウト　編集可 ※送信完了後に指定のページに移動しない場合のみ表示▼▼▼　*/
	?>
	<!DOCTYPE HTML>
	<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
		<meta name="format-detection" content="telephone=no">
		<title>Submitted</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=Noto+Sans:wght@200;300;400&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="../css/reset.css">
		<link rel="stylesheet" href="../css/inquiry.css">
	</head>
	<body>
		<div class="form-head">
			<img src="../img/footer_mji-logo.png">
		</div>
		<div class="form-area">
			<?php if ($empty_flag == 1) { ?>
					<h1 class="message">エラー</h1>
					<div class="error-contents">
						<p>フォームが正しく入力されておりません。下記のエラー内容をご確認いただき、「前画面に戻る」をクリックして再度入力してください。</p>
						<div class=error-detail>
							<?php echo $errm; ?><br /><br /><input type="button" value="前画面に" onClick="history.back()" class="reset-button">
						</div>
					</div>
				</div>
				<footer>
					<p>&copy; MURASAKI JAPANESE INSTITUTE</p>
				</footer>
				</body>
				</html>
			<?php } else { ?>
					<h1 class="message">送信が完了いたしました</h1>
					<div class="error-contents">
						<p>フォームの送信が完了いたしました。<br>すぐに自動返信メールが届きますのでご確認ください。<br>お送りいただいた内容が確認でき次第、担当者よりご返信いたします。</p>
					</div>
					<a href="<?php echo $site_top ;?>"  class="top-button">HOME</a>
				</div>
				<footer>
					<p>&copy; MURASAKI JAPANESE INSTITUTE</p>
				</footer>
	</body>
	</html>
	<?php 
	/* ▲▲▲送信完了画面のレイアウト 編集可 ※送信完了後に指定のページに移動しない場合のみ表示▲▲▲　*/
	}
}
//確認画面無しの場合の表示、指定のページに移動する設定の場合、エラーチェックで問題が無ければ指定ページヘリダイレクト
else if (($jumpPage == 1 && $sendmail == 1) || $confirmDsp == 0) { 
	if($empty_flag == 1){ ?>
<div align="center"><h4>フォームが正しく入力されておりません。下記のエラー内容をご確認いただき、「前画面に戻る」をクリックして再度入力してください。</h4><div style="color:red"><?php echo $errm; ?></div><br /><br /><input type="button" value=" 前画面に戻る " onClick="history.back()"></div>

<?php 
	} else { header("Location: ".$thanksPage); }
}

// 以下の変更は知識のある方のみ自己責任でお願いします。

//----------------------------------------------------------------------
//  関数定義(START)
//----------------------------------------------------------------------
function checkMail($str) {
	$mailaddress_array = explode('@',$str);
	if (preg_match("/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-zA-Z]+(\.[!#%&\-_0-9a-zA-Z]+)+$/", "$str") && count($mailaddress_array) ==2){
		return true;
	} else {
		return false;
	}
}
function h($string) {
	global $encode;
	return htmlspecialchars($string, ENT_QUOTES,$encode);
}
function sanitize($arr) {
	if (is_array($arr)) {
		return array_map('sanitize',$arr);
	}
	return str_replace("\0","",$arr);
}
//Shift-JISの場合に誤変換文字の置換関数
function sjisReplace($arr,$encode){
	foreach ($arr as $key => $val) {
		$key = str_replace('＼','ー',$key);
		$resArray[$key] = $val;
	}
	return $resArray;
}
//送信メールにPOSTデータをセットする関数
function postToMail($arr, $th){
	global $hankaku,$hankaku_array;
	$resArray = '';
	array_shift($arr);
	$i = 1;

	foreach ($arr as $key => $val) {
		$out = '';
		if (is_array($val)) {
			foreach ($val as $key02 => $item) { 
				//連結項目の処理
				if (is_array($item)) {
					$out .= connect2val($item);
				} else {
					$out .= $item . ', ';
				}
			}
			$out = rtrim($out,', ');
			
		} else { $out = $val; }//チェックボックス（配列）追記ここまで
		
		if (version_compare(PHP_VERSION, '5.1.0', '<=')) {//PHP5.1.0以下の場合のみ実行（7.4でget_magic_quotes_gpcが非推奨になったため）
			if (get_magic_quotes_gpc()) { $out = stripslashes($out); }
		}
		
		//全角→半角変換
		if ($hankaku == 1) {
			$out = zenkaku2hankaku($key,$out,$hankaku_array);
		}


		if ($out != "confirm_submit" && $key != "httpReferer") {

			switch($key) {
				case 'Sei':
					$resArray .= "【"."お名前】\n".h($out)." ";
					break;
				case 'Sei_kana':
					$resArray .= "【"."ふりがな】\n".h($out)." ";
					break;
				case 'First_date':
				case 'Second_date':
				case 'Third_date':
					$resArray .= "【"."体験レッスンのご希望日時（第".$i."希望）】\n".h($out)." ";
					$i += 1;
					break;
				case 'Mei':
				case 'Mei_kana':
				case 'First_time':
				case 'Second_time':
				case 'Third_time':
					$resArray .= h($out)."\n\n";
					break;
				default:
					$resArray .= "【".h($th[$key])."】\n".h($out)."\n\n";
			}
		}
	}
	return $resArray;
}
//確認画面の入力内容出力用関数
function confirmOutput($arr, $th) {
	global $hankaku,$hankaku_array,$useToken,$confirmDsp,$replaceStr;
	$html = '';

	array_shift($arr); //フォームの種類判別用のinputを削除
	$i = 1;

	foreach ($arr as $key => $val) {
		$out = '';
		if (is_array($val)) {
			foreach ($val as $key02 => $item) { 
				//連結項目の処理
				if (is_array($item)) {
					$out .= connect2val($item);
				} else {
					$out .= $item . ', ';
				}
			}
			$out = rtrim($out,', ');
			
		} else { $out = $val; }//チェックボックス（配列）追記ここまで
		
		if (version_compare(PHP_VERSION, '5.1.0', '<=')) {//PHP5.1.0以下の場合のみ実行（7.4でget_magic_quotes_gpcが非推奨になったため）
			if (get_magic_quotes_gpc()) { $out = stripslashes($out); }
		}
		
		//全角→半角変換
		if ($hankaku == 1) {
			$out = zenkaku2hankaku($key,$out,$hankaku_array);
		}
		
		$out = nl2br(h($out));//※追記 改行コードを<br>タグに変換
		$key = h($key);
		$out = str_replace($replaceStr['before'], $replaceStr['after'], $out);//機種依存文字の置換処理

		$key_space = str_replace("_", " ", $key);

		switch($key) {
			case 'Sei':
				$html .= '<tr><th>'.'お名前'.'</th><td><div class="confirm-double"><p>'.$out;
				$html .= '<input type="hidden" name="'.$key.'" value="'.str_replace(array("<br />","<br>"),"",$out).'" /></p>';
				break;
			case 'Sei_kana':
				$html .= '<tr><th>'.'ふりがな'.'</th><td><div class="confirm-double"><p>'.$out;
				$html .= '<input type="hidden" name="'.$key.'" value="'.str_replace(array("<br />","<br>"),"",$out).'" /></p>';
				break;
			case 'First_date':
			case 'Second_date':
			case 'Third_date':
				$html .= '<tr><th>体験レッスンのご希望日時（第'.$i.'希望）</th><td><div class="confirm-double"><p>'.$out;
				$html .= '<input type="hidden" name="'.$key.'" value="'.str_replace(array("<br />","<br>"),"",$out).'" /></p>';
				$i += 1;
				break;
			case 'Mei':
			case 'Mei_kana':
			case 'First_time':
			case 'Second_time':
			case 'Third_time':
				$html .= '<p>'.$out.'<input type="hidden" name="'.$key.'" value="'.str_replace(array("<br />","<br>"),"",$out).'" /></p>';
				$html .= "</div></td></tr>\n";
				break;
			default:
				$html .= "<tr><th>".$th[$key]."</th><td>".$out;
				$html .= '<input type="hidden" name="'.$key.'" value="'.str_replace(array("<br />","<br>"),"",$out).'" />';
				$html .= "</td></tr>\n";
		}
	}

	//トークンをセット
	if ($useToken == 1 && $confirmDsp == 1) {
		$token = sha1(uniqid(mt_rand(), true));
		$_SESSION['mailform_token'] = $token;
		$html .= '<input type="hidden" name="mailform_token" value="'.$token.'" />';
	}
	
	return $html;
}

//全角→半角変換
function zenkaku2hankaku($key,$out,$hankaku_array) {
	global $encode;
	if (is_array($hankaku_array) && function_exists('mb_convert_kana')) {
		foreach ($hankaku_array as $hankaku_array_val) {
			if ($key == $hankaku_array_val) {
				$out = mb_convert_kana($out,'a',$encode);
			}
		}
	}
	return $out;
}
//配列連結の処理
function connect2val($arr) {
	$out = '';
	foreach ($arr as $key => $val) {
		if ($key === 0 || $val == '') {//配列が未記入（0）、または内容が空のの場合には連結文字を付加しない（型まで調べる必要あり）
			$key = '';
		} elseif (strpos($key,"円") !== false && $val != '' && preg_match("/^[0-9]+$/",$val)) {
			$val = number_format($val);//金額の場合には3桁ごとにカンマを追加
		}
		$out .= $val . $key;
	}
	return $out;
}

//管理者宛送信メールヘッダ
function adminHeader($post_mail,$BccMail) {
	global $from;
	$header="From: $from\n";
	if ($BccMail != '') {
		$header.="Bcc: $BccMail\n";
	}
	if (!empty($post_mail)) {
		$header.="Reply-To: ".$post_mail."\n";
	}
	$header.="Content-Type:text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
	return $header;
}
//管理者宛送信メールボディ
function mailToAdmin($arr, $subject, $mailFooterDsp, $mailSignature, $encode, $confirmDsp, $th) {
	$adminBody = "「".$subject."」からメールが届きました\n\n";
	$adminBody .="＝＝＝＝＝＝＝＝＝＝\n\n";
	$adminBody .= postToMail($arr, $th);//POSTデータを関数からセット
	$adminBody .="\n＝＝＝＝＝＝＝＝＝＝\n";
	$adminBody .="送信された日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
	$adminBody .="送信者のIPアドレス：".@$_SERVER["REMOTE_ADDR"]."\n";
	$adminBody .="送信者のホスト名：".getHostByAddr(getenv('REMOTE_ADDR'))."\n";
	if ($confirmDsp != 1) {
		$adminBody.="問い合わせのページURL：".@$_SERVER['HTTP_REFERER']."\n";
	} else {
		$adminBody.="問い合わせのページURL：".@$arr['httpReferer']."\n";
	}
	if ($mailFooterDsp == 1) $adminBody.= $mailSignature;
	return mb_convert_encoding($adminBody,"JIS",$encode);
}

//ユーザ宛送信メールヘッダ
function userHeader($refrom_name,$to,$encode) {
	$reheader = "From: ";
	if (!empty($refrom_name)) {
		$default_internal_encode = mb_internal_encoding();
		if ($default_internal_encode != $encode) {
			mb_internal_encoding($encode);
		}
		$reheader .= mb_encode_mimeheader($refrom_name)." <".$to.">\nReply-To: ".$to;
	} else {
		$reheader .= "$to\nReply-To: ".$to;
	}
	$reheader .= "\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
	return $reheader;
}
//ユーザ宛送信メールボディ
function mailToUser($arr,$dsp_name,$remail_text,$mailFooterDsp,$mailSignature,$encode, $th) {
	$userBody = '';
	if (isset($arr[$dsp_name])) $userBody = h($arr[$dsp_name]). " 様\n";
	$userBody .= $remail_text;
	$userBody .="\n＝＝＝＝＝＝＝＝＝＝\n\n";
	$userBody .= postToMail($arr, $th);//POSTデータを関数からセット
	$userBody .="\n＝＝＝＝＝＝＝＝＝＝\n\n";
	$userBody .="送信日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
	if ($mailFooterDsp == 1) $userBody.= $mailSignature;
	return mb_convert_encoding($userBody,"JIS",$encode);
}
//必須チェック関数
function requireCheck($require, $th){
	$res['errm'] = '';
	$res['empty_flag'] = 0;

	$arr_i = array();
	foreach($_POST as $k => $v) {
		$arr_i[] = $k;
	}

	foreach($require as $requireVal){
		$existsFalg = '';

		foreach($_POST as $key => $val) {
			if($key == $requireVal) {

				$i = array_search($key, $arr_i);
				
				//連結指定の項目（配列）のための必須チェック
				if(is_array($val)){
					$connectEmpty = 0;
					foreach($val as $kk => $vv){
						if(is_array($vv)){
							foreach($vv as $kk02 => $vv02){
								if($vv02 == ''){
									$connectEmpty++;
								}
							}
						}
						
					}
					if($connectEmpty > 0){
						$res['errm'] .= "<p class=\"error_messe\">【".h($th[$key])."】 が未入力です。</p>\n";
						$res['empty_flag'] = 1;
					}
				}
				//デフォルト必須チェック
				elseif($val == ''){
					$res['errm'] .= "<p class=\"error_messe\">【".h($th[$key])."】 が未入力です。</p>\n";
					$res['empty_flag'] = 1;
				}
				
				$existsFalg = 1;
				break;
			}

		}
		
		if($existsFalg != 1){

				$res['errm'] .= "<p class=\"error_messe\">【".$th[$requireVal]."】 が未入力です。</p>\n";
				$res['empty_flag'] = 1;
		}
	}
	
	return $res;
}
//リファラチェック
function refererCheck($Referer_check,$Referer_check_domain) {
	if ($Referer_check == 1 && !empty($Referer_check_domain)) {
		if (strpos($_SERVER['HTTP_REFERER'],$Referer_check_domain) === false) {
			return exit('<p align="center">Bad Referrerフォームページのドメインとこのファイルのドメインが一致しません</p>');
		}
	}
}
function copyright() {
	echo '<a style="display:block;text-align:center;margin:15px 0;font-size:11px;color:#aaa;text-decoration:none" href="http://www.php-factory.net/" target="_blank">- PHP工房 -</a>';
}
//----------------------------------------------------------------------
//  関数定義(END)
//----------------------------------------------------------------------
?>