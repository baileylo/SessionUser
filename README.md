# SessionUser

An easy way to inject the authenticated User into your Controllers.

## Installation

### Step 1: Install the package


Add this line to your composer.json

```
"baileylo/session-user": "1.0.0"
```

Or, use the commandline:

```
composer require baileylo/session-user
```

### Step 2: Register the Service Provider(Laravel Specific)

Edit your `app/config/app.php` file and add this line to the providers array:

```
'Portico\SessionUser\LaravelSessionUserProvider'
```

### Step 3: Update your User Object

Add the following interface to your User model/entity,

```
\Portico\SessionUser\SessionUser
```

So your class may now look like this

```
<?php

use Portico\SessionUser\SessionUser;

class User extends Eloquent Implements SessionUser
```

## Usage

In controllers where all functions require authentication you can update the constructor to pass in the authenticated user.

```
<?php

use Portico\SessionUser\SessionUser;

class MyController {
	protected $user;
	public function __construct(SessionUser $user)
	{
		$this->user = $user;
	}
}
```