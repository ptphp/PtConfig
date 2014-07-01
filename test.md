
## 1 终端接口

- ### 1-1充值接口

  * URL : `/terminal/api/pay`
  * HTTP Method : `POST`
  * 请求参数：
        + amount:     金额
        + user_id:    用户ID
        + terminal_id 终端ID
        + time        请求时间      
  * 请求示例：
  
    {"amount": 560.11, "terminal_id": "xx-xxx-xx", "user_id": 11202, "time": "2014-07-02 00:56:14"}

  * 返回参数：
    + 格式：`json`
    + 结构：
        - 错误: `{"id":"","error":1,"result":"error msg"}`
        - 成功: `{"id":"","error":0,"result":"pay ok"}`


- ### 1-2提现接口

  * URL : `/terminal/api/withdraw`
  * HTTP Method : `POST`
  * 请求参数：
        + amount:     金额
        + user_id:    用户ID
        + terminal_id 终端ID
        + time        请求时间  
        + trans_pass  交易密码
        + 
        
  * 请求示例：
  
    {"trans_pass": "password", "amount": 560.11, "terminal_id": "xx-xxx-xx", "user_id": 11202, "time": "2014-07-02 00:59:02"}

  * 返回参数：
    + 格式：`json`
    + 结构：
        - 错误: `{"id":"","error":1,"result":"error msg"}`
        - 成功: `{"id":"","error":0,"result":"withdraw ok"}`
       

## 2 APP查询接口

- ### 接口说明

  * URL : `/api/app/record`
  * HTTP Method : `GET`
  * 请求参数：
        + type:      类型 ｛terminal_pay：充值记录|terminal_withdraw:提现记录|mall_withdraw：商城提现记录|rebate：返利记录｝
        + limit      一次返回条数
        + page       页码
        + start_time 开始时间
        + end_time   结束时间

        
  * 请求示例：
  
    一次请求10条 请求页码是 1 类型：terminal_pay：充值记录

    {"limit": 10, "start_time": "2014-06-10", "type": "terminal_pay", "end_time": "2014-06-20", "page": 1}
    
    
    一次请求20条 请求页码是 3 类型：terminal_withdraw：提现记录

    {"limit": 20, "start_time": "2014-06-10", "type": "terminal_withdraw", "end_time": "2014-06-20", "page": 3}


  * 返回参数：
    + 格式：`json`
    + 结构：
        - 错误: `{"id":"","error":1,"result":"error msg"}`
        - 成功: `{"result": {"rows": [{"amount": "1000", "id": "1", "time": "2014-07-02 01:02:54"}], "total": 100}, "id": null, "error": 0}`



## 3 商城提现接口

- ### 接口说明

  * URL : `/api/mall/withdraw`
  * HTTP Method : `POST`
  * 请求参数：
        + trans_pass        交易密码
        + amount            金额
        + user_id           用户ID
        + time              时间
        + orderno           订单号
        + sign              签名

        
  * 请求示例：

    trans_pass=e10adc3949ba59abbe56e057f20f883e&orderno=201406531212&user_id=11223&amount=1000&time=2014-07-02 01:17:41
    
    
  * PHP代码示例：
  
    $trans_pass = "123456";
    $key = "$%^&*(H)h00j9ij";
    $data = array(
     'amount'=>1000,
     'user_id'=>11223,
     'orderno'=>"201406531212",
     'time'=>date("Y-m-d H:i:s"),
     'trans_pass'=>md5($trans_pass)
    );
    
    $sign = md5($key.$data['amount'].$data['user_id'].$data['orderno'].$data['time'].$data['trans_pass']);
    $data['sign'] = $sign;
    
    $res = file_get_content($url."?".http_build_query($data))


  * 返回参数：
    + 格式：`json`
    + 结构：
        - 错误: `{"id":"","error":1,"result":"error msg"}`
        - 成功: - 成功: `{"id":"","error":0,"result":"withdraw ok"}`








      
