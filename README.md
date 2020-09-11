# huobi 
laravel 火币 API请求库

```terminal
composer require jybtx/huobi
```

### Laravel

#### >= laravel5.5

ServiceProvider will be attached automatically

#### Other

In your `config/app.php` add `Jybtx\HuoBiApi\Providers\HuobiServiceProvider::class` to the end of the `providers` array:

```php
'providers' => [
    ...
    Jybtx\HuoBiApi\Providers\HuobiServiceProvider::class,
],
'aliases'  => [
    ...
    "HuobiApi" => Jybtx\HuoBiApi\Faceds\HuobiFacade::class,
]
```
Publish Configuration

```shell
php artisan vendor:publish --provider "Jybtx\HuoBiApi\Providers\HuobiServiceProvider"
```
OR
```shell
php artisan vendor:publish --tag=huobi-config
```
## Usage
```php
use HuobiApi;
HuobiApi::getAccountAccounts();
```
## Methods

> 行情类API   

- getHistoryKline($symbol = '', $period='',$size=0)   // 获取K线数据
- getDetailMerged($symbol = '')   // 获取聚合行情(Ticker)
- getMarketDepth($symbol = '', $type = '')   // 获取 Market Depth 数据
- getMarketTrade($symbol = '')     // 获取 Trade Detail 数据
- getHistoryTrade($symbol = '', $size = '')    // 批量获取最近的交易记录
- getMarketDetail($symbol = '')  // 获取 Market Detail 24小时成交量数据
> 公共类API
- getCommonSymbols() // 查询系统支持的所有交易对及精度
- getCommonAllCurrencys() // 查询系统支持的所有币种
- getCommonTimestamp() // 查询系统当前时间
- getAccountAccounts() // 查询当前用户的所有账户(即account-id)
- getAccountBalance() // 查询指定账户的余额
> 交易类API
- placeOrder($amount=0,$price=0,$symbol='',$type='') // 交易下单
- cancelOrderRequest($order_id) // 申请撤销一个订单请求
- bulkOrderCancellation( $order_ids = array() ) // 批量撤销订单
- getOrderDetails($order_id) // 查询某个订单详情
- getOrderDetailsMatchresults($order_id = 0) // 查询某个订单的成交明细
- getCurrentAndHistoricalOrders($symbol = '',$states = '',$types = '',$start_date = '',$end_date = '',$from = '',$direct='',$size = '') // 查询当前委托、历史委托
- getCurrentAndHistoryOrdersMatchresults($symbol = '', $types = '',$start_date = '',$end_date = '',$from = '',$direct='',$size = '') // 查询当前成交、历史成交
- getAccountIdBalance() //获取账户余额
> 借贷类API
- loanAccountTransferIn($symbol = '',$currency='',$amount='')    // 现货账户划入至借贷账户
- loanAccountTransferOut($symbol = '',$currency='',$amount='')      // 借贷账户划出至现货账户
- marginOrders($symbol = '',$currency='',$amount='')     // 申请借贷
- repayMarginOrders($order_id='',$amount='')   // 归还借贷
- getLoanOrders($symbol='',$currency='',$states,$start_date,$end_date,$from,$direct,$size) // 借贷订单
- marginBalance($symbol='') // 借贷账户详情
> 虚拟币提现API
- withdrawVirtualCurrencyCreate($address='',$amount='',$currency='',$fee='',$addr_tag='') // 申请提现虚拟币
- cancelWithdrawalOfVirtualCurrency($withdraw_id='')     // 申请取消提现虚拟币

# License
MIT
