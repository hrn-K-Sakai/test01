<?php

// xy の入力
$inputXY = inputXY();

// k の入力
$inputK = inputK();

// N の入力
$inputN = inputN($inputK[0]);

// x_N,y_N,p_N の入力
$inputXYP = inputXYP($inputN[0]);

// 距離を算出
$calcArray = calcDist($inputXY,$inputXYP);

// 平均値を算出
$calcAvg = calcAvg($calcArray,$inputK[0]);

echo $calcAvg;

echo "\n";

// XY の入力
function inputXY(){
	// 入力値格納用配列
	$inputArray = array();
	$inputCount = 2;
	$startNum = 0;
	$endNum = 1000;
	
	// 標準入力から値を受け取る
	$inputLines = trim(fgets(STDIN));
	$inputArray = explode(" ",$inputLines);
	
	// 入力値のチェック
	if(count($inputArray) === $inputCount){
		foreach($inputArray as $inputValue){
			// 入力値をチェック
			chkValue($inputValue,$startNum,$endNum);
		}
	} else {
		errorMsg();
	}
	return $inputArray;
}

// K の入力
function inputK(){
	// 入力値格納用配列
	$inputArray = array();
	$inputCount = 1;
	$startNum = 1;
	$endNum = 100;
	
	// 標準入力から値を受け取る
	$inputLines = trim(fgets(STDIN));
	$inputArray = explode(" ",$inputLines);
	
	// 入力値のチェック
	if(count($inputArray) === $inputCount){
		foreach($inputArray as $inputValue){
			// 入力値をチェック
			chkValue($inputValue,$startNum,$endNum);
		}
	} else {
		errorMsg();
	}
	return $inputArray;
}

// N の入力
function inputN($inputK){
	// 入力値格納用配列
	$inputArray = array();
	$inputCount = 1;
	$startNum = 2;
	$endNum = 100;
	
	// 標準入力から値を受け取る
	$inputLines = trim(fgets(STDIN));
	$inputArray = explode(" ",$inputLines);
	
	// 入力値のチェック
	if(count($inputArray) === $inputCount){
		foreach($inputArray as $inputValue){
			// 入力値をチェック
			chkValue($inputValue,$startNum,$endNum);
			// k ≦ N のチェック
			chkKN($inputK,$inputValue);
		}
	} else {
		errorMsg();
	}
	return $inputArray;
}

// XYP の入力
function inputXYP($inputN){
	// 入力値格納用配列
	$inputArray = array();
	$inputCount = 3;
	$startNum = [0,0,1];
	$endNum = [1000,1000,100];
	$returnArray = array();
	
	for($i = 0; $i < $inputN; $i++){
		// 標準入力から値を受け取る
		$inputLines = trim(fgets(STDIN));
		$inputArray = explode(" ",$inputLines);
		
		// 入力値のチェック
		if(count($inputArray) === $inputCount){
			for($j = 0; $j < $inputCount; $j++){
				// 入力値をチェック
				chkValue($inputArray[$j],$startNum[$j],$endNum[$j]);
			}
		} else {
			errorMsg();
		}
		
		array_push($returnArray,$inputArray);
	}
	return $returnArray;
}

// 距離の算出
function calcDist($inputXY,$inputXYP){
	
	$returnArray = array();
	
	foreach($inputXYP as $key => $inputLines){
		$dist = sqrt(pow($inputXY[0]-$inputLines[0],2)+pow($inputXY[1]-$inputLines[1],2));
		$returnArray[$key]['dist'] = $dist;
		$returnArray[$key]['price'] = $inputLines[2];
	}
	
	return $returnArray;
}

// 平均値を算出
function calcAvg($calcArray,$inputK){
	
	// ソート用
	$keyDist = array();
	$copyArray = $calcArray;
	$price = 0;
	
	foreach($copyArray as $key => $value){
		$keyDist[$key] = $value['dist'];
	}
	array_multisort($keyDist, SORT_ASC, $copyArray);
	
	for($i = 0; $i < $inputK; $i++){
		$price += $copyArray[$i]['price'];
	}
	
	return $price / $inputK;
}

// 入力値チェック（K≦N）
function chkKN($inputK,$inputN){
	// 入力値が指定範囲内かチェック
	if(!($inputK <= $inputN)){
		errorMsg();
	}
}

// 入力値チェック（数値）
function chkValue($inputValue,$checkStart,$checkEnd){
	// 入力値が指定範囲内かチェック
	if(!ctype_digit($inputValue) || !($checkStart <= $inputValue && $inputValue <= $checkEnd)){
		errorMsg();
	}
}

// エラーメッセージ出力を出力し、処理を終了する関数
function errorMsg(){
	echo "\n不正な値が入力されました\n";
	exit;
}

?>