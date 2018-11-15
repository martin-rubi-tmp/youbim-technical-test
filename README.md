# Youbim test

This exercise is a technical test for a PHP position in Youbim.

## Integrate into an app

In the app composer add

```json
"require": {
    ...
    "martin-rubi-tmp/youbim-technical-test": "dev-master",
    ...
},

```

### Calling the CreateUserEndPoint

From the controller in the application use the CreateUserEndPoint.

```php
$action = new \Youbim\API\CreateUserEndPoint();

$response = $action->evaluate( $request->get_params() );

$this->respondJson( $response );
```

The parameters passed to CreateUserEndPoint are expected to be an associative array with at least the attribute `user`:

```
[
    "user" => [
        "name" => "Lisa", 
        "last_name" => "Simpson", 
        "email" => "lisa.simpson@thesimpsons.org", 
        "phone_number" => "555 123"
    ]
];
```

### Calling the ListUsersEndPoint

From the controller in the application use the ListUsersEndPoint.

```php
$action = new \Youbim\API\ListUsersEndPoint();

$response = $action->evaluate();

$this->respondJson( $response );
```

## Development

Clone the repository

```
git clone git@github.com:martin-rubi-tmp/youbim-technical-test.git
```

Install dependencies

```
cd youbim-technical-test
composer install
```

## Run the tests

```
composer test
```