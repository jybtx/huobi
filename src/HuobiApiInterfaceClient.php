<?php

namespace Jybtx\HuobiApi;

class HuobiApiInterfaceClient
{
	protected $account_id;
	protected $access_key;
	protected $secret_key;
	protected $url;
	public $api_method = '';
	public $req_method = '';
	private $api       = '';
	
	public function __construct($accountId,$accessKey,$secretKey,$url)
	{
		$this->account_id = $accountId;
		$this->access_key = $accessKey;
		$this->secret_key = $secretKey;
		$this->url        = $url;
		$this->api        = parse_url($url)['host'];
	}
	/**
	 * 行情类API
	 */
	/**
	 * 获取K线数据
	 * @author jybtx
	 * @date   2019-11-01
	 * @param  string     $symbol [description]
	 * @param  string     $period [description]
	 * @param  integer    $size   [description]
	 * @return [type]             [description]
	 */
	public function getHistoryKline($symbol = '', $period='',$size=0) {
        $this->api_method = "/market/history/kline";
        $this->req_method = 'GET';
        $param = [
            'symbol' => $symbol,
            'period' => $period
        ];
        if ($size) $param['size'] = $size;
        $url = $this->createSignUrl($param);
        $return = $this->curl($url);
        return $return;
    }
    /**
     * 获取聚合行情(Ticker)
     * @author jybtx
     * @date   2019-11-01
     * @param  string     $symbol [description]
     * @return [type]             [description]
     */
    public function getDetailMerged($symbol = '') {
        $this->api_method = "/market/detail/merged";
        $this->req_method = 'GET';
        $param = [
            'symbol' => $symbol,
        ];
        $url = $this->createSignUrl($param);
        return $this->curl($url);
    }
    /**
     * 获取 Market Depth 数据
     * @author jybtx
     * @date   2019-11-01
     * @param  string     $symbol [description]
     * @param  string     $type   [description]
     * @return [type]             [description]
     */
    public function getMarketDepth($symbol = '', $type = '') {
        $this->api_method = "/market/depth";
        $this->req_method = 'GET';
        $param = [
			'symbol' => $symbol,
			'type'   => $type
        ];
        $url = $this->createSignUrl($param);
        return $this->curl($url);
    }
    /**
     * 获取 Trade Detail 数据
     * @author jybtx
     * @date   2019-11-01
     * @param  string     $symbol [description]
     * @return [type]             [description]
     */
    public function getMarketTrade($symbol = '') {
        $this->api_method = "/market/trade";
        $this->req_method = 'GET';
        $param = [
            'symbol' => $symbol
        ];
        $url = $this->createSignUrl($param);
        return $this->curl($url);
    }
    /**
     * 批量获取最近的交易记录
     * @author jybtx
     * @date   2019-11-01
     * @param  string     $symbol [description]
     * @param  string     $size   [description]
     * @return [type]             [description]
     */
    public function getHistoryTrade($symbol = '', $size = '') {
        $this->api_method = "/market/history/trade";
        $this->req_method = 'GET';
        $param = [
            'symbol' => $symbol
        ];
        if ($size) $param['size'] = $size;
        $url = $this->createSignUrl($param);
        return $this->curl($url);
    }
    /**
     * 获取 Market Detail 24小时成交量数据
     * @author jybtx
     * @date   2019-11-01
     * @param  string     $symbol [description]
     * @return [type]             [description]
     */
    public function getMarketDetail($symbol = '') {
        $this->api_method = "/market/detail";
        $this->req_method = 'GET';
        $param = [
            'symbol' => $symbol
        ];
        $url = $this->createSignUrl($param);
        return $this->curl($url);
    }
    /**
     * 公共类API
     */
    /**
     * 查询系统支持的所有交易对及精度
     * @author jybtx
     * @date   2019-11-01
     * @return [type]     [description]
     */
    public function getCommonSymbols() {
        $this->api_method = '/v1/common/symbols';
        $this->req_method = 'GET';
        $url = $this->createSignUrl([]);
        return $this->curl($url);
    }
    /**
     * 查询系统支持的所有币种
     * @author jybtx
     * @date   2019-11-01
     * @return [type]     [description]
     */
    public function getCommonAllCurrencys() {
        $this->api_method = "/v1/common/currencys";
        $this->req_method = 'GET';
        $url = $this->create_sign_url([]);
        return $this->curl($url);
    }
    /**
     * 查询系统当前时间
     * @author jybtx
     * @date   2019-11-01
     * @return [type]     [description]
     */
    public function getCommonTimestamp() {
        $this->api_method = "/v1/common/timestamp";
        $this->req_method = 'GET';
        $url = $this->createSignUrl([]);
        return $this->curl($url);
    }
    /**
     * 查询当前用户的所有账户(即account-id)
     * @author jybtx
     * @date   2019-11-01
     * @return [type]     [description]
     */
    public function getAccountAccounts() {
        $this->api_method = "/v1/account/accounts";
        $this->req_method = 'GET';
        $url = $this->createSignUrl([]);
        return $this->curl($url);
    }
    /**
     * 查询指定账户的余额
     * @author jybtx
     * @date   2019-11-01
     * @return [type]     [description]
     */
    public function getAccountBalance() {
        $this->api_method = "/v1/account/accounts/".$this->account_id."/balance";
        $this->req_method = 'GET';
        $url = $this->createSignUrl([]);
        return $this->curl($url);
    }
    /**
     * 交易类API
     */
    /**
     * 交易下单
     * @author jybtx
     * @date   2019-11-01
     * @param  integer    $amount [description]
     * @param  integer    $price  [description]
     * @param  string     $symbol [description]
     * @param  string     $type   [description]
     * @return [type]             [description]
     */
    public function placeOrder($amount=0,$price=0,$symbol='',$type='') {
        $source = 'api';
        $this->api_method = "/v1/order/orders/place";
        $this->req_method = 'POST';
        // 数据参数
        $postdata = [
            'account-id' => $this->account_id,
            'amount'     => $amount,
            'source'     => $source,
            'symbol'     => $symbol,
            'type'       => $type
        ];
        if ($price) {
            $postdata['price'] = $price;
        }
        $url = $this->createSignUrl();
        return $this->curl($url,$postdata);
    }
    /**
     * 申请撤销一个订单请求
     * @author jybtx
     * @date   2019-11-01
     * @param  [type]     $order_id [description]
     * @return [type]               [description]
     */
    public function cancelOrderRequest($order_id) {
        $source = 'api';
        $this->api_method = '/v1/order/orders/'.$order_id.'/submitcancel';
        $this->req_method = 'POST';
        $postdata = [];
        $url = $this->createSignUrl();
        return $this->curl($url,$postdata);
    }
    /**
     * 批量撤销订单
     * @author jybtx
     * @date   2019-11-01
     * @param  array      $order_ids [description]
     * @return [type]                [description]
     */
    public function bulkOrderCancellation( $order_ids = array() ) {
        $source = 'api';
        $this->api_method = '/v1/order/orders/batchcancel';
        $this->req_method = 'POST';
        $postdata = [
            'order-ids' => $order_ids
        ];
        $url = $this->createSignUrl();
        return $this->curl($url,$postdata);
    }
    /**
     * 查询某个订单详情
     * @author jybtx
     * @date   2019-11-01
     * @param  [type]     $order_id [description]
     * @return [type]               [description]
     */
    public function getOrderDetails($order_id) {
        $this->api_method = '/v1/order/orders/'.$order_id;
        $this->req_method = 'GET';
        $url = $this->createSignUrl();
        return $this->curl($url);
    }
    /**
     * 查询某个订单的成交明细
     * @author jybtx
     * @date   2019-11-01
     * @param  integer    $order_id [description]
     * @return [type]               [description]
     */
    public function getOrderDetailsMatchresults($order_id = 0) {
        $this->api_method = '/v1/order/orders/'.$order_id.'/matchresults';
        $this->req_method = 'GET';
        $url = $this->createSignUrl();
        return $this->curl($url);
    }
    /**
     * 查询当前委托、历史委托
     * @author jybtx
     * @date   2019-11-01
     * @param  string     $symbol     [description]
     * @param  string     $states     [description]
     * @param  string     $types      [description]
     * @param  string     $start_date [description]
     * @param  string     $end_date   [description]
     * @param  string     $from       [description]
     * @param  string     $direct     [description]
     * @param  string     $size       [description]
     * @return [type]                 [description]
     */
    public function getCurrentAndHistoricalOrders($symbol = '',$states = '',$types = '',$start_date = '',$end_date = '',$from = '',$direct='',$size = '') {
        $this->api_method = '/v1/order/orders';
        $this->req_method = 'GET';
        $postdata = [
            'symbol' => $symbol,
            'states' => $states
        ];
        if ($types) $postdata['types'] = $types;
        if ($start_date) $postdata['start-date'] = $start_date;
        if ($end_date) $postdata['end-date'] = $end_date;
        if ($from) $postdata['from'] = $from;
        if ($direct) $postdata['direct'] = $direct;
        if ($size) $postdata['size'] = $size;
        $url = $this->createSignUrl($postdata);
        return $this->curl($url);
    }
    /**
     * 查询当前成交、历史成交
     * @author jybtx
     * @date   2019-11-01
     * @param  string     $symbol     [description]
     * @param  string     $types      [description]
     * @param  string     $start_date [description]
     * @param  string     $end_date   [description]
     * @param  string     $from       [description]
     * @param  string     $direct     [description]
     * @param  string     $size       [description]
     * @return [type]                 [description]
     */
    public function getCurrentAndHistoryOrdersMatchresults($symbol = '', $types = '',$start_date = '',$end_date = '',$from = '',$direct='',$size = '') {
        $this->api_method = '/v1/order/matchresults';
        $this->req_method = 'GET';
        $postdata = [
            'symbol' => $symbol
        ];
        if ($types) $postdata['types'] = $types;
        if ($start_date) $postdata['start-date'] = $start_date;
        if ($end_date) $postdata['end-date'] = $end_date;
        if ($from) $postdata['from'] = $from;
        if ($direct) $postdata['direct'] = $direct;
        if ($size) $postdata['size'] = $size;
        $url = $this->createSignUrl();
        return $this->curl($url,$postdata);
    }
    /**
     * 获取账户余额
     * @author jybtx
     * @date   2019-11-01
     * @return [type]     [description]
     */
    public function getAccountIdBalance() {
        $this->api_method = "/v1/account/accounts/".$this->account_id."/balance";
        $this->req_method = 'GET';
        $url = $this->createSignUrl();
        return $this->curl($url);
    }
    /**
     * 借贷类API
     */
    /**
     * 现货账户划入至借贷账户
     * @author jybtx
     * @date   2019-11-01
     * @param  string     $symbol   [description]
     * @param  string     $currency [description]
     * @param  string     $amount   [description]
     * @return [type]               [description]
     */
    public function loanAccountTransferIn($symbol = '',$currency='',$amount='') {
        $this->api_method = "/v1/dw/transfer-in/margin";
        $this->req_method = 'POST';
        $postdata = [
			'symbol	'  => $symbol,
			'currency' => $currency,
			'amount'   => $amount
        ];
        $url = $this->createSignUrl($postdata);
        return $this->curl($url);
    }
    /**
     * 借贷账户划出至现货账户
     * @author jybtx
     * @date   2019-11-01
     * @param  string     $symbol   [description]
     * @param  string     $currency [description]
     * @param  string     $amount   [description]
     * @return [type]               [description]
     */
    public function loanAccountTransferOut($symbol = '',$currency='',$amount='') {
        $this->api_method = "/v1/dw/transfer-out/margin";
        $this->req_method = 'POST';
        $postdata = [
			'symbol	'  => $symbol,
			'currency' => $currency,
			'amount'   => $amount
        ];
        $url = $this->createSignUrl($postdata);
        return $this->curl($url);
    }
    /**
     * 申请借贷
     * @author jybtx
     * @date   2019-11-01
     * @param  string     $symbol   [description]
     * @param  string     $currency [description]
     * @param  string     $amount   [description]
     * @return [type]               [description]
     */
    public function marginOrders($symbol = '',$currency='',$amount='') {
        $this->api_method = "/v1/margin/orders";
        $this->req_method = 'POST';
        $postdata = [
			'symbol	'  => $symbol,
			'currency' => $currency,
			'amount'   => $amount
        ];
        $url = $this->createSignUrl($postdata);
        return $this->curl($url);
    }
    /**
     * 归还借贷
     * @author jybtx
     * @date   2019-11-01
     * @param  string     $order_id [description]
     * @param  string     $amount   [description]
     * @return [type]               [description]
     */
    public function repayMarginOrders($order_id='',$amount='') {
        $this->api_method = "/v1/margin/orders/{$order_id}/repay";
        $this->req_method = 'POST';
        $postdata = [
            'amount' => $amount
        ];
        $url = $this->createSignUrl($postdata);
        return $this->curl($url);
    }
    /**
     * 借贷订单
     * @author jybtx
     * @date   2019-11-01
     * @param  string     $symbol     [description]
     * @param  string     $currency   [description]
     * @param  [type]     $states     [description]
     * @param  [type]     $start_date [description]
     * @param  [type]     $end_date   [description]
     * @param  [type]     $from       [description]
     * @param  [type]     $direct     [description]
     * @param  [type]     $size       [description]
     * @return [type]                 [description]
     */
    public function getLoanOrders($symbol='',$currency='',$states,$start_date,$end_date,$from,$direct,$size) {
        $this->api_method = "/v1/margin/loan-orders";
        $this->req_method = 'GET';
        $postdata = [
			'symbol'   => $symbol,
			'currency' => $currency,
			'states'   => $states
        ];
        if ($currency) $postdata['currency'] = $currency;
        if ($start_date) $postdata['start-date'] = $start_date;
        if ($end_date) $postdata['end-date'] = $end_date;
        if ($from) $postdata['from'] = $from;
        if ($direct) $postdata['direct'] = $direct;
        if ($size) $postdata['size'] = $size;
        $url = $this->createSignUrl($postdata);
        return $this->curl($url);
    }
    /**
     * 借贷账户详情
     * @author jybtx
     * @date   2019-11-01
     * @param  string     $symbol [description]
     * @return [type]             [description]
     */
    public function marginBalance($symbol='') {
        $this->api_method = "/v1/margin/accounts/balance";
        $this->req_method = 'POST';
        $postdata = [];
        if ($symbol) $postdata['symbol'] = $symbol;
        $url = $this->createSignUrl($postdata);
        return $this->curl($url);
    }

