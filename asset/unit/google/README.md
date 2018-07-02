Unit of google is Interface of google service.
===

## How to use of Google OAuth

```
//  Instantiate google object.
if(!$google = Unit::Instantiate('Google') ){
    //  Failed.
    return;
}

//  Execute OAuth.
$user_info = $google->OAuth('http://localhost/callback_url');
D($user_info);
```

## How to use of Google Translation.

```
//  Instantiate google object.
if(!$google = Unit::Instantiate('Google') ){
    //  Failed.
    return;
}

//  Execute OAuth.
$to   = 'ja';
$from = 'en';
$translation = $google->Translate('This is an apple.', $to, $from);
D($translation);
```
