# API 實作測驗

## 開發環境

請見 [../docker](../docker)

## 專案程式碼

請見 [../laravel-app](../laravel-app)

## SOILD 原則的使用

### 單一職責原則 (Single Responsibility Principle, SRP)

> 各個類別單一職責

- [StoreOrderRequest](../laravel-app/app/Http/Requests/StoreOrderRequest.php) 負責處理建立訂單的請求內容資料驗證
- [ShowOrderRequest](../laravel-app/app/Http/Requests/ShowOrderRequest.php) 負責處理查詢訂單的請求內容資料驗證
- [OrderController](../laravel-app/app/Http/Controllers/OrderController.php) 負責處理 HTTP 請求並觸發所需的 Service
- [OrderService](../laravel-app/app/Services/OrderService.php) 負責處理與訂單相關的商業邏輯
- [OrderRepository](../laravel-app/app/Repositories/OrderRepository.php) 與 [OrderCurrencyRepository](../laravel-app/app/Repositories/OrderCurrencyRepository.php) 分別處理 [Order Model](../laravel-app/app/Models/Order.php) 與 [`Order{幣別}`](../laravel-app/app/Models/OrderCurrency/) 的資料連線邏輯

### 開放-封閉原則 (Open/Closed Principle, OCP)

> 1. 對於擴展是開放的 — 當需求變更時模組行為可以新增的
> 2. 對於修改是封閉的 — 當進行擴展時，不需修改既有的程式碼

當新增新的幣別資料表時，不需要異動 [`OrderCurrencyRepository`](../laravel-app/app/Repositories/OrderCurrencyRepository.php)，只需要調整建立幣別表物件的 [`OrderCurrencyFactory`](../laravel-app/app/Factories/OrderCurrencyFactory.php) 即可。

### 里氏替換原則 (Liskov Substitution Principle, LSP)

> 子類別可以替代父類別而不影響程序的正確性。

例如，所有的 [`Order{幣別}`](../laravel-app/app/Models/OrderCurrency/) 類別（如 `OrderTwd`, `OrderUsd`）都實現了 [`BasicCurrency`](../laravel-app/app/Models/OrderCurrency/BasicCurrency.php)，可以在需要 `BasicCurrency` 的地方替代使用。

### 介面隔離原則 (Interface Segregation Principle, ISP)

> 使用小而專用的接口來避免不必要的依賴。

這次沒有特別使用介面，主要依靠繼承來實現。

### 依賴反轉原則 (Dependency Inversion Principle, DIP)

> 高層模組不依賴於低層模組，而是依賴於抽象。

例如， [`OrderService`](../laravel-app/app/Services/OrderService.php) 依賴於 [`OrderRepository`](../laravel-app/app/Repositories/OrderRepository.php) 和 [`OrderCurrencyRepository`](../laravel-app/app/Repositories/OrderCurrencyRepository.php) 的接口，而不是具體的實現，這樣可以更容易地進行測試和擴展。

## 設計模式的使用

### 事件驅動模式(Event-Driven Pattern)

1. 藉由觸發 [`OrderCreateEvent`](laravel-app/app/Events/OrderCreateEvent.php) 並利用 [`OrderCreateListener`](laravel-app/app/Listeners/OrderCreateListener.php) 監聽事件並建立訂單。

### 工廠模式(Factory Pattern)

1. 不同的 [`Order{幣別}`](laravel-app/app/Models/OrderCurrency/) 類別統一交由 [`OrderCurrencyFactory`](laravel-app/app/Factories/OrderCurrencyFactory.php) 來產生而不是各自宣告。這也能確保當進行修改時，我們不會修改到核心邏輯（例如 [`OrderCurrencyRepository`](laravel-app/app/Repositories/OrderCurrencyRepository.php)）而是只需要修改工廠即可，藉此達成 OCP。