# 面試資訊實作

本 Repository 將以 Laravel 11 進行「建立訂單 API」與「查詢訂單 API」之實作。


## 開發環境

請見 ./docker

## 專案程式碼

請見 ./laravel-app

## 需求內容

1. 實作一隻 POST API `/api/orders` 作為建立訂單 API
    1. 需要進行 request body 格式檢查
    2. 建立訂單過程需屬於非同步，回傳 200 後藉由 Events & Listener 的機制觸發資料建立
    3. 根據傳入的 `currency` 不同，會將資料傳入不同的資料表中
    4. `currency` 只會傳入以下五種資料
        1. `TWD` - 寫入 `orders_twd`
        2. `USD` - 寫入 `orders_usd`
        3. `JPY` - 寫入 `orders_jpy`
        4. `RMB` - 寫入 `orders_rmb`
        5. `MYR` - 寫入 `orders_myr`
2. 實作一隻 GET API `/api/orders/{id}` 作為查詢訂單 API
3. API 將以已知格式進行輸入，並使用 Laravel FormRequest 來實踐
4. 實作類別須符合物件導向設計原則 SOLID 與設計模式。並於該此專案的 README.md 說明您所使用的 SOLID 與設計模式分別為何。
5. 需撰寫 unit test 與 feature test 並覆蓋成功與失敗案例
6. 需要以 docker 包裝開發環境
