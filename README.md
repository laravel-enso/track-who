# TrackWho
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/c2848e5734e44faab61fb3391a91a11e)](https://www.codacy.com/app/laravel-enso/TrackWho?utm_source=github.com&utm_medium=referral&utm_content=laravel-enso/TrackWho&utm_campaign=badger)
[![StyleCI](https://styleci.io/repos/85499255/shield?branch=master)](https://styleci.io/repos/85499255)
[![Total Downloads](https://poser.pugx.org/laravel-enso/trackwho/downloads)](https://packagist.org/packages/laravel-enso/trackwho)
[![Latest Stable Version](https://poser.pugx.org/laravel-enso/trackwho/version)](https://packagist.org/packages/laravel-enso/trackwho)

Trait for tracking created_by, updated_by and deleted_by.

### Use

In the Model where you want to track the creating, updating or deleting user add

```
use CreatedBy, UpdatedBy, DeletedBy
```

Make sure that the model's table has the `created_by` | `updated_by` | `deleted_by` field(s)

The traits will also create relationships with the User model so you can call `$model->created_by`

### Note

The laravel-enso/core package comes with this library included.