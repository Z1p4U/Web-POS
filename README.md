# Web POS

## API Reference

#### Login (Post)

```https
https://g.mmsdev.site/api/v1/login
```

| Arguments | Type   | Description                  |
| :-------- | :----- | :--------------------------- |
| email     | string | **Required** admin@gmail.com |
| password  | string | **Required** asdffdsa        |

## User Profile

#### Your Profile (Get)

```https
https://g.mmsdev.site/api/v1/profile
```

#### Get User Profile (Get)

```https
https://g.mmsdev.site/api/v1/check-profile/{id}
```

#### Register (Post) - (Admin Only)

```https
https://g.mmsdev.site/api/v1/register
```

| Arguments             | Type   | Description                  |
| :-------------------- | :----- | :--------------------------- |
| name                  | sting  | **Required** Post Malone     |
| phone                 | sting  | **Nullable** 0998989898      |
| date_of_birth         | sting  | **nullable** dd/mm/yy        |
| gender                | enum   | **Required** male/female     |
| address               | sting  | **Nullable**                 |
| email                 | sting  | **Required** admin@gmail.com |
| password              | string | **Required** asdffdsa        |
| password_confirmation | string | **Required** asdffdsa        |
| role                  | enum   | **Required** admin/staff     |
| user_photo            | string | **Nullable** url()           |

#### Edit Profile (Put)

```https
https://g.mmsdev.site/api/v1/edit
```

| Arguments     | Type   | Description              |
| :------------ | :----- | :----------------------- |
| name          | sting  | **Required** Post Malone |
| phone         | sting  | **Nullable** 0998989898  |
| date_of_birth | sting  | **nullable** dd/mm/yy    |
| gender        | enum   | **Required** male/female |
| address       | sting  | **Nullable**             |
| user_photo    | string | **Nullable** url()       |

#### Password Update (Put) - (Admin Only)

```https
https://g.mmsdev.site/api/v1/password-update
```

| Arguments             | Type   | Description           |
| :-------------------- | :----- | :-------------------- |
| current_password      | sting  | **Required** asdffdsa |
| password              | string | **Required** asdffdsa |
| password_confirmation | string | **Required** asdffdsa |

#### Ban User (Post) - (Admin Only)

```https
https://g.mmsdev.site/api/v1/user/{id}/ban
```

#### Unban User (Post) - (Admin Only)

```https
https://g.mmsdev.site/api/v1/user/{id}/unban
```

#### Logout (Post)

```https
https://g.mmsdev.site/api/v1/logout
```

#### Logout from all devices(Post) - (Admin Only)

```https
https://g.mmsdev.site/api/v1/logout-all
```

#### User List (Get) - (Admin Only)

```https
https://g.mmsdev.site/api/v1/user-lists
```

#### Get Devices (Get)

```https
https://g.mmsdev.site/api/v1/devices
```

## Media

### Photo

#### Store Photo (Post)

```https
https://g.mmsdev.site/api/v1/photo
```

| Arguments | Type  | Description     |
| :-------- | :---- | :-------------- |
| photos[]  | array | **Required** [] |

#### Get Photo (Get)

```https
https://g.mmsdev.site/api/v1/photo
```

#### Show Photo (Get)

```https
https://g.mmsdev.site/api/v1/photo/{id}
```

#### Delete Photo (Del)

```https
https://g.mmsdev.site/api/v1/photo/{id}
```

#### Multiple Photo Delete (Post)

```https
https://g.mmsdev.site/api/v1/photo/multiple-delete
```

| Arguments | Type  | Description          |
| :-------- | :---- | :------------------- |
| photos    | array | **Required** [1,2,3] |

###### Note : ID must be in Array.

## Inventory

### Brand

#### Brand (Get)

```https
https://g.mmsdev.site/api/v1/brand
```

#### Single Brand (Get)

```https
https://g.mmsdev.site/api/v1/brand/{id}
```

#### Create Brand (Post)

```https
https://g.mmsdev.site/api/v1/brand
```

| Arguments   | Type   | Description               |
| :---------- | :----- | :------------------------ |
| name        | string | **Required** example name |
| company     | string | **Required** company name |
| agent       | string | **Required** agent name   |
| phone       | string | **Required** 098746553    |
| description | string | **Nullable** text         |
| photo       | string | **Nullable** example.jpeg |

#### Update Brand (Put)

```https
https://g.mmsdev.site/api/v1/brand/{id}
```

| Arguments   | Type   | Description               |
| :---------- | :----- | :------------------------ |
| name        | string | **Required** example name |
| company     | string | **Required** company name |
| agent       | string | **Required** agent name   |
| phone       | string | **Required** 098746553    |
| description | string | **Nullable** text         |
| photo       | string | **Nullable** example.jpeg |

#### Delete Brand (Delete) - (Admin Only)

```https
https://g.mmsdev.site/api/v1/brand/{id}
```

### Products

#### Products (Get)

```https
https://g.mmsdev.site/api/v1/product
```

#### Sorting by id and name

###### Asc is default. So you don't have to pass asc as a description. Just pass keyword id or name. If you want descending , pass **desc**

| Arguments | Type   | Description       |
| :-------- | :----- | :---------------- |
| id        | string | **Nullable** asc  |
| name      | string | **Nullable** desc |

#### Single Product (Get)

```https
https://g.mmsdev.site/api/v1/product/{id}
```

#### Create Product (Post)

```https
https://g.mmsdev.site/api/v1/product
```

