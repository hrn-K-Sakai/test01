package xmlTest;

import javax.xml.bind.annotation.XmlElement;

/**
 * 
 * XMLファイル変換用クラス ItemBean
 * 
*/
public class Item {
	private String itemId = null;
	private String itemName = null;
	private int price = 0;
	
	@XmlElement(name = "itemid")
	public String getItemId() {
		return itemId;
	}
	
	public void setItemId(String itemId) {
		this.itemId = itemId;
	}
	
	@XmlElement(name = "itemname")
	public String getItemName() {
		return itemName;
	}
	
	public void setItemName(String name) {
		this.itemName = name;
	}
	
	@XmlElement(name = "price")
	public int getPrice() {
		return price;
	}
	
	public void setPrice(int price) {
		this.price = price;
	}
}
