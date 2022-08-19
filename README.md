# EXT:extbase_enum_converter

Adds the EnumConverter into TYPO3 11.
- https://forge.typo3.org/issues/98171
- https://review.typo3.org/c/Packages/TYPO3.CMS/+/75512

> [FEATURE] Add TypeConverter for enums
> 
> With PHP 8.1 we got Enums, to use them also in our extbase actions,
> a new TypeConverter is added with this patch.
>
> The EnumConverter is automatically used if the target type is an enum.


## Description

With PHP 8.1 we got Enums to use them also in our extbase actions,
a new TypeConverter was added with this feature. `\TYPO3\CMS\Extbase\Property\TypeConverter\EnumConverter`



## Example

Given an enum like this one:

````
enum ClosedStates
{
  case hide;
  case show;
  case all;
}
````

We can now use it like this in any extbase action:


````
public function overviewAction(ClosedStates $closed = ClosedStates::hide): ResponseInterface
{
````

The URL argument can be send as `[closed]=show` and is automatically converted to an instance of `ClosedStates::show`


Impact
======

Enums can now be used as extbase action arguments.
