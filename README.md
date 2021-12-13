# Technical Documentation

## Basic Requirement
- Laravel ^8.x - [laravel.com/docs/8.x](https://laravel.com/docs/8.x)
- PHP ^8.x - [php.net/download.php](https://www.php.net/downloads.php)
- MySQL ^5.7.x (This is what per used on local environment and working, may not require specific version)
- Composer ^2.x [getcomposer.org/download](https://getcomposer.org/download/)

PWA-BACKEND for Kalsym
======================

## Project Details
- Project : pwa-backend
- Version : v1.0
- Author : Nazrul Hanif 
- Date Created : 2021/12/13

# install package-dependency using composer
$ composer install 
or
$ composer update

# create copy of .env
$ cp .env.example .env

# create laravel key
$ php artisan key:generate

# laravel migrate
$ php artisan migrate

## Project Contributor
- Developer 1 : [Nazrul Hanif](https://github.com/lordnaz)

API SPEC SECTION (MerchantTrade Product)
========================================

# Authenticate
Use `https://baseurl/api/auth/login` to get authentication token
```
Endpoint : /api/auth/login
Method : POST
Body : None
```

# Get Product Category 
Use `https://baseurl/api/category` to get all category list
```
Endpoint : /api/category
Method : POST
Body : {"auth_token": token.from.authenticate}
```

# Get Countries 
Use `https://baseurl/api/countries` to get all country list
```
Endpoint : /api/countries
Method : POST
Body : {"auth_token": token.from.authenticate}
```

# Get Product Owners 
Use `https://baseurl/api/product_owners` to get product owners list
```
Endpoint : /api/product_owners
Method : POST
Body : { 
            "auth_token": token.from.authenticate,
            "country_code": country_code,
            "category_id": category_id
        }
```

# Get Products 
Use `https://baseurl/api/get_products` to get product list
```
Endpoint : /api/get_products
Method : POST
Body : {
            "auth_token": token.from.authenticate,
            "country_code": countrycode,
            "category_id": subcat_id,
            "product_owner_code": provider_code,
            "msisdn": phoneNo
        }
```


API SPEC SECTION (MMPAY OTP Flow)
========================================

# Authenticate
Use `https://baseurl/api/get_token` to get authentication token
```
Endpoint : /api/get_token
Method : POST
HEADER : { "KEY": PUB_KEY }
Body : {"pass": PRIV_KEY}
```

# Get OTP
Use `https://baseurl/api/get_otp` to get OTP via mobile
```
Endpoint : /api/get_otp
Method : POST
HEADER : { "KEY": PUB_KEY }
Body : {
    "Token" : token,
    "MobileNumber" : PhoneNum,
    "Amount" : 10,
    "TransactionNumber" : "TEST123"
}
```

# Validate OTP
Use `https://baseurl/api/validate_otp` to validate the OTP
```
Endpoint : /api/validate_otp
Method : POST
HEADER : { "KEY": PUB_KEY }
Body : {
    "Token" : token,
    "OTPReferenceNumber" : OTPRefNo,
    "OTP" : OTP
}
```

# Check Payment Status
Use `https://baseurl/api/pay_status` to check transaction status
```
Endpoint : /api/pay_status
Method : POST
HEADER : { "KEY": PUB_KEY }
Body : {
    "Token" : token,
    "TransactionNumber" : TrxNo
}
```

# Resend OTP
Use `https://baseurl/api/pay_status` to check transaction status
```
Endpoint : /api/pay_status
Method : POST
HEADER : { "KEY": PUB_KEY }
Body : {
    "Token" : token,
    "OTPReferenceNumber" : OTPRefNo
}
```

## Support 

For Support & Inquiry kindly contact me at:-

- Click [Nazrul Hanif](https://github.com/lordnaz) to go to developer profile.
- Or email me at nazrul.workspace@gmail.com || nazrul@kalsym.com

