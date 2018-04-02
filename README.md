# BabyShop Api说明

## 请求说明

### GET
```javascript
wx.fetch({
  url: 'addresses',
  data: {

  }
})
```

### POST
```javascript
wx.fetch({
  url: 'addresses',
  method: 'POST',
  data: {
    name: {{name}},
    phone: {{phone}},
    province: {{province}},
    city: {{city}},
    detail: {{detail}},
  }
})
```

### DELETE
```javascript
wx.fetch({
  url: 'addresses',
  method: 'DELETE',
  data: {
    int_id: {{int_id}},
    bool_default: {{bool_default}}
  }
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
| int_id | 是 | int | 地址ID |

#### 1.5 删除地址
- URL: addresses
- METHOD: DELETE
- PARAMS:

| 参数名 | 必须 | 类型 | 说明 |
| :--------: | :----:| :--: | :--: |
| weixinId | 是 | string | 微信openid |
| int_id | 是 | int | 地址ID |
| bool_default | 是 | bool | 是否为默认地址 |

### 2. 分类

#### 2.1 添加分类
- URL: categories
- METHOD: POST
- PARAMS:

| 参数名 | 必须 | 类型 | 说明 |
| :--------: | :----:| :--: | :--: |
| name | 是 | string | 分类名 |

#### 2.2 获取分类列表
- URL: categories
- METHOD: GET
- PARAMS:

| 参数名 | 必须 | 类型 | 说明 |
| :--------: | :----:| :--: | :--: |
| page | 否 | int | 当前页数 |
| pageSize | 否 | int | 每页条数 |
- RETURN:
```javascript
{
  code: 200,
  data: {
    list: [
      {
        id: 1,
        name: '奶粉',
        property: '重量,品牌',
      }
    ],
    total: 1
  },
  msg: '获取分类列表成功'
}
```

#### 2.3 删除分类
- URL: categories
- METHOD: DELETE
- PARAMS:

| 参数名 | 必须 | 类型 | 说明 |
| :--------: | :----:| :--: | :--: |
| int_id | 是 | int | 分类id |

#### 2.4 更新分类
- URL: categories
- METHOD: PUT
- PARAMS:

| 参数名 | 必须 | 类型 | 说明 |
| :--------: | :----:| :--: | :--: |
| int_id | 是 | int | 分类id |
| name | 否 | string | 分类名 |
| property | 否 | string | 属性，字符串。如：'大小，颜色' |

### 3. 商品

#### 3.1 获取热门商品列表
- URL: goods
- METHOD: GET
- PARAMS:

| 参数名 | 必须 | 类型 | 说明 |
| :--------: | :----:| :--: | :--: |
| bool_hot | 是 | string | 只需传1 |

#### 3.2 获取推荐商品列表
- URL: goods
- METHOD: GET
- PARAMS:

| 参数名 | 必须 | 类型 | 说明 |
| :--------: | :----:| :--: | :--: |
| bool_recomment | 是 | string | 只需传1 |

#### 3.3 获取分类商品列表
- URL: goods
- METHOD: GET
- PARAMS:

| 参数名 | 必须 | 类型 | 说明 |
| :--------: | :----:| :--: | :--: |
| int_categoryId | 是 | string | 分类ID |

#### 3.4 获取商品列表
- URL: goods
- METHOD: GET
- PARAMS:

| 参数名 | 必须 | 类型 | 说明 |
| :--------: | :----:| :--: | :--: |
| page | 否 | string | 页数 |
| pageSize | 否 | string | 每页条数 |

#### 3.5 获取商品详情
- URL: goods
- METHOD: GET
- PARAMS:

| 参数名 | 必须 | 类型 | 说明 |
| :--------: | :----:| :--: | :--: |
| int_id | 是 | int | 商品ID |

#### 3.6 更新商品信息
- URL: goods
- METHOD: PUT
- PARAMS:

| 参数名 | 必须 | 类型 | 说明 |
| :--------: | :----:| :--: | :--: |
| int_id | 是 | int | 商品ID |
| name | 否 | int | 名称 |
| float_price | 否 | float | 价格 |
| preview | 否 | string | 预览图 |
| detail | 否 | string | 详情图 |
| property | 否 | string | 属性。传字符串，如：'300g,红色' |
| bool_hot | 否 | bool | 是否热卖 |
| bool_recomment | 否 | bool | 是否推荐 |
| int_categoryId | 否 | int | 分类ID |