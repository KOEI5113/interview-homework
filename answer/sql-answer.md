# 資料庫測驗
## 題目一
> 請寫出一條 SQL 查詢語句，列出在 2023 年 5 月下訂的訂單，使用台幣 (TWD) 付款且 5 月總金 額最多的前 10 筆的 bnb_id、bnb_name，以及 5 月各旅宿總金額 (may_amount)。

### 回答
```sql
SELECT 
  orders.bnb_id, 
  bnbs.name AS bnb_name, 
  SUM(orders.amount) as may_amount
FROM orders
INNER JOIN bnbs ON bnbs.id = orders.bnb_id
WHERE 
  orders.currency = "TWD" 
  AND orders.created_at BETWEEN "2024-05-01" AND "2024-05-31"
GROUP BY orders.bnb_id, bnbs.name
ORDER BY may_amount DESC
LIMIT 10;
```

## 題目二

> 在題目一的執行下，我們發現 SQL 執行速度很慢，您會怎麼去優化?請闡述您怎麼判斷與優化 的方式

### 回答

我們可以先善用 EXPLAIN 指令來根據 EXPLAIN 跑出的結果進行語句。

我們可以：

1. 分析是否有對於查詢欄位建立應當建立的 Index，例如上例中的 `orders.currency`, `orders.created_at`, `orders.bnb_id`
1. 評估 `orders` 資料表與 `bnbs` 資料表的數據量，這點可能會反映在 `rows` 與 `filtered` 上
1. Extra 欄位也能提供我們其他可供參考的資料，諸如是否 `using filesort` 或 `using temporary` 等，這些都可能讓 SQL 的速度變慢。

除此之外，也可以根據表的用途，判斷是否可以藉由 `partition` 去區分 cold data 與 hot data，例如可以針對 `orders` 去做 `RANGE` 分區，例如根據月份或是年份進行資料分區；除了透過 `partition` 進行分區外，我們也可以直接將 `created_at` 欄位刻意反正規化地拆分成「年」、「月」、「日」欄位，並設立 `Index` 來藉由 `Index` 進行更快速的查詢。

除了在 SQL 上的優化外，我們也能根據該 SQL 的功能場景與重要性，去評估是否有需要以其他方式實現這些功能。例如將這些工作交由排程預先產出然後存放於資料庫或快取之中，讓功能需要取得資料時，可以直接訪問預先產出的結果。

這些都是可以評估的做法。

但如果目的只是一般的內部公司報表，我想應該安排離峰時間進行查詢並產出報表結果即可。