| Arguments        | Type    | Description               |
| :--------------- | :------ | :------------------------ |
| name             | string  | **Required** example name |
| brand_id         | integer | **Required** 2            |
| actual_price     | number  | **Required** 500          |
| sale_price       | number  | **Required** 600          |
| unit             | string  | **Required** 1            |
| more_information | string  | **Nullable** text         |
| photo            | string  | **Nullable** example.jpeg |

#### Update Product (Put)

```https
https://g.mmsdev.site/api/v1/product/{id}
```

| Arguments        | Type    | Description               |
| :--------------- | :------ | :------------------------ |
| name             | string  | **Required** example name |
| brand_id         | integer | **Required** 2            |
| actual_price     | integer | **Required** 500          |
| sale_price       | integer | **Required** 600          |
| unit             | string  | **Required** 1            |
| more_information | string  | **Nullable** text         |
| photo            | string  | **Nullable** example.jpeg |

###### Note : you could update your own product

#### Delete Product (Delete) - (Admin Only)

```https
https://g.mmsdev.site/api/v1/product/{id}
```

### Stock

#### Stock (Get)

```https
https://g.mmsdev.site/api/v1/stock
```

#### Sorting by id

###### Asc is default. So you don't have to pass asc as a description. Just pass argument id .

| Arguments | Type   | Description      |
| :-------- | :----- | :--------------- |
| id        | string | **Nullable** asc |

#### Create Stock (Post)

```https
https://g.mmsdev.site/api/vi/stock
```

| Arguments  | Type    | Description     |
| :--------- | :------ | :-------------- |
| product_id | integer | **Required** 2  |
| quantity   | integer | **Required** 10 |
| more       | string  | **Nullable** 10 |

## Sale

### Sale

#### Checkout (Post)

```https
https://g.mmsdev.site/api/v1/check-out
```

| Arguments  | Type    | Description     |
| :--------- | :------ | :-------------- |
| product_id | integer | **Required** 2  |
| quantity   | integer | **Required** 10 |

#### Voucher (Get)

```https
https://g.mmsdev.site/api/v1/voucher
```

###### Note: you can search by date

| Arguments | Type | Description           |
| :-------- | :--- | :-------------------- |
| date      | date | **Search** 2022-08-09 |

#### Single Voucher (Get)

```https
https://g.mmsdev.site/api/v1/voucher/{id}
```

#### Get Voucher by Voucher Number (Post)

```https
https://g.mmsdev.site/api/v1/voucher-record-products
```

| Arguments      | Type   | Description         |
| :------------- | :----- | :------------------ |
| voucher_number | string | **Required** MjUke1 |

#### Delete Voucher (Delete) - (Admin Only)

```https
https://g.mmsdev.site/api/v1/voucher/{id}
```

### Finance

#### Sale Close (Post)

```https
https://g.mmsdev.site/api/v1/sale-close
```

#### Sale Open (Post)

```https
https://g.mmsdev.site/api/v1/sale-open
```

#### Monthly Sale (Get) (Admin Only)

```https
https://g.mmsdev.site/api/v1/monthly-sale
```

###### Note: you can search by date

| Id  | Month    | Id  | Month     |
| :-- | :------- | :-- | :-------- |
| 1   | January  | 7   | July      |
| 2   | February | 8   | August    |
| 3   | March    | 9   | September |
| 4   | April    | 10  | October   |
| 5   | May      | 11  | November  |
| 6   | June     | 12  | December  |

| Arguments | Type | Description     |
| :-------- | :--- | :-------------- |
| month     | date | **Search** 7    |
| year      | date | **Search** 2022 |

#### Yearly Sale (Get) (Admin Only)

```https
https://g.mmsdev.site/api/v1/yearly-sale
```

###### Note: you can search by date

| Arguments | Type | Description     |
| :-------- | :--- | :-------------- |
| year      | date | **Search** 2022 |

#### Custom Search By Date (Get) (Admin Only)

```https
https://g.mmsdev.site/api/v1/custom-search-by-day
```

###### Note: you can search by date

| Arguments | Type | Description           |
| :-------- | :--- | :-------------------- |
| from      | date | **Search** 2022-09-06 |
| to        | date | **Search** 2022-11-09 |

### Report

#### Overview (Get)

```https
https://g.mmsdev.site/api/v1/report/overview
```

###### Just need to pass **Arguments**.

| Arguments | Type | Description    |
| :-------- | :--- | :------------- |
| month     | date | **Nullable** - |
| year      | date | **Nullable** - |

#### Sale Report (Get)

```https
https://g.mmsdev.site/api/v1/report/sale
```

###### Just need to pass **Arguments**.

###### For sorting just need to pass **Arguments** as price. If you pass, it will show min price to max price by sorting.

| Arguments | Type | Description    |
| :-------- | :--- | :------------- |
| month     | date | **Nullable** - |
| year      | date | **Nullable** - |
| price     | date | **Nullable** - |

#### Stock Brand Report (Get)

```https
https://g.mmsdev.site/api/v1/report/brand
```

#### Stock Report (Get)

```https
https://g.mmsdev.site/api/v1/report/stock
```

###### Just need to pass **Arguments**. Also, you can search by keyword.

| Arguments    | Type | Description              |
| :----------- | :--- | :----------------------- |
| in-stock     | date | **Nullable** -           |
| low-stock    | date | **Nullable** -           |
| out-of-stock | date | **Nullable** -           |
| keyword      | date | **Nullable** productName |
