# An official laravel packages for Leadingdots community

There is a list of laravel modules to make faster development process for our developers. Please follow the instruction to use these modules.

### Features:

- Custom Email templates via database using laravel default markdown mail functionality.
- Create tokens to make templates dynamic for every email needs in your application.
- Change templates at anytime you want.
- Dont bother for artisan make:mail commands and write lots of codes for every template.

## How to install package

Require this package in your composer.json and update composer. This will download the package.

    composer require leadingdots/coderepo

After updating composer, add the ServiceProvider to the providers array in config/app.php

    Leadingdots\CustomEmail\CustomEmailServiceProvider::class,

You can optionally use the facade for shorter code. Add this to your facades:

    'DynamicMail' => 'Leadingdots\CustomEmail\Mail\DynamicMail',

### Lumen:

After updating composer add the following lines to register provider in `bootstrap/app.php`

  ```
  $app->register(\Leadingdots\CustomEmail\CustomEmailServiceProvider::class);
  ```

### Blade Files
The defaults blade files are set in `resources/views`. Copy this file to your own views directory to modify the page html. You can publish the blade files, css and js using this command:

    php artisan vendor:publish --provider="Leadingdots\CustomEmail\CustomEmailServiceProvider"

After publishing you can get the blade files at /resources/views/leadingdots/customemail location to modify these also you can see css and js files at /public/leadingdots/customemail location

Now you just need to run migration command for our email template tables generating. Run the command below-

    php artisan migrate
    
Now you can set your routes prefix and middlewares in /config/coderepoldots.php file

## Using

You can use DynamicMail class into your controllers to send emails like example given below

    //namespace
    use DynamicMail;

    $tokens = [
          'token1' => 'Token 1 value',
          'token2' => 'Token 2 value'
    ];
    $attachments = [
            [
            'data' => 'file url here',
            'name' => 'file name here'
            ],
            [
            'data' => 'file url here',
            'name' => 'file name here'
            ]
        ]
    \Mail::to(<reciever-email-id>)->send(new DynamicMail($tokens, <template-type>, $attachments));

### Creating Tokens
 
 Tokens are key for our dynamic data in our mails like user name, contact info etc. After fully installation of this package, to create tokens you need to go to the url below and from there you can create no. of tokens needed.

    <your-project-url>/<prefix-set-in-config>/token

### Creating Templates

 After fully installation of this package, to create templates you need to go to the url below and from there you can create no. of templates needed.

    <your-project-url>/<prefix-set-in-config>/template

### Privacy

This CODEREPO package is for use of Leadingdots internal teams and not an open source repository. You can contact to Leadingdots Solution Pvt. Ltd. before using this package to get approval.
