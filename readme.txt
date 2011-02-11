***************************************************************************
	携帯用ライブラリ「Ktai Library」説明書
	Copyright 2009-2011 ECWorks ( http://www.ecworks.jp/ )
***************************************************************************

　ダウンロードいただきましてありがとうございます。

　本ドキュメントでは、携帯サイトの構築に必要な機能を提供する携帯ライブラリと、
CakePHP内で利用するためのヘルパー・コンポーネント一式についての設置方法および
設定方法について簡単にご説明させていただきます。設置する前にご一読いただきます
よう、お願い申し上げます。


--------------------------------------------------
■はじめに
--------------------------------------------------

　本ライブラリ群は、CakePHPを利用して携帯サイトを手軽に構築するための機能を
提供いたします。とりわけ、キャリア毎の絵文字変換およびキャリア判定・メール判定は
本ライブラリ群を利用することで簡単に行えるようになります。
　なお本ライブラリ単体は、CakePHPに限らずPHP環境でしたらインクルードすることで
使えるように作成されておりますので、幅広いシチュエーションでご利用できます。


--------------------------------------------------
■動作環境
--------------------------------------------------

　本ライブラリは、PHP4/5で動作するように作成されています。チェックはPHP5環境にて
行っております。
　CakePHP用ヘルパー・コンポーネントは、CakePHP1.3.0 Stableにて動作確認を
しておりますが、それ以前のバージョンでも使用できると思います。
　なお、CakePHP1.1では、一部アウトプット仕様が異なるため、使用できない機能が
ありますのでサポート外です。


--------------------------------------------------
■対象端末
--------------------------------------------------

　本ライブラリは、3G携帯およびiPhone、PHSを対象としています。それ以前の携帯で
利用できるものもありますが、基本的にサポート外です。
　特にJ-PHONE/Vodafone時代の端末、HDML対応のEZWebでは動作できないものが
あります。このため、公式サイトなど厳密な管理を行うようなサイトには向いて
おりませんのでご了承ください。


--------------------------------------------------
■ご利用条件
--------------------------------------------------

　本ツール一式は使用もしくは再配布について、無料でご利用いただけます。

　本ツールおよびアーカイブ内に含まれる全ての著作物に対する権利はECWorksが保有
しており、GNU一般公衆利用許諾契約に基づいて配布しております。再配布・改変等は
契約の範囲内で自由に行うことが出来ます。詳しくは、添付のGNU一般公衆利用許諾
契約書をお読みください。

　なお、本ツールは一般的な利用において動作を確認しておりますが、ご利用の環境や
状況、設定もしくはプログラム上の不具合等により期待と異なる動作をする場合が
考えられます。本ツールの利用に対する効果は無保証であり、あらゆる不利益や損害等に
ついて、当方は一切の責任をいたしかねますので、ご了承いただきますようお願い
申し上げます。


--------------------------------------------------
■必要ファイルとアップロード方法
--------------------------------------------------

　配布アーカイブを解凍すると、次のファイルが生成されます。生成ファイルを、
CakePHP内の所定の場所にアップロードしてください。

+- app								[755] 
|  +- config						[755] 
|  |  +- ktai_session.php			[644] 携帯向けセッション設定
|  +- controllers					[755] 
|  |  +- components					[755] 
|  |  |  +- ktai.php				[644] 携帯コンポーネント
|  +- views							[755] 
|  |  +- helpers					[755] 
|  |     +- ktai.php				[644] 携帯ヘルパー
|  +- webroot						[755] 
|  |  +- img						[755] 
|  |     +- emoticons				[755] 絵文字画像はここに設置します(後述)
|  |        +- empty				[***] (ダミー・アップロード不要です)
|  +- ktai_app_controller.php		[644] 携帯用app_controller.php(*)
|  +- app_error.php					[644] 携帯用app_error.php
+- vendors							[755] 
|  +- ecw							[755] 
|     +- session					[755] 
|     |  +- ktai_session_12.php		[644] CakePHP1.2用セッション設定
|     |  +- ktai_session_13.php		[644] CakePHP1.3用セッション設定
|     +- lib3gk.php					[644] 携帯ライブラリ本体
|     +- lib3gk_carrier.php			[644] 携帯ライブラリ本体(キャリア判定関連)
|     +- lib3gk_def.php				[644] 携帯ライブラリ本体(定義関連)
|     +- lib3gk_emoji.php			[644] 携帯ライブラリ本体(絵文字関連)
|     +- lib3gk_html.php			[644] 携帯ライブラリ本体(HTML関連)
|     +- lib3gk_ip.php				[644] 携帯ライブラリ本体(IPアドレス関連)
|     +- lib3gk_machine.php			[644] 携帯ライブラリ本体(機種情報関連)
|     +- lib3gk_tools.php			[644] 携帯ライブラリ本体(その他ツール関連)
|									↓↓↓以下はアップロード不要です
+- readme.txt						[***] このファイル
+- LICENSE							[***] GNUライセンス規約書

　なお、ライブラリ単体で利用する場合は、vendors/ecw内のライブラリファイルのみを
所定のディレクトリにアップロードしてください。その他のファイルは不要です。

(*)セッション関連を使用する場合は、app_controller.phpの代わりにこちらを利用
するか、既存app_controller.phpに必要箇所をペーストしてください


--------------------------------------------------
■設定
--------------------------------------------------

　携帯ライブラリでは、次の設定が必要になります。

【簡単な流れ】

[設定開始]
　　↓          No
CakePHPで使う？ --→ １：ライブラリ単体で用いる場合 ------------------+
　　｜Yes                                                             |
　　↓             Yes                                                |
セッションを使う？ --→ 2-a：セッションを使用する場合 -+              |
　　｜No                                               |              |
　　｜                      +--------------------------+              |
　　↓                      | Yes                                     |
ktaiコンポーネントを使う？ -+                                         |
 もしくは                   +-→ 2-b：ktaiコンポーネントを用いる場合 -+
自動変換処理を行う？       -+                                         |
　　｜No                                                              |
　　↓                                                                |
2-c：ktaiヘルパーのみを用いる場合                                     |
　　｜                                                                |
　　｜←--------------------------------------------------------------+
　　↓
[設定完了]


１：ライブラリ単体で用いる場合

　ライブラリ単体で用いる場合は、まずライブラリクラスのインスタンスを入手し、
その中の「_params」プロパティを変更します。_paramsプロパティは連想配列で
表現されています。

【設定例１：標準で利用する場合】

$ktai = Lib3gk::get_instance();
$ktai->_params = array(
		'use_img_emoji' => true, 					//画像絵文字を使用
		'input_encoding'  => KTAI_ENCODING_UTF8, 	//入力をUTF-8に変更
		'output_encoding' => KTAI_ENCODING_UTF8, 	//出力をUTF-8に変更
);

　バージョン0.3からは、ライブラリの機能をサブクラス化しました。このため、
特定機能のみを利用することが出来ます。例えばキャリア判定のみを利用する場合は
「Lib3gkCarrier」のインスタンスを入手することでキャリア判定が行えます。

【設定例２：特定機能のみを利用する場合】

$carrier = Lib3gkCarrier::get_instance();
$carrier->_params = array(
		'use_img_emoji' => true, 					//画像絵文字を使用
		'input_encoding'  => KTAI_ENCODING_UTF8, 	//入力をUTF-8に変更
		'output_encoding' => KTAI_ENCODING_UTF8, 	//出力をUTF-8に変更
);
$html = Lib3gkHtml::get_instance();		//別の機能も利用できます。
										//パラメータは引き継がれます

２：CakePHPで使用する場合

　CakePHPで用いる場合は、コンポーネントを利用する場合と、ヘルパー単体で利用
する場合とで、設定方法が異なります。
　また、携帯でセッションを用いたい場合は、セッション用の設定が必要になります。

2-a：セッションを使用する場合【大変に重要!!】

　CakePHPで携帯サイトを実現するにあたり、セッションを使うための設定が必要に
なります(携帯でセッション機能を使わない場合は省略することも出来ます)。
　なお、セッションを使用する場合は、Ktaiコンポーネントが必須となります。

2-a-1 : routes.phpへの記述

　namedパラメータのセパレータ文字を変更します。
　「app/config/routes.php」に、次の記述を「一番最初に」行ってください。
　セパレータ文字列は、無指定の場合は「:」となりますが、この文字の場合に
iMODEにてセッションIDが付加されなくなりますので必ず指定します。
　利用可能な文字は下記URLで確認してください(設定例では、比較的影響の少ない
ものと思われる「~」としています)。

【routes.phpの設定例】

	Router::connectNamed(array(), array('argSeparator' => '~'));
	
	//↓以下、Router::connect(～)を記述します


2-a-2：ktai_app_controller.phpの適用(もしくは編集)

　添付されているktai_app_controller.phpをappディレクトリにコピーして
「AppController」の代わりに「KtaiAppController」をextendsするようにします。
もしくは、ktai_app_controller.phpの内容をapp_controller.phpにコピーして使います。

　なおクラス定義の前に、次のように冒頭でktai_app_controller.phpを読み込む必要が
あります。

App::import('Controller', 'KtaiApp');	//ファイルは自動で読み込まれないため
										//別途行う必要がある
class FoosController extends KtaiAppController {
	//通常のクラス定義
}

2-a-3：パラメータの追加

　各コントローラもしくはktai_app_controler.php内に、セッション用のパラメータを
追加します。
　基本的にはデフォルトのままで動作するように出来ていますが、逆に動作させたくない
場合などで行います。

var $ktai = array(
	'enable_ktai_session' => true, 			//セッション使用を有効にします
	'use_redirect_session_id' => false, 	//リダイレクトに必ずセッションIDを
											//つけます
	'imode_session_name' => 'csid', 		//iMODE時のセッション名を変更します
);


2-b：ktaiコンポーネントを用いる場合(ヘルパーの使用は問わない)

　コンポーネントを用いる場合は、利用するコントローラ内に「ktai」プロパティを
作成します。
　また、絵文字や文字エンコーディングなどの自動変換を行いたい場合も
コンポーネントを導入する必要があります。

【設定例】

App::import('Controller', 'KtaiApp');
class HogeController extends KtaiAppController {
	
	var $components = array('Ktai');
	
	//省略
	
	var $ktai = array(
		'use_img_emoji' => true, 				//画像絵文字を使用
		'input_encoding'  => 'UTF-8', 			//入力をUTF-8に変更
		'output_encoding' => 'UTF-8', 			//出力をUTF-8に変更
		
		'output_convert_kana' => 'knrs', 		//かなの変換を行う
		'output_auto_convert_emoji' => true, 	//絵文字自動変換を行う
		
	
	//省略
}

　コントローラ中でライブラリを使う場合は、上記ktaiプロパティを変更します。
このプロパティは、ライブラリ内の設定値プロパティを参照しているため、設定は
即座にライブラリ内に反映します。
　なお、これら設定値は､ktaiヘルパー使用時はそのまま引き継がれます。

※現時点で、エンコーディング文字列を定義している定数は使用することは
　出来ません。

2-c：ktaiヘルパーのみを用いる場合

　ヘルパー「のみ」を用いる場合は、コントローラ内でConfigure::write()を用いて
設定値を受け渡します。
　基本的に何処に書いても、最終的にはrender()内でヘルパーが初期化されるため、
値は反映されます。beforeFilter内で記述するのが一般的ですが、コントローラ内の
アクション処理内でもOKです。

【設定例１：beforeFilter内で設定する場合】

App::import('Controller', 'KtaiApp');
class HogeController extends KtaiAppController {
	
	//省略
	
	function beforeFilter(){
		Configure::write('Ktai', array(
			'use_img_emoji'   => true, 					//画像絵文字を使用
			'input_encoding'  => KTAI_ENCODING_UTF8, 	//入力をUTF-8に変更
			'output_encoding' => KTAI_ENCDING_UTF8, 	//出力をUTF-8に変更
		));
	}
	
	//省略
}

【設定例２：アクション処理内で設定する場合】

App::import('Controller', 'KtaiApp');
class HogeController extends KtaiAppController {
	
	//省略
	
	function fuga(){
		
		//省略
		
		Configure::write('Ktai', array(
			'use_img_emoji'   => true, 					//画像絵文字を使用
			'input_encoding'  => KTAI_ENCODING_UTF8, 	//入力をUTF-8に変更
			'output_encoding' => KTAI_ENCDING_UTF8, 	//出力をUTF-8に変更
		));
		
		$this->render();								//renderまでに設定を
														//終えてください
	}
	
	//省略
}

　また、ビュー内では、ヘルパー内の設定プロパティを直接書き換えることで
設定値を変更することが出来ます。設定プロパティは、ライブラリ内の設定
プロパティを参照しておりますので、即座に値が反映されます。

【設定例３：ビューテンプレート内で設定をする場合】

<?php
$ktai->options['use_img_emoji']   = true;
$ktai->options['input_encoding']  = KTAI_ENCODING_UTF8, //入力をUTF-8に変更
$ktai->options['output_encoding'] = KTAI_ENCDING_UTF8, 	//出力をUTF-8に変更
?>
■今日のお天気<br>
東京都：<?php $ktai->emoji(0xe63e); ?><br>


◎設定値詳細

ライブラリ内の「_params」プロパティ、もしくはcontroller内の「ktai」
プロパティ、ヘルパーを利用する際の「Configure::write('Ktai', $params);」で設定
するparams連想配列で指定する、各種設定値については、次の通りです。
なお、記載されている設定値はデフォルトです。

【エンコーディング関連設定】

・入力エンコーディング(string)
	'input_encoding'  => KTAI_ENCODING_SJIS, 

　加工前のエンコーディングを指定します。

・出力エンコーディング(string)
	'output_encoding' => KTAI_ENCODING_SJIS, 

　加工後のエンコーディングを指定します。

・バイナリ絵文字を使用(bool)
	'use_binary_emoji' => true, 

　絵文字生成の際、バイナリ文字列を生成します。


【絵文字画像関連設定】

　画像絵文字を使用する場合の設定です。
　デフォルトはTypepad絵文字を標準的に使用する際の設定となっています。

・画像絵文字使用フラグ(bool)
	'use_img_emoji' => false, 

　機種によって割り当てのない絵文字について、画像絵文字を適用します。

・画像絵文字格納URL(string)
	'img_emoji_url' => './img/emoticons/', 

　画像絵文字の格納場所を指定します。この設定がimgタグのsrcに記載されます。

・画像絵文字拡張子(string)
	'img_emoji_ext' => 'gif', 

　画像絵文字の拡張子を指定します。

・画像絵文字の画像サイズ(array(int, int))
	'img_emoji_size' => array(16, 16), 

　画像絵文字の画像サイズを(width, height)で指定します。


【iPhone関連設定】

・iPhoneを携帯とみなす(bool)
	'iphone_user_agent_belongs_to_ktai'      => false, 

・iPhoneをSoftBank携帯とみなす(bool)
	'iphone_user_agent_belongs_to_softbank'  => false, 

・iPhoneメールを携帯メールとみなす(bool)
	'iphone_email_belongs_to_ktai_email'     => false, 

・iPhoneメールをSoftBank携帯のメールとみなす(bool)
	'iphone_email_belongs_to_softbank_email' => false, 


【Android関連設定】[New!]

・Androidを携帯とみなす(bool)
	'android_user_agent_belongs_to_ktai'      => false, 


【仮想スクリーンサイズ設定】

・仮想スクリーンサイズの設定(array(int, int))
	'default_screen_size' => array(240, 320), 

　仮想的なスクリーンサイズを(width, height)で指定します。
　画像ストレッチ機能(■ライブラリ関数リファレンス「◎スクリーンサイズに
最適化した画像を表示」を参照)で使用されます。


【文字コードコンバート関連】(コンポーネントのみ)

・アウトプットに対して絵文字の自動コンバートを行う(bool)
	'output_auto_convert_emoji' => false, 

　このフラグを指定すると、アウトプット内にある絵文字について検索を行い、
コンバートを自動で行います。
　なお、絵文字の自動変換に入力と出力の文字エンコーディング情報が必要です。必ず
「input_encoding」「output_encoding」も指定します。
　また、絵文字コンバートを行う場合、文字コードのコンバートも自動的に行います。


・アウトプットに対して文字コードの自動コンバートを行う(bool)
	'output_auto_encoding' => false, 

　このフラグを指定すると、入力文字コード指定と出力文字コード指定が異なる場合、
自動変換します。

・仮名変換(string)
	'output_convert_kana' => 'knr', 

　このオプションを指定すると、仮名文字変換(mb_convert_kana())を自動で行います。
　与える文字列はmb_convert_kana()で与えるオプションです。
　デフォルトはfalseとなっていて、変換処理は行いません。

※文字コンバート関連は、処理の性質上大変に処理能力を使いますのでお気をつけ
　ください

【XML関連】

・XMLの使用(bool)
	'use_xml' => false, 

　このオプションを指定すると、URL生成がXML表記になります。

【CSS関連】

・インラインスタイルシートの登録(array(string))
	'style' => array(
		'warning' => 'color: #ff0000;font-size: x-small;', 
	), 

　定義したいインラインCSSに名前をつけて管理することが出来ます。
　style((名前))で、その名前のスタイルを呼び出すことが出来ます。

【フォント関連】[New!]

・デフォルトのフォントサイズ(string)
	'default_font_size' => 'medium', 

　Lib3gkHtml::font()にてデフォルト(第一引数を無指定)で指定するフォントサイズを
記述します。「small」「medium」「large」から指定できます。デフォルトは
「medium」です。


--------------------------------------------------
■ヘルパーの利用方法
--------------------------------------------------

ヘルパーでライブラリーを使用するには、次の手順で行います。

１：ライブラリを所定の位置にコピーする(前述)
２：必要であれば、設定値をカスタマイズする
３：コントローラにヘルパーを登録する

	var $helper = array('Ktai', ...);

４：ビュー内に記述

<?php $ktai->emoji(63879); ?>←「[1]」を表示


--------------------------------------------------
■コンポーネントの利用方法
--------------------------------------------------

コンポーネントでライブラリーを使用するには、次の手順で行います。

１：ライブラリを所定の位置にコピーする(前述)
２：必要であれば、設定値をカスタマイズする
３：コントローラにコンポーネントを登録する

	var $components = array('Ktai', ...);

４：コントローラ内に記述

if($this->Ktai->is_ktai()){
	echo "携帯でアクセスしています<br>\n";
}

【備考】
　レンダリング結果に対して絵文字を全て変換したい場合は、コントローラ処理が
終わるまでに「$this->ktai['convert_output'] = true」を設定します。


--------------------------------------------------
■絵文字画像の使用
--------------------------------------------------

　本ライブラリは、TypePadで使用されている絵文字画像に対応しています。別途
ダウンロードしたものを設置し、設定することで、PCもしくは各キャリアで割り当ての
ない絵文字を絵文字画像で置き換えることが出来ます。

絵文字画像の使用は、次の手順で行います。

１：絵文字画像を次のURLから入手する

▼TypePadの絵文字アイコン画像と、携帯表示モジュールをフリー(自由)ライセンスで
　公開
http://start.typepad.jp/typecast/

２：入手したアーカイブを解凍し、emoiconフォルダをapp/webroot/img/にコピーする
３：コンポーネント・ヘルパー内の絵文字画像のオプションを設定する。

$this->ktai['use_img_emoji']    = true;		(コントローラ内処理で設定する場合)
$ktai->options['use_img_emoji'] = true;		(ビュー内処理で設定する場合)

※初期設定方法は「■設定」項目をご覧ください

なお、サイトで絵文字画像を使用する場合は、画像についての利用規約に従って
ご利用いただきますようお願いいたします。


--------------------------------------------------
■ライブラリ関数リファレンス
--------------------------------------------------

◎ライブラリのバージョンを入手

string get_version()

　ライブラリのバージョンコード(文字列)を入手します。


◎キャリアの判別

bool is_imode()		iMODE携帯の判別
bool is_softbank()	ソフトバンク携帯の判別
bool is_vodafone()	ボーダフォン携帯の判別
bool is_jphone()	JPHONE携帯の判別
bool is_ezweb()		EZWeb携帯の判別
bool is_emobile()	EMOBILE携帯の判別
bool is_iphone()	iPhoneの判別
bool is_android()	Androidの判別[New!]

　各携帯端末を判別し、そうであったらtrueを返します。
　is_vodafone()はJ-PHONEも、is_softbank()はvodafoneとJ-PHONEも含みます
(通常はis_softbank()を使います)。


◎携帯の判別

bool is_ktai()

　携帯端末でアクセスしている場合、trueを返します。
　設定により、iPhone端末も携帯として判別することが出来ます。


◎PHSの判別

bool is_phs()

　PHS端末でアクセスしている場合、trueを返します。


◎キャリアコードを入手

int get_carrier()

　現在のアクセス端末の判別を、数値で入手します。
　定数として、次の数値が割り当てられています。

KTAI_CARRIER_UNKNOWN	(不明)
KTAI_CARRIER_DOCOMO		iMODE
KTAI_CARRIER_KDDI		EZWeb
KTAI_CARRIER_SOFTBANK	Softbank
KTAI_CARRIER_EMOBILE	EMOBILE
KTAI_CARRIER_IPHONE		iPhone
KTAI_CARRIER_PHS		PHS
KTAI_CARRIER_ANDROID	Android[New!]


◎ユーザーエージェントの解析

array analyze_user_agent(string $user_agent = null)

　ユーザーエージェントを解析し、端末情報を入手します。
　引数が指定されていない場合は現在のユーザエージェントを入手して解析します。
　配列で渡される値は次の通りです。

array(
	'carrier' => 0, 				//キャリアコード(int)
	'carrier_name' = 'default', 	//キャリア名(string)
	'machine_name' => 'default', 	//端末名(string)
)

なお、PCなど端末が特定できなかった場合はデフォルトの値が入ります。


◎端末情報の入手

array get_machineinfo(string $carrier_name = null, string $machine_name = null)

　端末情報をライブラリから入手します。
　キャリア名と端末名を省略した場合は、現在のユーザーエージェントからこれらを
入手し、端末情報を入手します。
　端末情報が存在しない場合は一般的な端末の情報が返されます。
　配列で渡される値は次の通りです。

array(
	'carrier'							//キャリアコード(int)
	'carrier_name'						//キャリア名(string)
	'machine_name'						//端末名(string)
	'text_size'   => array(20, 11), 	//文字数(width, height / 半角 / int)
	'screen_size' => array(240, 320), 	//スクリーンサイズ(width, height / int)
	'image_size'  => array(240, 320), 	//画像サイズ(壁紙など)
										//(width, height / int)
	'pic_format'  => array('gif' => true, 'jpg' => true, 'png' => true, ), 
										//対応画像フォーマット(bool)
)


◎メールアドレスの判別

bool is_imode_email(string $email)		iMODEメールの判別
bool is_softbank_email(string $email)	ソフトバンクメールの判別
bool is_vodafone_email(string $email)	ボーダフォンメールの判別
bool is_jphone_email(string $email)		JPHONEメールの判別
bool is_ezweb_email(string $email)		EZWebメールの判別
bool is_emobile_email(string $email)	EMOBILEメールの判別
bool is_iphone_email(string $email)		iPhoneメールの判別

　各携帯メールアドレスを判別し、そうであったらtrueを返します。
　is_vodafone_email()はJ-PHONEも、is_softbank_email()はvodafoneとJ-PHONEも
含みます(通常はis_softbank_email()を使います)。


◎携帯メールの判別

bool is_ktai_email(string $email)

　携帯メールアドレスの場合、trueを返します。
　設定により、iPhone端末も携帯として判別することが出来ます。


◎PHSメールの判別

bool is_phs_email(string $email)

　PHSメールアドレスの場合、trueを返します。


◎iMODE絵文字を他キャリア用に変換する [Update!]

void convert_emoji(string &$str, int $carrier = null, $input_encoding = null, 
	$output_encoding = null, $binary = null)

　$str内を各キャリアに対応した絵文字で変換します。
　$str内で定義されている絵文字は、iMODE用である必要があります。それ以外の
絵文字は変換されません。
　各キャリア対応絵文字で、iMODE絵文字に相当するものがない場合、テキスト文字
または絵文字画像で変換されます。
　input_encodingで入力文字コード、output_encodingで出力文字コードを指定
できます。無指定の場合は、ライブラリクラスインスタンスの設定値が利用されます。
　binaryをtrueにすると絵文字はバイナリ文字列として出力されます。falseにすると
数値指定(&#?????; / &#x????;)を出力します。

　バージョン0.3からは、文字のエンコーディングも同時に行うようになりました。


◎絵文字を表示する

string emoji(mixed $code, bool $disp = true, int $carrier = null, 
	$output_encoding = null, $binary = null)

　指定した絵文字を入手します。
　$codeは、iMODE文字の他、文字コードを数値として入力することができます。
　$dispを省略すると、ビューに直接表示を行います(echoが不要です)。
　$carrierにキャリアコードを指定すると、そのキャリアに対応した絵文字を入手する
ことが出来ます。省略すると現在アクセスしている端末の絵文字が出力されます。
　output_encodingで出力文字コードを指定できます。無指定の場合は、
ライブラリクラスインスタンスの設定値が利用されます。
　binaryをtrueにすると絵文字はバイナリ文字列として出力されます。falseにすると
数値指定(&#?????; / &#x????;)を出力します。

※バージョン0.0.1をお使いの方へ
　バージョンアップに伴い、引数の配置が若干異なっています。ライブラリ置き換えの
　際にはご注意ください。


◎スクリーンサイズに最適化した画像を表示 

string image(string $url, array $htmlAttribute = array(), $stretch = true)

　仮想スクリーンサイズと端末スクリーンサイズから画像の拡大率を計算し、その比率に
修正した画像を表示します。この関数を使用することで、高解像度携帯での画像の
レイアウト崩れを補正することが出来ます。
　CakePHPのHtmlHelper準拠の引数となっており、imgタグのアトリビュートを
htmlAttribute内に連想配列で指定します。
　なお、最適化については、画像の幅と高さ(width, height)が必ず指定されて
いなければなりません。どちらかが欠けた場合、最適化は行いません。
　なお、最適化を行いたくない場合はHtmlHelper::image()に置き換えてください。

　バージョン0.3からは、画像のストレッチをするかしないか選べます。デフォルトは
ストレッチを行います。

◎スクリーンサイズに最適化した画像サイズを入手

array stretch_image_size(int $width, int $height, 	int $default_width = null, 
	int $default_height = null)

　仮想スクリーンサイズと端末スクリーンサイズから画像の拡大率を計算し、その比率に
修正した画像サイズを入手します。戻り値の配列は、width, heightの順です。


◎アクセスキー付きlinkの出力(ヘルパーのみ)

string link(string $title, mixed $url = null, mixed $htmlAttributes = array(), 
	bool $confirmMessage = false, bool $escapeTitle = true)

　アクセスキー付きのリンクを作成します。
　htmlAttributesに「'accesskey'」パラメータが含まれている場合、リンク文字列の
前に番号絵文字iconを出力します。
　それ以外のパラメータなどは、$html->link()と同じです。


◎mailtoリンクの作成

string mailto(string $title, string $email, string $subject = null, 
	string $body = null, bool $input_encoding = null, 
	$output_encoding = null, $display = true)

　各端末に合わせたmailtoリンクを作成します。
　件名や本文を、文字化けすることなく挿入することが出来ます。
　自動的にアウトプットしたくない場合はdisplayをfalseにします。


◎リダイレクト

void redirect(string $url, bool $exit = true)

　リダイレクト処理を実現します。
　enable_ktai_sessionが有効であり、use_redirect_session_idが有効か、もしくは
iMODE端末からのアクセスだった場合は、セッションIDがURLに付加されます。

※lib3gk固有の機能を持つ関数です。CakePHPでは、app_controller.phpを設定し、
　コントローラ内のredirect()を用いてください


◎ユーザIDの入手

mixed get_uid()

　携帯に付加されているユーザID(uid)を入手します。
　uidが入手出来た場合はそのコードがstringで返ります。
　入手出来なかった場合はfalseが返ります。


◎インラインスタイルシートの入手

string style(string $name)

　あらかじめ登録した名前のスタイルシートを呼び出します。
　スタイルの登録方法は「設定：設定値詳細」項目内の「インラインスタイルシートの
登録」欄をご覧ください。

※lib3gkおよびヘルパーにて利用可能な関数です。


◎フォントサイズの均一化が可能なフォントタグの生成[New!]

string font(string $size = null, string $tag = null, string $style = null, 
	boolean $display = true)

　異なるキャリアでも同じフォントサイズになるようなfontタグを出力します。
docomoはdivタグ、それ以外はfontタグで出力します。
　$sizeでフォントサイズを指定します。同じ大きさに補正するサイズは「small」
「medium」「large」です。それ以外のサイズを指定した場合はその値がそのまま指定
されます。
　$tagでタグの種類を変更する事ができます。「div」「span」「font」等を指定
します。
　$styleはstyle()で指定するスタイル名を指定します。フォント指定の際に指定
スタイルを埋め込みます。
　$displayは処理終了の際にechoします。デフォルトはtrue(echoする)です。

　なお、この機能は「use_xml」がtrueの場合(XHTMLの場合)にのみ実行します。

※lib3gkおよびヘルパーにて利用可能な関数です。


◎フォント終了タグの生成[New!]

string fontend(boolean $display = true)

　上記font()メソッドで出力したフォントタグに対する閉じタグを生成します。
本メソッドを実行すると、直近に実行したfont()メソッドに対応するタグが出力
されます。それ以降は後入れ先出しで出力します。
　$displayは処理終了の際にechoします。デフォルトはtrue(echoする)です。

※lib3gkおよびヘルパーにて利用可能な関数です。


★以下は、直接携帯に関係ないけどお役立ち関数です

◎エンコーディング文字列を正規化

string normal_encoding_str(string $str)

　エンコーディング文字列をPHP内部で利用している標準的な文字列で正規化します。
　例えば、「sjis」, 「Shift_JIS」は全て「SJIS」と変換されます


◎数値から文字列を作成

string int2str(int $value)

　数値(キャラクターコード)を文字列に変換します。
　マルチバイトに対応しています。

◎数値(ユニコード)からUTF-8文字列を作成

string int2utf8(int $value)

　ユニコードをUTF-8文字列に変換します。

◎文字から数値を作成 [New!]

string str2int(int $str)

　文字から数値(キャラクターコード)に変換します。
　マルチバイトに対応しています。

◎UTF-8文字から数値(ユニコード)を作成 [New!]

string utf82int(int $value)

　UTF-8文字から数値(ユニコード)に変換します。

◎QRコードの作成

string get_qrcode(string $str, array $options = array(), 
	string $input_encoding = null, string $output_encoding = null)

　Google chart APIを用いて、携帯サイト誘導手段として一般的なQRコードを作成
します。
　$optionsは、連想配列で次のオプションを指定できます。
　各オプション値の詳細は、Google Chart APIデベロッパーガイドを参照してください。

▼Google Chart API：デベロッパー ガイド(QRコード)
http://code.google.com/intl/ja/apis/chart/#qrcodes

$options = array(
	'width' => 220, 		//QRコード画像の幅(マージンを含んでいます)
	'height' => 220, 		//QRコード画像の高さ(同上)
//	'margin' => 4, 			//マージン(無彩色)幅
//	'ec' => '-L', 			//エラー訂正レベル
);

　これ以外のキーを持つ値は、image()のオプションとして持ち越されます。
　デフォルト値は、縦横220pixelとなっています。
　戻り値はイメージタグの文字列となります。


◎Google static Maps APIを用いて地図の表示 [New!]

string get_static_maps(string $lat, string $lon, array $options = array(), 
	string $api_key = null)

　Google static Maps APIを用いて地図のHTML文字列を入手します。
　$optionsは、連想配列でオプションを指定できます。
　各オプション値の詳細は、Google static Maps APIデベロッパーガイドを参照して
ください。
　$api_keyは、省略した場合は$this->_params['google_api_key']の値を参照します。

▼Google static Maps APIデベロッパーガイド
http://code.google.com/intl/ja/apis/maps/documentation/staticmaps/


--------------------------------------------------
■今後のKtai Libraryについて
--------------------------------------------------

　現時点で、次の機能を搭載検討しております。

・メールデータからメールアドレスや件名・本文を抜き出す(空メール向け)
・ファイルダウンロード対応(着メロ・アプリ…etc)
・デバッグ情報(ページサイズ表示など？)

　他に欲しい機能がございましたら、是非お寄せください。検討させていただきます。


--------------------------------------------------
■スペシャルサンクス
--------------------------------------------------

　バージョン0.1.0の開発に当たり、kenji0302様から「get_uid()」に関するソース
コード提供をいただきました。ありがとうございました。

▼渋谷でサボるエンジニアの日記
http://blog.firstlife.jp/

　バージョン0.0.2の開発に当たり、あつ様のご協力を得ました。ありがとうござい
ました。

▼WEBで地域活性化
http://as.blog16.jp/

　バージョン0.3.0の開発に当たり、TAKA様の公開されている「Google Static Maps 
APIヘルパー」を参考に「get_static_maps()」を作成しました。ご協力ありがとう
ございました。

▼忘れないログ(cakePHP1.2など)
http://andweb.jp/blog/


--------------------------------------------------
■ご意見・ご感想・不具合報告など
--------------------------------------------------

　「Ktai Library.org」を立ち上げました。バグ情報やKtai Libraryに関する
ニュースをこちらにて公開しています。バグ報告やご要望などはこちらにて受け付けて
おります。

▼Ktai Library.org
http://www.ktailibrary.org/

　また、TwitterにてKtai Libraryのアカウント(@ktailibrary)を取得しました。
「http://www.ktailibrary.org/」の更新情報の他、Ktai Libraryに関する情報を
つぶやいています。

　ご意見、ご感想などは、当方のブログ内「お問い合わせ」フォームにてご連絡
いただけますと幸いです。

▼ECWorks
http://www.ecworks.jp/

▼ECWorks blog
http://blog.ecworks.jp/

▼携帯ライブラリサポートページ
http://blog.ecworks.jp/ktai

【CM】
　テンプレートファイルを容易に作成・配置するためのツール「Tplcutter」も
公開しています。特にDreamweaver等のサイトデザインツールを利用しての制作に
大変便利です。こちらも是非ご利用ください！


--------------------------------------------------
■バージョン情報
--------------------------------------------------

【Ver0.4.1】2011.2.11
　・app/vendorsにもecwディレクトリを置けるように修正
　・$ktaiプロパティなどにuse_xmlをセットしていないとワーニングが出る問題を修正
　・emoji()で出力した絵文字がoutput_auto_convert_emojiオプション指定時に消えて
　　しまう不具合を対処
　・Lib3gkCarrier::is_android()のラッパーメソッドをコンポーネント・ヘルパー
　　などに追加
　・KDDIとemobileで出たの存在しない機種でLib3gkCarrier::analyze_user_agent()
　　するとワーニングが出る問題を修正


【Ver0.4.0】2010.11.30
　・ktai_app_controller.phpの場所をapp直下に移動
　・「use_xml」がtrueの場合、beforeRender()時にXHTMLのContent-typeを出力する
　　ように修正
　・文字の大きさを機種毎に合わせる機能を追加
　・Android端末の判定ができるようになりました
　・KtaiHelper::link()でキャリア・出力エンコーディング・バイナリのオプション
　　指定を追加
　・機種情報・IPアドレス情報を追加修正
　・Lib3gkIpのIPアドレステーブル中にスペースが混じっているデータがあるのを修正
　・Lib3gk::get_ip_carrier()の内部で存在しないメソッドをコールしている不具合を
　　修正
　・softbank jphoneの端末ID取得時にエラーが出る不具合を修正
　・本ドキュメントにKtaiAppControllerの使用方法について明記されていないため追加

【Ver0.3.2】2010.05.17
・0.3.1の修正でlayout内について自動変換処理がされない問題を修正
　(これにより自動変換処理にktaiコンポーネント導入が必須になる)
・ktaiヘルパー本体とテストケースにvar_dumpがあったため除去

【Ver0.3.1】2010.05.17
　・session_use_trans_sid()を実行するための論理が逆になっているのを修正
　・afterLayout()にある変換処理系をafterRender()に移動
　・AUの絵文字情報が間違っている箇所を修正
　・Lib3gkHtml::get_static_maps()がLib3gkやktaiヘルパーに実装
　・Lib3gkEmoji内にあるLib3gkインスタンスを削除してLib3gkHtmlインスタンスを追加
　・絵文字キャッシュ
　・各プロパティ・メソッドのコメント欄を整備

【Ver0.3.0】2010.04.27
　・サブクラス化(lib3gk_carrier/lib3gk_def/lib3gk_html/lib3gk_ip/lib3gk_tools)
　・IPキャリア判定機能の追加
　・image()の仕様変更(画像をストレッチしないフラグを引数に追加)
　・convert_emoji()の仕様変更(文字もエンコーディングする)
　・絵文字変換の仕組みをリファクタリング
　・get_static_maps()の追加
　・str2int()/utf82int()の追加

【Ver0.2.3】2010.03.21
　・app_controller.php.ktai内のリダイレクト処理の不具合を修正

【Ver0.2.2】2010.03.21
　・SoftBank携帯の新機種によるアクセスで不具合が生じる件を修正
　・新機種情報の追加
　・app_controller.php.ktai内のリダイレクト処理を改良
　・セッションが切断された際にsession_use_trans_sid()が二重で定義される不具合を
　　修正

【Ver0.2.1】2009.12.23
　・ktai_session.php内のsession.use_trans_sid関連の設定方法を変更

【Ver0.2.0】2009.10.01
　・インラインCSSを支援する機能を追加
　・一部絵文字テーブルにあった不都合を修正
　・session.use_trans_sidが変更できない不具合を修正
　・リダイレクトURLが不正になる不具合を修正
　・docomoの場合にセッションが正しく開始されない不具合を修正
　・絵文字テーブルと端末情報テーブルを「lib3gk.php」から分離
　・AUで数値指定の絵文字(&#x????)が正しく表示できない不具合を修正
　・アクセスキー付きリンクで、必ず数値指定絵文字になってしまう不具合を修正
　・CakePHPの場合のURL生成で、Router::url()を使用するように改良
　・URLをhtmlspecialchars()を通すように改良。
　・URL処理をコールバックにより付け替え出来るように改良。
　・出力するタグをXML形式にするオプションを追加(デフォルトは無効)
　・KTAI_ENCODING_SJISWIN定数(SJIS-win)を追加

【Ver0.1.1】2009.05.19
　・「session_save」オプションを廃止
　・DoCoMo携帯で、core.php内でConfigure::write('Session.save', 'php');以外だった
　　場合にセッションが有効にならない不具合を修正
　・一部絵文字の不備を修正
　・上書きを防止対策として「app_controller.php」のファイル名を
　　「app_controller.php.ktai」に変更

【Ver0.1.0】2009.05.11
　・セッション対応
　・セッション時のリダイレクト対応
　・QRコードの生成
　・携帯からuidを入手
　・自動変換処理関連でかな変換オプションを追加

【Ver0.0.2】2009.04.13
　・UTF-8エンコーディング対応
　・SJIS/UTF-8以外のエンコーディングからの変換
　・PHS対応(部分的に)
　・端末情報出力の強化
　・mailtoリンクの生成機能追加
　・高解像度画面サイズに合わせた画像のストレッチ機能追加
　・コンポーネント・ヘルパー内のパラメータをライブラリ内のものと共通化
　・コントローラからコンポーネント・ヘルパー内へのパラメータ送出手段を追加
　・自動コンバート機能をコンポーネントからヘルパーに移動

【Ver0.0.1】2009.03.12
　公開バージョン


**************************************************
　　ECWorks(H.N MASA-P)
　　http://www.ecworks.jp/
**************************************************
