# wordpress-frontend-helper
This project aims to be an helping hand for frontend WordPress developers. It now includes just one main functionality, 
but I will expand it with more. Any idea/feedback/request is appreciated!
Here is a brief recap of what this plugin can do, for a better detailed explanation please browse the documentation here: 
https://github.com/riccardooliva91/wordpress-frontend-helper/wiki

## Managing assets efficiently
This plugin wraps the default WordPress methods which enqueue/dequeue/register/deregister your scripts and styles, adding 
new handy filters you can hook to, which name is declared dynamically. You can get an instance of the helper by applying 
the `wpfh/get_assets_manager` filter:

```php
$assets_manager = apply_filters( 'wpfh/get_assets_manager' , '' );
```

With the result object, you can start managing your assets. here is a list of methods you can use and the resulting filter
names.

| Wpfh method         | WP method              | Applied filters                                              |
| ------------------- | ---------------------- | ------------------------------------------------------------ |
| `enqueue_script`    | `wp_enqueue_script`    | `wpfh/on_script_enqueue`, `wpfh/on_SCRIPTNAME_enqueue`       |
| `enqueue_style`     | `wp_enqueue_style`     | `wpfh/on_style_enqueue`, `wpfh/on_STYLENAME_enqueue`         |
| `register_script`   | `wp_register_script`   | `wpfh/on_script_register`, `wpfh/on_SCRIPTNAME_enqueue`      |
| `register_style`    | `wp_register_style`    | `wpfh/on_style_register`, `wpfh/on_STYLENAME_register`       |
| `dequeue_script`    | `wp_dequeue_script`    | `wpfh/on_script_dequeue`, `wpfh/on_SCRIPTNAME_dequeue`       |
| `dequeue_style`     | `wp_dequeue_style`     | `wpfh/on_style_dequeue`, `wpfh/on_STYLENAME_dequeue`         |
| `deregister_script` | `wp_deregister_script` | `wpfh/on_script_deregister`, `wpfh/on_SCRIPTNAME_deregister` |
| `deregister_style`  | `wp_deregister_style`  | `wpfh/on_style_deregister`, `wpfh/on_STYLENAME_deregister`   |

Each `Wpfh` method accepts three arguments:
* `array $args`: the arguments that will be passed to the corresponding wp method;
* `bool|Callable $condition`: _(optional)_ a `true/false` value of a closure that will be evaluated
* `array $condition_args`: _(optional)_ array of arguments that will be passed to the closure, if required.

An example would be:

```php
$wpfh->enqueue_style( [ 'bootstrap', '/path/to/boostrap.css' ], is_page_template( 'home' ) );
```

Or, a more complex one:

```php
$condition = function ( string $template_one, string $template_two ) {
    return is_page_template( $template_one ) || is_page_template( $template_two );
};
$wpfh->enqueue_style( [ 'bootstrap', '/path/to/boostrap.css' ], $condition, [ 'home', 'blog' ] );
$wpfh->enqueue_script( [ 'jquery', '/path/to/jquery.css' ], $condition, [ 'who-am-i', 'contacts' ] );
```

Of course these are simple examples but this kind of helpers can save you a lot of repetitions, especially if you are 
trying to optimize every page of your website. Other than the examples above, you can also *save predefined conditions*
which you can apply over and over simply by calling them. For example:

```php
$wpfh->save_condition( 'a_condition_saved_before', true ); // Can also register custom Callables
$wpfh->enqueue_script([ 'vue-component', '/path/to/vuecomponent.js' ], $wpfh->apply_condition( 'a_condition_saved_before' ) );

// Meanwhile, somewhere else (or in the same file, you choose):
add_filter( 'wpfh/on_vue-component_enqueue', function() {
    $wpfh = apply_filters( 'wpfh/get_assets_manager' , '' );
    $wpfh->enqueue_script([ 'vue', '/path/to/vue.js' ]);
}, 9 ); // Priority 9 is here to ensure that Vue is enqueued BEFORE its component
```

## How can this plugin help?
This approach aims to slim the files you use to enqueue your scripts and styles. 
Given a set of common conditions and a set of callbacks which will register the dependencies of your components when 
the enqueue/register occurs, the repetitions in your code and the inevitable logic you are forced to type with a more 
"canonical" approach should be fairly reduced. You can focus more on importing the functionality itself rather than 
preparing the necessary dependencies first. Also, with this approach you can, of course, manage more complicated 
scenarios, such as dequeue/deregister conflicting scripts/styles and so on.
For more information please brows the documentation: https://github.com/riccardooliva91/wordpress-frontend-helper/wiki