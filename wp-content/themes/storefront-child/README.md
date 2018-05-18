#Functional guide

**font_size**
```
@include font-size($variable)

Ex: @include font-size(12) => #variable is a number of font-size on psd file
```

**font_rubik - Rubik**
```
@include font_rubik($weight, $style: medium) => $style is an optional of font rubik medium
Ex: @include font_rubik($font_rubik_normal) => This function will genarate the font-family and font-weight

*Font Mapping*
Font-weight => Font-family
$font_rubik_normal => Rubik light
$font_rubik_bold => Rubik Bold
$font_rubik_black => Rubik Black
$font_rubik_medium => Rubik Medium => EX: @include font_rubik($font_rubik_medium)
$font_rubik_medium, italic => Rubik Medium Italic => EX: @include font_rubik($font_rubik_medium, italic)
```

**font_open_sans**

```
@inlcude font_open_sans($font-weight)

Ex: @include font_open_sans(bold) => This func will genarate font open sans
```

## Template helpers function

**Images in theme assets**

```php
<?php child_theme_assets('assets/images/logo.jpg');?>
```

## Reset column for mobile
```
 Note: - block include the items must have class "bf-row".
       - the items inside block must have class "bf-items"
```