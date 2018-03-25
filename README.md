# BabyShop Api说明

## 目录

## 说明

- GET
```javascript
wx.fetch({
  url: 'addresses',
  data: {
    weixinId: {{weixinId}}
  }
})
```

- POST
```javascript
wx.fetch({
  url: 'addresses',
  method: 'POST',
  data: {
    weixinId: {{weixinId}},
    name: {{name}},
    phone: {{phone}},
    province: {{province}},
    city: {{city}},
    detail: {{detail}},
  }
})
```

- DELETE
```javascript
wx.fetch({
  url: 'addresses',
  method: 'DELETE',
  params: `weixinId=${weixinId}&int_id=${id}&bool_defalut=${default}`
})
```
## 接口

### 1. 地址

#### 1.1 获取用户地址列表
- URL: addresses
- METHOD: GET
- PARAMS:

| 参数名 | 必须 | 类型 | 说明 |
| :--------: | :----:| :--: | :--: |
| weixinId | 是 | string | 微信openid |


#### 1.2 添加地址
- URL: addresses
- METHOD: POST
- PARAMS:

| 参数名 | 必须 | 类型 | 说明 |
| :--------: | :----:| :--: | :--: |
| weixinId | 是 | string | 微信openid |
| name | 是 | string | 姓名 |
| phone | 是 | string | 手机 |
| province | 是 | string | 省 |
| city | 是 | string | 市 |
| county | 是 | string | 区县 |
| detail | 是 | string | 详细地址 |

#### 1.3 编辑地址信息
- URL: addresses
- METHOD: PUT
- PARAMS:

| 参数名 | 必须 | 类型 | 说明 |
| :--------: | :----:| :--: | :--: |
| weixinId | 是 | string | 微信openid |
| name | 是 | string | 姓名 |
| phone | 是 | string | 手机 |
| province | 是 | string | 省 |
| city | 是 | string | 市 |
| county | 是 | string | 区县 |
| detail | 是 | string | 详细地址 |

#### 1.4 设置默认地址
- URL: addresses
- METHOD: PUT
- PARAMS:

| 参数名 | 必须 | 类型 | 说明 |
| :--------: | :----:| :--: | :--: |
| weixinId | 是 | string | 微信openid |
| int_id | 是 | string | 地址ID |

#### 1.5 删除地址
- URL: addresses
- METHOD: DELETE
- PARAMS:

| 参数名 | 必须 | 类型 | 说明 |
| :--------: | :----:| :--: | :--: |
| weixinId | 是 | string | 微信openid |
| int_id | 是 | string | 地址ID |
| bool_default | 是 | string | 是否为默认地址 |