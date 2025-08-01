# 🔐 Unique With Scope — Scoped Validation That Respects Global Scopes in Laravel & Lumen

> Laravel & Lumen validation rules (`unique_with_scope`, `exists_with_scope`, `in_with_scope`) that **honor Eloquent model global scopes** by leveraging the ORM instead of raw queries.

---

## ❓ Why This Package?

Laravel's native `unique`, `exists`, and `in` validation rules **do not respect global scopes** defined on your Eloquent models.

### Problem:

If you’ve added a `GlobalScope` to filter records (e.g., `where('is_active', 1)`), Laravel’s native validation will **bypass it** and still validate against unscoped data.

### Solution:

This package uses **Eloquent models directly** for validation, ensuring:

- Your model’s **global scopes** are always applied.
- Validations like `unique`, `exists`, and `in` are checked **in the same context as your application logic**.

---

## ✅ Features

- `unique_with_scope`: Validate uniqueness using model & scoped columns.
- `exists_with_scope`: Validate existence with model and scoped filters.
- `in_with_scope`: Validate that a value is in a scoped Eloquent dataset.
- **Supports Laravel and Lumen.**
- Reuses model scopes and logic — **DRY & accurate**.

---

## 📦 Installation

```bash
composer require your-vendor/unique-with-scope
```

---

## ⚙️ Usage

```php
$request->validate([
    'email' => 'required|email|unique_with_scope:App\\Models\\User,email'
]);
```

### Parameters

```
<model>,<column>,<except_id>,<except_column>
```

The rule will:

- Instantiate the Eloquent model.
- Apply all global scopes.
- Add `where` conditions using the provided scope columns.
- Validate using `->exists()` or `->where(...)->count()`.

---

## 💡 Example

You have a global scope on `User` model:

```php
protected static function booted()
{
    static::addGlobalScope('active', function (Builder $builder) {
        $builder->where('is_active', 1);
    });
}
```

Laravel’s native validation will ignore it:

```php
// This will wrongly match soft-deleted or inactive users
'email' => 'unique:users,email'
```

With this package:

```php
// Will respect the 'active' global scope on User model
'email' => 'unique_with_scope:App\\Models\\User,email'
```

---

## 🛠️ Setup

### Laravel

No setup required. Package uses auto-discovery.

### Lumen

Register the provider in `bootstrap/app.php`:

```php
$app->register(\YourVendor\UniqueWithScope\UniqueWithScopeRuleServiceProvider::class);
$app->withFacades();
```

---

## 🎯 Custom Error Messages

```php
'email.unique_with_scope' => 'This email is already taken in your organization.',
```

---

## 📄 License

MIT © Nur Azim Zahurin

---

> Built to make Laravel validation **respect your domain logic** — just like the rest of your app does.
