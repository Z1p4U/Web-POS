# Web POS

## API Reference

#### Login (Post)

```http
https://i.mmsdev.site/api/v1/login
```

| Arguments | Type   | Description                  |
| :-------- | :----- | :--------------------------- |
| email     | sting  | **Required** admin@gmail.com |
| password  | string | **Required** asdffdsa        |

## User Profile

#### User Profile (Get)

```http
https://i.mmsdev.site/api/v1/user-profile
```

#### Register (Post) - (Admin Only)

```http
https://i.mmsdev.site/api/v1/register
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

```http
https://i.mmsdev.site/api/v1/edit
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

```http
https://i.mmsdev.site/api/v1/password-update
```

| Arguments             | Type   | Description           |
| :-------------------- | :----- | :-------------------- |
| current_password      | sting  | **Required** asdffdsa |
| password              | string | **Required** asdffdsa |
| password_confirmation | string | **Required** asdffdsa |

#### Logout (Post)

```http
https://i.mmsdev.site/api/v1/logout
```

#### Logout from all devices(Post) - (Admin Only)

```http
https://i.mmsdev.site/api/v1/logout-all
```

#### User List (Get) - (Admin Only)

```http
https://i.mmsdev.site/api/v1/user-lists
```

#### Get Devices (Get)

```http
https://i.mmsdev.site/api/v1/devices
```

## Media

### Photo

#### Store Photo (Post)

```http
https://i.mmsdev.site/api/v1/photo
```

| Arguments | Type  | Description     |
| :-------- | :---- | :-------------- |
| photos    | array | **Required** [] |

#### Get Photo (Get)

```http
https://i.mmsdev.site/api/v1/photo
```

#### Show Photo (Get)

```http
https://i.mmsdev.site/api/v1/photo/{id}
```

#### Delete Photo (Del)

```http
https://i.mmsdev.site/api/v1/photo/{id}
```

#### Multiple Photo Delete (Post)

```http
https://i.mmsdev.site/api/v1/photo/multiple-delete
```

| Arguments | Type  | Description          |
| :-------- | :---- | :------------------- |
| photos    | array | **Required** [1,2,3] |

###### Note : ID must be in Array.

## Inventory

### Brand

#### Brand (Get)

```http
https://i.mmsdev.site/api/v1/brand
```

#### Single Brand (Get)

```http
https://i.mmsdev.site/api/v1/brand/{id}
```

#### Create Brand (Post)

```http
https://i.mmsdev.site/api/v1/brand
```

| Arguments   | Type    | Description               |
| :---------- | :------ | :------------------------ |
| name        | string  | **Required** example name |
| company     | integer | **Required** company name |
| information | number  | **Nullable** text         |
| photo       | boolean | **Nullable** example.jpeg |

#### Update Brand (Put)

```http
https://i.mmsdev.site/api/v1/brand/{id}
```

| Arguments   | Type    | Description               |
| :---------- | :------ | :------------------------ |
| name        | string  | **Required** example name |
| company     | integer | **Required** company name |
| information | number  | **Nullable** text         |
| photo       | boolean | **Nullable** example.jpeg |

#### Delete Brand (Delete) - (Admin Only)

```http
https://i.mmsdev.site/api/v1/brand/{id}
```

### Products

#### Products (Get)

```http
https://i.mmsdev.site/api/v1/product
```

#### Single Product (Get)

```http
https://i.mmsdev.site/api/v1/product/{id}
```

#### Create Product (Post)

```http
https://i.mmsdev.site/api/v1/product
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

```http
https://i.mmsdev.site/api/v1/product/{id}
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

```http
https://i.mmsdev.site/api/v1/product/{id}
```

### Stock

#### Stock (Get)

```http
https://i.mmsdev.site/api/v1/stock
```

#### Create Stock (Post)

```http
https://i.mmsdev.site/api/vi/stock
```

| Arguments  | Type    | Description     |
| :--------- | :------ | :-------------- |
| product_id | integer | **Required** 2  |
| quantity   | integer | **Required** 10 |

## Sale

#### Voucher (Get)

```http
https://i.mmsdev.site/api/v1/voucher
```

#### Single Voucher (Get)

```http
https://i.mmsdev.site/api/v1/voucher/{id}
```

#### Create Voucher (Post)

```http
https://i.mmsdev.site/api/v1/voucher
```

| Arguments | Type    | Description               |
| :-------- | :------ | :------------------------ |
| customer  | string  | **Nullable** example name |
| phone     | integer | **Nullable** 091212212    |

<!-- #### Update Voucher (Put)

```http
https://i.mmsdev.site/api/v1/voucher/{id}
```

| Arguments      | Type    | Description               |
| :------------- | :------ | :------------------------ |
| customer       | string  | **Nullable** example name |
| phone          | integer | **Nullable** 091212212    | -->

#### Delete Voucher (Delete) - (Admin Only)

```http
https://i.mmsdev.site/api/v1/voucher/{id}
```

### Voucher Record

#### Voucher Recorded Products (Post)

```http
https://i.mmsdev.site/api/v1/voucher-record-products
```

| Arguments      | Type    | Description         |
| :------------- | :------ | :------------------ |
| voucher_number | integer | **Required** MjUke1 |

#### Create Voucher Record (Post)

```http
https://i.mmsdev.site/api/vi/voucher-record
```

| Arguments  | Type    | Description    |
| :--------- | :------ | :------------- |
| voucher_id | integer | **Required** 1 |
| product_id | integer | **Required** 1 |
| quantity   | number  | **Required** 0 |

#### Update Voucher Record (Put)

```http
https://i.mmsdev.site/api/vi/voucher-record/{id}
```

| Arguments  | Type    | Description    |
| :--------- | :------ | :------------- |
| product_id | integer | **Required** 1 |
| quantity   | number  | **Required** 0 |

#### Delete Voucher Record (Delete)

```http
https://i.mmsdev.site/api/v1/voucher-record/{id}
```

| Arguments  | Type    | Description    |
| :--------- | :------ | :------------- |
| product_id | integer | **Required** 1 |
