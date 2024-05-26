## Installation Guide

````
composer install
php artisan migrate
php artisan serve
php artisan queue:work
````




## API Reference

#### Sync Product Data

```
  GET /api/sync
```

Success Response

```
{
"message": "Products have been synchronized."
}
```


#### Register User

```
  POST /api/register
```

Request body

```
{
"name":"name",
"email":"mail@mail.com",
"password":"password"
}
```

Success Response

```
{
    {"token":"2|TDXwYy7FTJp7KEQpyGvRXvyNT5vMHGpAjS6l5wFv"}
}
```

#### Get Product Data

```
  GET /api/products
```
Headers

```
  Authorization : token 
```

Success Response

```
{
        "id": 1,
        "name": "Hoodie",
        "price": 42,
        "image_filename": "product_images/QH3DDWSCneoODxgrj0TLkCqACGMDQ6MGOyWv0rGp.jpg",
        "description": "<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>\n",
        "created_at": "2024-05-24T17:40:29.000000Z",
        "updated_at": "2024-05-26T17:16:07.000000Z"
    }
```
