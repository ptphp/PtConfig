# 威众接口说明

- ### 充值接口

  * URL : `http://`url`/terminal/api/pay`
  * HTTP Method : `POST`
  * 请求参数：
        + amount:     金额
        + user_id:    用户ID
        + terminal_id 终端ID
        + time        UNIX当前时间戳        
  * 请求示例：
  
    {"amount": 500.12, "terminal_id": "xxx-xxx", "user_id": 11100, "time": 1404218263}, "id": null}

  * 返回参数：
    + 格式：`json`
    + 结构：
        - 错误: `{"id":"","error":1,"result":"error msg"}`
        - 成功: `{"id":"","error":0,"result":"pay ok"}`
