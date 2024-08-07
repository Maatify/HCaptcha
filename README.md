[![Current version](https://img.shields.io/packagist/v/maatify/hcaptcha)][pkg]
[![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/maatify/hcaptcha)][pkg]
[![Monthly Downloads](https://img.shields.io/packagist/dm/maatify/hcaptcha)][pkg-stats]
[![Total Downloads](https://img.shields.io/packagist/dt/maatify/hcaptcha)][pkg-stats]
[![Stars](https://img.shields.io/packagist/stars/maatify/hcaptcha)](https://github.com/maatify/HCaptcha/stargazers)

[pkg]: <https://packagist.org/packages/maatify/hcaptcha>
[pkg-stats]: <https://packagist.org/packages/maatify/hcaptcha/stats>

# Installation

```shell
composer require maatify/hcaptcha
```

# Usage

```PHP
<?php
/**
 * Created by Maatify.dev
 * User: Maatify.dev
 * Date: 2024-08-07
 * Time: 1:10 PM
 * https://www.Maatify.dev
 */
 
use Maatify\HCaptcha\HCaptchaPublisherProValidation;

require 'vendor/autoload.php';

$secret_key = '0x0000000000000000000000000000000000000000';

$hCaptcha = HCaptchaPublisherProValidation::getInstance($secret_key);

// ===== get result in array format
$result = $hCaptcha->getResponse();

// ====== get bool of validation 
$result = $hCaptcha->isSuccess();

// ====== using maatify json on error response with json code with die and if success there is no error
$hCaptcha->jsonErrors();
```

### examples
#### getResponse();
>##### Success Example
>     Array
>     (
>       [success] => 1
>       [challenge_ts] => 2024-08-07T10:09:36.000000Z
>       [hostname] => localhost
>       [credit] =>
>     )
>
>##### Error Example
>     Array
>       (
>           [success] =>
>           [error-codes] => Array
>               (
>                   [0] => missing-input-response
>                   [1] => missing-input-secret
>               )
>       )


#### isSuccess();
>return true || false


#### jsonErrors();
>##### Error Example
> 
>   Header 400 
> 
>   Body:
> 
> - on validation error
> 
>```json
>   {
>       "success": false,
>       "response": 4000,
>       "var": "h-captcha-response",
>       "description": "INVALID H-captcha-response",
>       "more_info": "{\"success\":false,\"error-codes\":[\"missing-input-response\",\"missing-input-secret\"]}",
>       "error_details": ""
>   }
>```
> 
> - on missing or empty `$_POST['h-captcha-response']`
> 
>```json
>   {
>       "success": false,
>       "response": 1000,
>       "var": "h-captcha-response",
>       "description": "MISSING h-captcha-response",
>       "more_info": "",
>       "error_details": ""
>   }
>```


### Create From in HTML Code
```html
<form action="process.php" method="POST">
    <form method="POST">
        <!-- Your other form fields -->
        <div class="h-captcha" data-sitekey="__YOUR_SITE_KEY__" data-theme="dark" data-hl="ar"></div>
        <input type="submit" value="Submit">
    </form>

    <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
```