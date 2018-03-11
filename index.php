<?php

// 都市名と差分時刻を入力する
$inputArray = inputCity();

// 基準となる都市名と日時を入力する
$inputBaseTime = inputBaseTime($inputArray);

// 都市毎に日時を計算
$outputArray = setTime($inputArray,$inputBaseTime);

// 画面に出力する
outputCityTimes($outputArray);


// 都市名、差分時刻入力関数
function inputCity(){
	// 入力値格納用配列
	$inputArray = array();

	// 標準入力から値を受け取る
	$inputLines = trim(fgets(STDIN));

	// 入力値が１～１００かチェック
	if(1 <= $inputLines && $inputLines <= 100){
		for ( $i = 0; $i < $inputLines; $i++) {
			$s = trim(fgets(STDIN));
			$s = str_replace(array("\r\n","\r","\n"), '', $s);
			$s = explode(" ", $s);
			
			$unmatchFlg_s0 = preg_match('/[^a-z]/',$s[0]);
			
			// 入力値チェック
			if(!isset($s[1])){
				// 差分時刻が入力されていない場合
				errorMsg();
			} else if($unmatchFlg_s0 || !(1 <= strlen($s[0]) && strlen($s[0]) <= 20) ){
				errorMsg();
			} else if((!intval($s[1]) && $s[1] !== '0') || !(-12 <= $s[1] && $s[1] <= 14)){
				errorMsg();
			}
			
			array_push($inputArray,$s);
		}
	} else {
		errorMsg();
	}
	
	return $inputArray;
}


// 基準日時入力関数
function inputBaseTime($inputArray){
	
	$returnTime = '';
	
	// 基準となる日時を入力から受け取る
	$baseTime = trim(fgets(STDIN));
	$baseTime = str_replace(array("\r\n","\r","\n"), '', $baseTime);
	$baseTime = explode(" ", $baseTime);
	
	// 入力値チェック
	if(!isset($baseTime[1])){
		// 基準日時が入力されていない場合
		errorMsg();
	}
	
	// 基準日時が hh:mm 形式かチェック
	if(!checkBaseTime($baseTime[1])){
		errorMsg();
	}
	
	// 都市名存在チェック用フラグ
	$existFlg = '0';
	
	// 都市名が存在するかチェック
	foreach($inputArray as $inputLine){
		if($inputLine[0] === $baseTime[0] && $existFlg === '0'){
			$existFlg = '1';
			
			// 存在した場合、基準日時を計算する
			if(0 <= $inputLine[1] ){
				$returnTime = date('H:i',strtotime($baseTime[1].'-'.$inputLine[1].' hour'));
			} else {
				$returnTime = date('H:i',strtotime($baseTime[1].'+'.substr($inputLine[1],1).' hour'));
			}
		} else if($inputLine[0] === $baseTime[0] && $existFlg === '1'){
			errorMsg();
		}
	}
	
	if($existFlg === '0'){
		errorMsg();
	}
	
	return $returnTime;
}


// 各都市毎の対応日時を求める
function setTime($inputArray,$inputBaseTime){
	$returnArray = array();
	
	$i = 0;
	foreach($inputArray as $inputCity){
		$returnArray[$i][0] = $inputCity[0];
		
		// 日時を計算する
		if(0 <= $inputCity[1] ){
			$returnArray[$i][1] = date('H:i',strtotime($inputBaseTime.'+'.$inputCity[1].' hour'));
		} else {
			$returnArray[$i][1] = date('H:i',strtotime($inputBaseTime.$inputCity[1].' hour'));
		}
		
		$i++;
	}
	
	return $returnArray;
}


// 引数の値が hh:mm 形式かチェックする
function checkBaseTime($baseTime){
	
	$returnFlg = '0';
	
	if(strlen($baseTime) === 5){
		$checkStr1 = substr($baseTime,0,2);
		$checkStr2 = substr($baseTime,2,1);
		$checkStr3 = substr($baseTime,3,2);
		
		if(
			0 <= $checkStr1 && $checkStr1 <= 23 && ctype_digit($checkStr1) &&
			$checkStr2 === ':' &&
			0 <= $checkStr3 && $checkStr3 <= 59 && ctype_digit($checkStr3)
		){
			$returnFlg = '1';
		}
	}
	
	return $returnFlg;
}


// 各都市の都市名と時間を出力する
function outputCityTimes($outputArray){
	
	echo "\n";
	
	foreach($outputArray as $outputCity){
		echo $outputCity[0]." ".$outputCity[1]."\n";
	}

}


// エラーメッセージ出力を出力し、処理を終了する関数
function errorMsg(){
	echo "\n不正な値が入力されました\n";
	exit;
}

?>