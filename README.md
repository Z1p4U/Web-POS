# Web POS

## API Reference

#### Login (Post)

```https
https://g.mmsdev.site/api/v1/login
```

| Arguments | Type   | Description                  |
| :-------- | :----- | :--------------------------- |
| email     | sting  | **Required** admin@gmail.com |
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

| Arguments   | Type    | Description               |
| :---------- | :------ | :------------------------ |
| name        | string  | **Required** example name |
| company     | integer | **Required** company name |
| agent       | integer | **Required** agent name   |
| phone       | integer | **Required** 098746553    |
| description | number  | **Nullable** text         |
| photo       | boolean | **Nullable** example.jpeg |

#### Update Brand (Put)

```https
https://g.mmsdev.site/api/v1/brand/{id}
```

| Arguments   | Type    | Description               |
| :---------- | :------ | :------------------------ |
| name        | string  | **Required** example name |
| company     | integer | **Required** company name |
| agent       | integer | **Required** agent name   |
| phone       | integer | **Required** 098746553    |
| description | number  | **Nullable** text         |
| photo       | boolean | **Nullable** example.jpeg |

#### Delete Brand (Delete) - (Admin Only)

```https
https://g.mmsdev.site/api/v1/brand/{id}
```

### Products

#### Products (Get)

```https
https://g.mmsdev.site/api/v1/product
```

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
| sale_price       | boolean | **Required** 600          |
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
| actual_price     | number  | **Required** 500          |
| sale_price       | boolean | **Required** 600          |
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

#### Create Stock (Post)

```https
https://g.mmsdev.site/api/vi/stock
```

| Arguments  | Type    | Description     |
| :--------- | :------ | :-------------- |
| product_id | integer | **Required** 2  |
| quantity   | integer | **Required** 10 |

## Sale

#### Voucher (Get)

```https
https://g.mmsdev.site/api/v1/voucher
```

#### Single Voucher (Get)

```https
https://g.mmsdev.site/api/v1/voucher/{id}
```

#### Create Voucher (Post)

```https
https://g.mmsdev.site/api/v1/voucher
```

| Arguments | Type    | Description               |
| :-------- | :------ | :------------------------ |
| customer  | string  | **Nullable** example name |
| phone     | integer | **Nullable** 091212212    |

<!-- #### Update Voucher (Put)

```https
https://g.mmsdev.site/api/v1/voucher/{id}
```

| Arguments      | Type    | Description               |
| :------------- | :------ | :------------------------ |
| customer       | string  | **Nullable** example name |
| phone          | integer | **Nullable** 091212212    | -->

#### Delete Voucher (Delete) - (Admin Only)

```https
https://g.mmsdev.site/api/v1/voucher/{id}
```

### Voucher Record

#### Voucher Recorded Products (Post)

```https
https://g.mmsdev.site/api/v1/voucher-record-products
```

| Arguments      | Type    | Description         |
| :------------- | :------ | :------------------ |
| voucher_number | integer | **Required** MjUke1 |

#### Create Voucher Record (Post)

```https
https://g.mmsdev.site/api/vi/voucher-record
```

| Arguments  | Type    | Description    |
| :--------- | :------ | :------------- |
| voucher_id | integer | **Required** 1 |
| product_id | integer | **Required** 1 |
| quantity   | number  | **Required** 0 |

#### Update Voucher Record (Put)

```https
https://g.mmsdev.site/api/vi/voucher-record/{id}
```

| Arguments  | Type    | Description    |
| :--------- | :------ | :------------- |
| product_id | integer | **Required** 1 |
| quantity   | number  | **Required** 0 |

#### Delete Voucher Record (Delete)

```https
https://g.mmsdev.site/api/v1/voucher-record/{id}
```

| Arguments  | Type    | Description    |
| :--------- | :------ | :------------- |
| product_id | integer | **Required** 1 |
