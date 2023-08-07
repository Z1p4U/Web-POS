# Web POS

## API Reference

#### Login (Post)

```http
  http://127.0.0.1:8000/api/v1/login
```

| Arguments | Type   | Description                  |
| :-------- | :----- | :--------------------------- |
| email     | sting  | **Required** admin@gmail.com |
| password  | string | **Required** asdffdsa        |

## User Profile

#### Register (Post)

```http
  http://127.0.0.1:8000/api/v1/register
```

| Arguments             | Type   | Description                  |
| :-------------------- | :----- | :--------------------------- |
| name                  | sting  | **Required** Post Malone     |
| email                 | sting  | **Required** admin@gmail.com |
| password              | string | **Required** asdffdsa        |
| password_confirmation | string | **Required** asdffdsa        |
| role                  | enum   | **Required** admin/staff     |
| user_photo            | string | **Nullable** url()           |

#### Password Update (Put)

```http
  http://127.0.0.1:8000/api/v1/password-update
```

| Arguments             | Type   | Description           |
| :-------------------- | :----- | :-------------------- |
| current_password      | sting  | **Required** asdffdsa |
| password              | string | **Required** asdffdsa |
| password_confirmation | string | **Required** asdffdsa |

#### Logout (Post)

```http
  http://127.0.0.1:8000/api/v1/logout
```

#### Logout from all devices(Post)

```http
  http://127.0.0.1:8000/api/v1/logout-all
```

#### Get Devices (Get)

```http
  http://127.0.0.1:8000/api/v1/devices
```

## Inventory

#### Products (Get)

```http
  http://127.0.0.1:8000/api/v1/product
```

#### Single Product (Get)

```http
  http://127.0.0.1:8000/api/v1/product/{id}
```

#### Create Product (Post)

```http
  http://127.0.0.1:8000/api/v1/product
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
  http://127.0.0.1:8000/api/v1/product/{id}
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

#### Delete Product (Delete)

```http
  http://127.0.0.1:8000/api/v1/product/{id}
```

### Stock

#### Stock (Get)

```http
  http://127.0.0.1:8000/api/v1/stock
```

#### Create Stock (Post)

```http
  http://127.0.0.1:8000/api/vi/stock
```

### Brand

#### Brand (Get)

```http
  http://127.0.0.1:8000/api/v1/brand
```

#### Single Brand (Get)

```http
  http://127.0.0.1:8000/api/v1/brand/{id}
```

#### Create Brand (Post)

```http
  http://127.0.0.1:8000/api/v1/brand
```

| Arguments   | Type    | Description               |
| :---------- | :------ | :------------------------ |
| name        | string  | **Required** example name |
| company     | integer | **Required** company name |
| information | number  | **Nullable** text         |
| photo       | boolean | **Nullable** example.jpeg |

#### Update Brand (Put)

```http
  http://127.0.0.1:8000/api/v1/brand/{id}
```

| Arguments   | Type    | Description               |
| :---------- | :------ | :------------------------ |
| name        | string  | **Required** example name |
| company     | integer | **Required** company name |
| information | number  | **Nullable** text         |
| photo       | boolean | **Nullable** example.jpeg |

#### Delete Brand (Delete)

```http
  http://127.0.0.1:8000/api/v1/brand/{id}
```
