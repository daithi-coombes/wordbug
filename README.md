wordbug
=======

Helps debuggin wordpress options by display formatted search results of the wp_options table


Install normally in wordpress, then navigate to:
tools->wordbug

Enter in the keyword and the current value will displayed using php's print_r function within htmls <pre> tags
```php
print "<pre>";
print_r( $options_results );
print "</pre>";
```