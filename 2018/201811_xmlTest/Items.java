package xmlTest;

/**
 * 
 * 商品情報集計用Bean
 * 
*/
public class Items {
	private String itemName = null;
	private int totalPrice = 0;
	private int totalCount = 0;
	
	public Items(String itemName,int totalPrice, int totalCount){
		this.itemName = itemName;
		this.totalPrice = totalPrice;
		this.totalCount = totalCount;
	}
	
	public String getItemName() {
		return itemName;
	}
	
	public void setItemName(String itemName) {
		this.itemName = itemName;
	}
	
	public int getTotalPrice() {
		return totalPrice;
	}
	
	public void setTotalPrice(int totalPrice) {
		this.totalPrice = totalPrice;
	}
	
	public int getTotalCount() {
		return totalCount;
	}
	
	public void setTotalCount(int totalCount) {
		this.totalCount = totalCount;
	}
}
