[![TicciX Copyright](https://i.imgur.com/mzb8YWb.png)](https://github.com/Ticcix/) [![TicciX Copyright](https://camo.githubusercontent.com/4e46825f5519748c0efc0f74e7227de0579ce4c6/68747470733a2f2f692e696d6775722e636f6d2f4f77594b6f56622e706e67)](https://ticcix.github.io//)

This plugin for  DLE allows you and your users to change avatars using ``` https://ui-avatars.com/ ``` api 

Use this code in userinfo.tpl so that the user can change the parameters


```css 

{ui-avatar}

```

Use this code in our other temoplates file via see user avatar.
```css 

{include file="engine/modules/ticcix/avatar/show.php"}

```

``` 
{include file="engine/modules/ticcix/avatar/show.php?userName=Ticcix&color=303030&background=eaeaea&size=100&rounded=true&format=svg"}
```

Us
| userName | It's username |
| ------ | ------ |
| color | your text color  |
| background | your background |
| size | image size |
| rounded | false or true |
| format | png or svg | |
