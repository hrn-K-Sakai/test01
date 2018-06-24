<?php

// 一行目abcの入力とチェック
$inputNeedTimeArray = inputNeedTime();

// 電車の本数と発車時刻の入力とチェック
$inputTrainTimeArray = inputTrainTime();

// 最遅出発電車時刻を求める
$latestTrainTime = setTrainDeparture($inputNeedTimeArray[1],$inputNeedTimeArray[2],$inputTrainTimeArray);

// 家の適正出発時刻を求める
$leaveHouseTime = setLeaveHouseTime($inputNeedTimeArray[0],$latestTrainTime);

// 出発時刻を出力
echo sprintf('%02d',$leaveHouseTime[0]).':'.sprintf('%02d',$leaveHouseTime[1]);
echo "\n";

// 一行目abcの入力とチェック
function inputNeedTime(){
	// 入力値格納用配列
	$inputArray = array();

	// 標準入力から値を受け取る
	$inputLines = trim(fgets(STDIN));
    $inputArray = explode(" ",$inputLines);
	
	// 入力値をチェック
	if(count($inputArray) === 3){
	    foreach($inputArray as $inputValue){
        	// 入力値が1～30かチェック
        	if(!(1 <= $inputLines && $inputLines <= 30)){
        		errorMsg();
        	}
    	}
	} else {
	    errorMsg();
	}

	
	return $inputArray;
}

// 電車の本数と発車時刻の入力とチェック
function inputTrainTime(){
	// 入力値格納用配列
	$inputArray = array();

	// 標準入力から値を受け取る
	$inputLines = trim(fgets(STDIN));

	// 入力値が1～180かチェック
	if(1 <= $inputLines && $inputLines <= 180){
		for ($i = 0; $i < $inputLines; $i++) {
			$s = trim(fgets(STDIN));
			$s = explode(" ", $s);
			
			// 入力値チェック
        	if(count($s) === 2){
        	    if((6 <= $s[0] && $s[0] <= 8) && (0 <= $s[1] && $s[1] <= 59)){
                    array_push($inputArray,$s);
        	    }
        	} else {
        	    errorMsg();
        	}
		}
	} else {
		errorMsg();
	}
	return $inputArray;
}

// 最遅出発電車時刻を求める
function setTrainDeparture($needBTime,$needCTime,$inputTrainTimeArray){
    
    // 最遅電車出発時刻格納用配列
    $latestDepartureTime = array();
    
    // 乗車から出社までの所要時間（分）
    $needTime = $needBTime + $needCTime;
    
    // 最遅出発電車時刻を求める
    foreach($inputTrainTimeArray as $inputTime){
        // 計算用一時変数
        $tmpInputTimeArray = $inputTime;
        
        // 一時変数に計算後時刻を格納
        $sumMinute = $needTime + $inputTime[1];
        $tmpInputTimeArray[0] += floor($sumMinute / 60);
        $tmpInputTimeArray[1] = $sumMinute % 60;
        
        // 計算後時刻と最遅電車出発時刻を比較する
        if($tmpInputTimeArray[0] < 9){
            if(empty($latestDepartureTime)){
                $latestDepartureTime = $inputTime;
            } else {
                if(sprintf('%02d',$latestDepartureTime[0]).sprintf('%02d',$latestDepartureTime[1]) < 
                    sprintf('%02d',$tmpInputTimeArray[0]).sprintf('%02d',$tmpInputTimeArray[1])){
                    $latestDepartureTime = $inputTime;
                }
            }
        }
    }

    return $latestDepartureTime;
}

function setLeaveHouseTime($needATime,$latestTrainTime){
    
    // 家の適正出発時刻
    $leaveHouseTime = array();
    
    // 出発時刻を計算
    if(($latestTrainTime[1] - $needATime) < 0){
        $leaveHouseTime[0] = $latestTrainTime[0] - 1;
        $leaveHouseTime[1] = 60 - (($latestTrainTime[1] - $needATime) * -1); 
    } else {
        $leaveHouseTime[0] = $latestTrainTime[0];
        $leaveHouseTime[1] = $latestTrainTime[1] - $needATime;
    }
    
    return $leaveHouseTime;
}

// エラーメッセージ出力を出力し、処理を終了する関数
function errorMsg(){
	echo "\n不正な値が入力されました\n";
	exit;
}

?>