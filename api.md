### Authentication

To use the API, the user must pass the valid API_KEY through the `Authorization` header.
The API_KEY is setted on .env file

#### Example:
```
curl -X GET \
  http://localhost:8000/api/products \
  -H 'Authorization: p2lbgWkFrykA4QyUmpHihzmc5BNzIABq'
```

### Import spreadsheet:

#### Endpoint
POST http://localhost:8000/api/products

#### Payload:
```
file_url: <Direct link to a spreadsheet file>
```

#### Example
```
curl -X POST \
  http://localhost:8000/api/products \
  -H 'authorization: p2lbgWkFrykA4QyUmpHihzmc5BNzIABq' \
  -H 'cache-control: no-cache' \
  -H 'content-type: application/x-www-form-urlencoded' \
  -d file_url=https%3A%2F%2Fs3-sa-east-1.amazonaws.com%2Fteste-leroy-merlin%2Fproducts_teste_webdev_leroy.xlsx
```

#### Response
```
"Spreadsheet is being imported. Check its status on:http://localhost:8000/api/products/import_status/{job_status_id}"
```

### Check Job Status

#### Endpoint
GET http://localhost:8000/api/products/import_status/{job_status_id}

#### Response

##### If the import was successful
```
"Spreadsheet was successfully imported!"
status code: 200
```

##### If the import is still being processed
```
Spreadsheet still being imported.
status code: 200
```

##### If the import wasnt successful
```
{
    "message": "Spreadsheet could not be imported.",
    "errors ": {
        "message": "SQLSTATE[HY000]: General error: 1366 Incorrect decimal value: 'text' for column 'price' at row 1 (SQL: insert into `products` (`im`, `name`, `free_shipping`, `description`, `price`, `category`, `updated_at`, `created_at`) values (1009, Broca Z, 0, Broca simples, text, 123123, 2019-05-06 22:49:28, 2019-05-06 22:49:28))"
    },
    "attempts": 3
}

status code: 500
```
### List products

```
curl -X GET \
  http://localhost:8000/api/products \
  -H 'authorization: p2lbgWkFrykA4QyUmpHihzmc5BNzIABq' \
  -H 'cache-control: no-cache'
```

#### Response
- List of products. See `Show product` response


### Show product
```
curl -X GET \
  http://localhost:8000/api/products/4 \
  -H 'authorization: p2lbgWkFrykA4QyUmpHihzmc5BNzIABq' \
  -H 'cache-control: no-cache
```

#### Response
```
{
  "id": 5,
  "lm": "1003",
  "name": "Chave de Fenda X",
  "free_shipping": 0,
  "description": "Chave de fenda simples",
  "price": "20.00",
  "category": "123123",
  "created_at": "2019-05-03 20:35:27",
  "updated_at": "2019-05-03 20:35:27"
}
```

### Update product
#### Payload:
```
{
  lm: '1234',
  name 'product name',
  free_shipping: 1,
  description: 'text',
  price: 100.0,
  category: '12342'
}
```

```
curl -X PUT \
  http://localhost:8000/api/products/4 \
  -H 'authorization: p2lbgWkFrykA4QyUmpHihzmc5BNzIABq' \
  -H 'cache-control: no-cache' \
  -d name=Nome%20atualizado
```

#### Response
```
{
  "id": 4,
  "lm": "1234",
  "name": "product name",
  "free_shipping": "1",
  "description": "text",
  "price": "100.00",
  "category": "12342",
  "created_at": "2019-05-03 20:35:27",
  "updated_at": "2019-05-06 16:18:34"
}
```

### Delete product
```
curl -X DELETE \
  http://localhost:8000/api/products/6 \
  -H 'authorization: p2lbgWkFrykA4QyUmpHihzmc5BNzIABq' \
  -H 'cache-control: no-cache'
```

#### Response
No content