    /**
     * 虚拟币提现API
     */
    /**
     * 申请提现虚拟币
     * @author jybtx
     * @date   2019-11-01
     * @param  string     $address  [description]
     * @param  string     $amount   [description]
     * @param  string     $currency [description]
     * @param  string     $fee      [description]
     * @param  string     $addr_tag [description]
     * @return [type]               [description]
     */
    public function withdrawVirtualCurrencyCreate($address='',$amount='',$currency='',$fee='',$addr_tag='') {
        $this->api_method = "/v1/dw/withdraw/api/create";
        $this->req_method = 'POST';
        $postdata = [
			'address'  => $address,
			'amount'   => $amount,
			'currency' => $currency
        ];
        if ($fee) $postdata['fee'] = $fee;
        if ($addr_tag) $postdata['addr-tag'] = $addr_tag;
        $url = $this->createSignUrl($postdata);
        return $this->curl($url);
    }
    /**
     * 申请取消提现虚拟币
     * @author jybtx
     * @date   2019-11-01
     * @param  string     $withdraw_id [description]
     * @return [type]                  [description]
     */
    public function cancelWithdrawalOfVirtualCurrency($withdraw_id='') {
        $this->api_method = "/v1/dw/withdraw-virtual/{$withdraw_id}/cancel";
        $this->req_method = 'POST';
        $url = $this->createSignUrl();
        return $this->curl($url);
    }

