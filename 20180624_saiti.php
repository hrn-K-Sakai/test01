<?php

// ��s��abc�̓��͂ƃ`�F�b�N
$inputNeedTimeArray = inputNeedTime();

// �d�Ԃ̖{���Ɣ��Ԏ����̓��͂ƃ`�F�b�N
$inputTrainTimeArray = inputTrainTime();

// �Œx�o���d�Ԏ��������߂�
$latestTrainTime = setTrainDeparture($inputNeedTimeArray[1],$inputNeedTimeArray[2],$inputTrainTimeArray);

// �Ƃ̓K���o�����������߂�
$leaveHouseTime = setLeaveHouseTime($inputNeedTimeArray[0],$latestTrainTime);

// �o���������o��
echo sprintf('%02d',$leaveHouseTime[0]).':'.sprintf('%02d',$leaveHouseTime[1]);
echo "\n";

// ��s��abc�̓��͂ƃ`�F�b�N
function inputNeedTime(){
	// ���͒l�i�[�p�z��
	$inputArray = array();

	// �W�����͂���l���󂯎��
	$inputLines = trim(fgets(STDIN));
    $inputArray = explode(" ",$inputLines);
	
	// ���͒l���`�F�b�N
	if(count($inputArray) === 3){
	    foreach($inputArray as $inputValue){
        	// ���͒l��1�`30���`�F�b�N
        	if(!(1 <= $inputLines && $inputLines <= 30)){
        		errorMsg();
        	}
    	}
	} else {
	    errorMsg();
	}

	
	return $inputArray;
}

// �d�Ԃ̖{���Ɣ��Ԏ����̓��͂ƃ`�F�b�N
function inputTrainTime(){
	// ���͒l�i�[�p�z��
	$inputArray = array();

	// �W�����͂���l���󂯎��
	$inputLines = trim(fgets(STDIN));

	// ���͒l��1�`180���`�F�b�N
	if(1 <= $inputLines && $inputLines <= 180){
		for ($i = 0; $i < $inputLines; $i++) {
			$s = trim(fgets(STDIN));
			$s = explode(" ", $s);
			
			// ���͒l�`�F�b�N
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

// �Œx�o���d�Ԏ��������߂�
function setTrainDeparture($needBTime,$needCTime,$inputTrainTimeArray){
    
    // �Œx�d�ԏo�������i�[�p�z��
    $latestDepartureTime = array();
    
    // ��Ԃ���o�Ђ܂ł̏��v���ԁi���j
    $needTime = $needBTime + $needCTime;
    
    // �Œx�o���d�Ԏ��������߂�
    foreach($inputTrainTimeArray as $inputTime){
        // �v�Z�p�ꎞ�ϐ�
        $tmpInputTimeArray = $inputTime;
        
        // �ꎞ�ϐ��Ɍv�Z�㎞�����i�[
        $sumMinute = $needTime + $inputTime[1];
        $tmpInputTimeArray[0] += floor($sumMinute / 60);
        $tmpInputTimeArray[1] = $sumMinute % 60;
        
        // �v�Z�㎞���ƍŒx�d�ԏo���������r����
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
    
    // �Ƃ̓K���o������
    $leaveHouseTime = array();
    
    // �o���������v�Z
    if(($latestTrainTime[1] - $needATime) < 0){
        $leaveHouseTime[0] = $latestTrainTime[0] - 1;
        $leaveHouseTime[1] = 60 - (($latestTrainTime[1] - $needATime) * -1); 
    } else {
        $leaveHouseTime[0] = $latestTrainTime[0];
        $leaveHouseTime[1] = $latestTrainTime[1] - $needATime;
    }
    
    return $leaveHouseTime;
}

// �G���[���b�Z�[�W�o�͂��o�͂��A�������I������֐�
function errorMsg(){
	echo "\n�s���Ȓl�����͂���܂���\n";
	exit;
}

?>