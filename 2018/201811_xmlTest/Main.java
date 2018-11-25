package xmlTest;

import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.InputStream;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Comparator;
import java.util.Date;
import java.util.LinkedHashMap;
import java.util.List;
import java.util.Map;
import java.util.Scanner;

import javax.xml.bind.JAXB;

/**
 * 
 * 実行用Mainクラス
 *
 */
public class Main {
	
	public static void main(String[] args) {
		
		/** 入力ファイル名 */
		String fileName = null;
		/** 日時変換用入力データフォーマット */
		SimpleDateFormat sdf = new SimpleDateFormat("yyyyMMddHHmmss");
		/** 日時変換用出力データフォーマット */
		String pattern = "yyyy年MM月dd日 HH時mm分ss秒";
		/** 商品情報Map Map<商品ID,商品情報> */
		Map<String, Items> itemsMap = new LinkedHashMap<>();
		
		// 標準入力からファイルパスを受け取る
		Scanner sc = new Scanner(System.in);
		fileName = sc.nextLine();
		sc.close();
		
		// XMLファイルを読み込む
		InputStream stream = null;
		try {
			stream = new FileInputStream(fileName);
		} catch (FileNotFoundException e) {
			System.out.println("指定されたファイルが存在しません。");
			e.printStackTrace();
		}
		
		// XMLファイルからインスタンスを生成
		Receipt receipt = JAXB.unmarshal(stream, Receipt.class);
		
		// インスタンスから商品情報リストを取得
		List<Item> itemList = receipt.getItems();
		
		// インスタンスから購入時間を取得
		String purchaseTime = receipt.getPurchaseTime();
		
		// 購入時間の形式を変換
		Date date = null;
		try {
			date = sdf.parse(purchaseTime);
		} catch (ParseException e) {
			System.out.println("日付の形式変換に失敗しました。");
			e.printStackTrace();
		}
		sdf.applyPattern(pattern);
		purchaseTime = sdf.format(date);
		
		// 商品情報リストを商品IDで昇順ソート
		itemList.sort(Comparator.comparing(Item::getItemId, Comparator.nullsLast(Comparator.naturalOrder())));
		
		// 商品ID毎に金額・購入個数を集計
		for(int i = 0; i < itemList.size(); i++) {
			Item item = itemList.get(i);
			String itemId = item.getItemId();
			int price = item.getPrice();
			
			// 商品情報Mapに同一商品IDが存在するかチェック
			if (!itemsMap.containsKey(itemId)) {
				// 存在しなかった場合
				// 商品情報集計用オブジェクト生成
				Items items = new Items(item.getItemName(),price,1);
				// Mapに商品IDと商品情報（商品名・金額・購入個数）を登録
				itemsMap.put(itemId, items);
			} else {
				// 存在した場合
				// 同一商品IDの商品情報に、金額と購入個数を加算
				itemsMap.get(itemId).setTotalPrice(itemsMap.get(itemId).getTotalPrice() + price);
				itemsMap.get(itemId).setTotalCount(itemsMap.get(itemId).getTotalCount() + 1);
			}
		}
		
		// 合計金額を算出
		int totalOrderPrice = 0;
		for(String key : itemsMap.keySet()) {
			totalOrderPrice += itemsMap.get(key).getTotalPrice();
		}
		
		// 画面出力
		System.out.println("購入時間：" + purchaseTime);
		for (String key : itemsMap.keySet()) {
			System.out.print("商品名：" + itemsMap.get(key).getItemName());
			System.out.println("　購入個数：" + itemsMap.get(key).getTotalCount());
		}
		System.out.println("合計金額：" + totalOrderPrice + "円");
	}
}
