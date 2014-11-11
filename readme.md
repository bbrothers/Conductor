## Conductor

This package is a simple implementation of the Command Pattern in PHP. 
It began as a fork of Jesse O'Brien's [CommandBus package](https://github.com/JesseObrien/CommandBus) and was heavily inspired by Jeffery Way's [Commander](https://github.com/laracasts/Commander), as well as Shawn McCool's [Laracon 2014 talk](http://www.youtube.com/watch?v=2_380DKU93U).

It is still under heavy development and not ready for production use. Please feel free to submit issues and critique code.

#####Todo List:
 - Improve test code coverage
 - Include easy configuration options (YAML?)

---

Conductor uses name inflection to pass a request to the appropriate handler. For example, `FooRequest` would be passed to `FooHandler` and return an instance of `FooResponse`.

####Basic Usage:  
Conductor requires an IoC container to handle resolving classes. It was written with Laravel's IoC Container mind, but Pimple or any other container will work so long as the `Resolver` can retrieve the class with it's dependancies.

To register the bus, you might use something like this:
```php
$IoCContainer['conductor'] = new \Conductor\ExecutionBus(
	new \Foo\Resolver($IoCContainer),
	new \Conductor\Inflector
);
```
Note: For Laravel, I've included a service provider to handle the registration. 

In your controller, instantiate a new request DTO with whatever data you need and pass it to the ExecutionBus to execute.
```php
$request = new \Conductor\FooRequest($this->request->all());
$response = $IoCContainer['conductor']->execute($request);
return $IoCContainer['view']->make($response->getData()); // Pseudo code for rendering a view
```

The Handler class would then do any necessary logic, such as querying the database/repository and return a response.
```php
public function handle(Request $request)
{
    $user = User::find($request->userId);

    return FooResponse::create($user);
}
```

By default, Conductor looks for `FooValidator`. If the class exists, it resolves it from the IoC Container and runs a `validate()` method before passing the request on to the handler. For Laravel, an abstract `RequestValidator` class has been included.

An example implementation might look like this:
```php
namespace Acme\Accounts;

use Conductor\Laravel\RequestValidator;

class LoginUserValidator extends RequestValidator {

	public $rules = [
		'email'      => 'required|email',
		'password'   => 'required|min:6'
	];

	public function extractData($request)
	{
	    return [
			'email'      => $request->email,
			'password'   => $request->password
		];
		/** 
		 * This could be reduced by implementing
		 * Laravel's ArrayableInterface on the `LoginUserRequest`object.
		 *
		 * return $request->toArray();
		 */
	}
}
```

While the `Validation` decorator runs by default and is simply skipped if it doesn't exist, any other decorators can easily be added by calling the `decorate` method on the execution bus before calling `execute`:
```php
$request = new \Conductor\FooRequest($this->request->all());
$response = $IoCContainer['conductor']->decorate('Acme\Logger')->execute($request);
return $IoCContainer['view']->make($response->getData());
```

Conductor will then resolve the decorated class (in this case `Acme\Logger`) out of the IoC Container. If the decorated class implements `Conductor` the `execute` method will be called, otherwise a `ConductorNotImplementedException` exception will be thrown.
