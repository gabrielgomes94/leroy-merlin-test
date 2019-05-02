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