<?php

// 一行目文字列の入力とチェック
$inputStrArray = inputStr();

// 入力値を５進数に変換
$input5sinNumArray = set5sinNum($inputStrArray);

// ５進数配列の合計値を求める
$sum5sinNum = setTotalParam($input5sinNumArray,5);

// ５進数をABC表記へ変換して出力
outPrint($sum5sinNum);

echo "\n";

// 一行目文字列の入力とチェック
function inputStr(){
	// 入力値格納用配列
	$inputArray = array();
	$inputCount = 2;
	
	// 標準入力から値を受け取る
	$inputLines = trim(fgets(STDIN));
	$inputArray = explode(" ",$inputLines);
	
	// 入力値のチェック
	if(count($inputArray) === $inputCount){
		foreach($inputArray as $inputValue){
			// 入力値の長さをチェック
			chkStrLen($inputValue);
			
			// 入力値の文字をチェック
			chkStrMatch($inputValue);
		}
	} else {
		errorMsg();
	}
	
	return $inputArray;
}

// 入力値の長さをチェック
function chkStrLen($inputValue){
	$inputStrLen = strlen($inputValue);
	$minLen = 1;
	$maxLen = 10;
	
	// 入力値の長さが1～10かチェック
	if(!($minLen <= $inputStrLen && $inputStrLen <= $maxLen)){
		errorMsg();
	}
	
}

// 入力値の文字をチェック
function chkStrMatch($inputValue){
	$matchStr = "/^[ABCDE]*$/";
	$matchFirstStr = "/^A\S+$/";
	
	// 入力値が文字列[A-E]かチェック
	if(!(preg_match($matchStr,$inputValue))){
		errorMsg();
	}
	
	// 入力値先頭が"A"である場合、後続文字列が存在するかチェック
	if(preg_match($matchFirstStr,$inputValue)){
		errorMsg();
	}
}

// 入力値を５進数に変換
function set5sinNum($inputStrArray){
	$input5sinNumArray = array();
	$str5sin = "";
	$case0 = "A";
	$case1 = "B";
	$case2 = "C";
	$case3 = "D";
	$case4 = "E";
	
	// 一文字ずつ判定して文字列結合
	foreach($inputStrArray as $inputStr){
		$str5sin = "";
		foreach(str_split($inputStr) as $value){
			switch($value){
				case $case0:
					$str5sin .= "0";
					break;
				case $case1:
					$str5sin .= "1";
					break;
				case $case2:
					$str5sin .= "2";
					break;
				case $case3:
					$str5sin .= "3";
					break;
				case $case4:
					$str5sin .= "4";
					break;
			}
		}
		array_push($input5sinNumArray,$str5sin);
	}
	
	return $input5sinNumArray;
}

// パラメータを加算して返却
function setTotalParam($input5sinNumArray,$convertNum){
	$sum5sinNum = 0;
	
	// 一度１０進数に変換して加算する
	foreach($input5sinNumArray as $input5sinNum){
		$sum5sinNum += base_convert($input5sinNum,$convertNum,10);
	}
	
	// パラメータで渡された基数に再変換して返却
	return base_convert($sum5sinNum,10,$convertNum);
}

// ５進数を表記変換して出力
function outPrint($sum5sinNum){
	$input5sinStrArray = array();
	$str5sin = "";
	$caseA = "0";
	$caseB = "1";
	$caseC = "2";
	$caseD = "3";
	$caseE = "4";
	
	// 一文字ずつ判定して文字列結合
	foreach(str_split($sum5sinNum) as $value){
		switch($value){
			case $caseA:
				$str5sin .= "A";
				break;
			case $caseB:
				$str5sin .= "B";
				break;
			case $caseC:
				$str5sin .= "C";
				break;
			case $caseD:
				$str5sin .= "D";
				break;
			case $caseE:
				$str5sin .= "E";
				break;
		}
	}
	
	echo $str5sin;
}

// エラーメッセージ出力を出力し、処理を終了する関数
function errorMsg(){
	echo "\n不正な値が入力されました\n";
	exit;
}

?>