package leetConversion;

import java.util.Scanner;
import java.util.regex.Pattern;

public class Main {
	public static void main(String[] args) throws Exception {
		/** 最小入力文字数 */
		int minStrLength = 1;
		/** 最大入力文字数 */
		int maxStrLength = 100;
		/** 正規表現パターン（大文字英字）*/
		Pattern pattern = Pattern.compile("^[A-Z]+$");
		
		// 標準入力処理
		Scanner sc = new Scanner(System.in);
		String line = sc.nextLine();
		sc.close();
		
		// 文字数チェック
		if (line.length() < minStrLength || maxStrLength < line.length()) {
			// エラーメッセージ出力（自由記載）
			throw new Exception("文字列が1～100文字以内ではありません。");
		}
		
		// 文字列パターンチェック
		if(!pattern.matcher(line).matches()){
			// エラーメッセージ出力（自由記載）
			throw new Exception("文字列が大文字英字ではありません。");
		}
		
		System.out.println(LeetConversion.conversion(line));
	}
}
