# Unique With Scope (Laravel/Lumen Validation Rules)

A Laravel and Lumen validation package that introduces scoped rules like `unique_with_scope`, `exists_with_scope`, and `in_with_scope`. These rules give you more precise and contextual validation options for Eloquent models.

## 🚀 Installation

```bash
composer require your-vendor/unique-with-scope
```

## 🛠️ Setup

### Laravel

No additional setup needed. The package is auto-discovered.

### Lumen

Register the service provider in `bootstrap/app.php`:

```php
$app->register(\YourVendor\UniqueWithScope\UniqueWithScopeRuleServiceProvider::class);
```

If not already enabled:

```php
$app->withFacades();
```

## ✅ Available Rules

### `unique_with_scope`

Validates that a given value is unique within a defined scope (e.g. `company_id`, `team_id`, etc.).

```php
'email' => [
    'required',
    'unique_with_scope:App\\Models\\User,email,company_id'
]
```

- **Format**: `unique_with_scope:ModelClass,column,scope1,scope2,...`
- **Example**: Ensure the email is unique **within a company**.

### `exists_with_scope`

Validates that a given value exists **within** a defined scope in a table.

```php
'product_id' => [
    'required',
    'exists_with_scope:App\\Models\\Product,id,merchant_id'
]
```

- **Format**: `exists_with_scope:ModelClass,column,scope1,scope2,...`
- **Example**: Ensure the product belongs to a specific merchant.

### `in_with_scope`

Validates that a value is in a set defined by scoped model values.

```php
'channel' => [
    'required',
    'in_with_scope:App\\Models\\Channel,name,region'
]
```

- **Format**: `in_with_scope:ModelClass,column,scope1,scope2,...`

## 🔁 Example Usage

```php
$request->validate([
    'email' => 'required|email|unique_with_scope:App\\Models\\User,email,company_id',
    'product_id' => 'exists_with_scope:App\\Models\\Product,id,merchant_id',
    'channel' => 'in_with_scope:App\\Models\\Channel,name,region',
]);
```

## 🧪 Custom Error Messages

All rules support Laravel-style custom messages in the `messages()` method or `lang/validation.php`:

```php
'email.unique_with_scope' => 'This email has already been taken within your company.',
```

## 📄 License

MIT © Nur Azim Zahurin