    /**
     * 类库方法
     */

    /**
     * 生成验签URL
     * @author jybtx
     * @date   2019-11-01
     * @param  array      $append_param [description]
     * @return [type]                   [description]
     */
    protected function createSignUrl($append_param = []) {
        // 验签参数
        $param = [
			'AccessKeyId'      => $this->access_key,
			'SignatureMethod'  => 'HmacSHA256',
			'SignatureVersion' => 2,
			'Timestamp'        => date('Y-m-d\TH:i:s', time())
        ];
        if ($append_param) {
            foreach($append_param as $k=>$ap) {
                $param[$k] = $ap;
            }
        }
        return $this->url.$this->api_method.'?'.$this->bindParam($param);
    }
    /**
     * 组合参数
     * @author jybtx
     * @date   2019-11-01
     * @param  [type]     $param [description]
     * @return [type]            [description]
     */
    protected function bindParam($param) {
        $u = [];
        $sort_rank = [];
        foreach($param as $k=>$v) {
            $u[] = $k."=".urlencode($v);
            $sort_rank[] = ord($k);
        }
        asort($u);
        $u[] = "Signature=".urlencode($this->createSig($u));
        return implode('&', $u);
    }
    /**
     * 生成签名
     * @author jybtx
     * @date   2019-11-01
     * @param  [type]     $param [description]
     * @return [type]            [description]
     */
    protected function createSig($param) {
        $sign_param_1 = $this->req_method."\n".$this->api."\n".$this->api_method."\n".implode('&', $param);
        $signature = hash_hmac('sha256', $sign_param_1, $this->secret_key, true);
        return base64_encode($signature);
    }
    /**
     * CURL请求
     * @author jybtx
     * @date   2019-11-01
     * @param  [type]     $url      [description]
     * @param  array      $postdata [description]
     * @return [type]               [description]
     */
    protected function curl($url,$postdata=[]) {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        if ($this->req_method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postdata));
        }
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_TIMEOUT,60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
        ]);
		$output = curl_exec($ch);
		$info   = curl_getinfo($ch);
        curl_close($ch);
        return json_decode($output,true);
    }
}