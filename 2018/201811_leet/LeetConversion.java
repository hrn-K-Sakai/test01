package leetConversion;

import java.util.HashMap;

public class LeetConversion {
	
	// Leet変換用HashMapを初期化
	private static HashMap<String, String> leetMap = new HashMap<String, String>() {
		{
			// Leet変換文字リスト
			put("A","4");
			put("E","3");
			put("G","6");
			put("I","1");
			put("O","0");
			put("S","5");
			put("Z","2");
		}
	};
	
	public static String getLeet(String beforeConvStr) {
		return leetMap.get(beforeConvStr);
	}
	
	// Leet変換メソッド
	public static String conversion(String inputStr) {
		/** 出力用文字列 */
		StringBuilder outputStr = new StringBuilder();
		/** 変換前文字 */
		String beforeConvStr;
		/** 変換後文字 */
		String afterConvStr;
		
		// 入力文字列の長さだけ繰り返す
		for(int i = 0; i < inputStr.length(); i++) {
			// 先頭の文字を切り出し
			beforeConvStr = String.valueOf(inputStr.charAt(i));
			// Leet変換処理
			afterConvStr = getLeet(beforeConvStr);
			
			// 変換結果をチェック
			if(afterConvStr != null){
				// 変換後文字が取得できた場合、変換後文字を追加
				outputStr.append(afterConvStr); 
			} else {
				// 変換後文字が取得できなかった場合、変換前文字を追加
				outputStr.append(beforeConvStr);
			}
		}
		
		return outputStr.toString();
	}
	
}
