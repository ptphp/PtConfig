
## 终端接口

- ### 充值接口

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

  * 交互示例：
  
    request   ==>> {"amount": 560.11, "terminal_id": "xx-xxx-xx", "user_id": 11202, "time": "2014-07-02 00:56:14"}
    response  ==>> {"result": "pay ok", "id": null, "error": 0}
  
- ### 提现接口

  * URL : `http://0.0.0.0/terminal/api/withdraw`
  * HTTP Method : `POST`
  * 请求参数：
        + amount:     金额
        + user_id:    用户ID
        + terminal_id 终端ID
        + time        UNIX当前时间戳
        + token       交易密码
        + 
        
  * 请求示例：
  
    {"amount": 500.12, "terminal_id": "xxx-xxx", "user_id": 11100, "time": 1404218263}, "id": null}

  * 返回参数：
    + 格式：`json`
    + 结构：
        - 错误: `{"id":"","error":1,"result":"error msg"}`
        - 成功: `{"id":"","error":0,"result":"pay ok"}`
        - 
        - 
        - 
        - 
        - 
