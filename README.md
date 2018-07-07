# Mobitel-SMS (MSMS) Library for Laravel
Mobitel Sri Lanka's Messaging Solutions aka MSMS Library for Laravel

![Web Design & Web Development Batticaloa Sri lanka](https://raw.githubusercontent.com/joeljerushan/Mobitel-SMS/master/ixeun_mobitel_msms.jpg "Web Design & Web Development Batticaloa Sri lanka")



## Messaging Solutions at Mobitel Sri Lanka
This service provides any organization with a secure method of sending and receiving bulk amounts of short messages to their group of customers or even employees.

## For Laravel
[iXeun Web Solution](https://www.ixeun.com/) made an easy Library for Laravel to send SMS using Messaging Solutions.  

### Warning ! - This is Library Not Composer Package 
We will update this Library as Composer Package as soon as possible. this approach will be easy for using too :) - don't blame me for that :D :D 

## Set-up
### Create Library Folder in app/root (laravel app)

`cd yourapp/app && mkdir Library`

### Copy or Move MobitelSMS.php to Library folder 

`mv or copy MobitelSMS.php to Library`

### Import MobitelSms Library to your Laravel Controller

```php
//import our Library
use App\Library\MobitelSms;

class RegisterController extends Controller
{
    //your controller method 
    protected function create(array $data) {

    }
}
```

### Sending SMS | Cool Part 

```php
//create object 
$sms = new MobitelSms(); 

//Make Session
$session = $sms->sessionMake(); 

//Make SMS and Send 
$send = $sms->fireSms($session, $Message, $phoneNumber);

//Get Delivery info 
$delivery = $sms->statusDelivery($session, 'YOUR MASK');

//close session
$close = $sms->sessionClose($session);
```