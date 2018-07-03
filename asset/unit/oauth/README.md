Unit of OAuth
===

## How to use

```
//  Instantiate OAuth object.
$oauth = Unit::Instantiate('OAuth');

//  How to use of Google OAuth. Only this.
if( $oauth->Google()->isLogin() ){
    $user_info = $oauth->Google()->UserInfo();
}else{
    $user_info = $oauth->Google()->Login();
}
```
