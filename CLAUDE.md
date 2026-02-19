# CLAUDE.md - Module Organization

This file provides guidance to Claude Code when working with this module.

## Overview

`hanafalah/module-organization` is a Laravel package that provides organization/clinic management functionality for the Wellmed healthcare system. It handles the hierarchical structure of organizations such as clinics, hospitals, and healthcare facilities.

**Namespace:** `Hanafalah\ModuleOrganization`

**Dependencies:**
- `hanafalah/laravel-support` (base package)

## Directory Structure

```
module-organization/
├── src/
│   ├── Commands/
│   │   ├── EnvironmentCommand.php      # Base command class
│   │   └── InstallMakeCommand.php      # Installation command
│   ├── Concerns/
│   │   └── HasOrganization.php         # Trait for models with organization
│   ├── Contracts/
│   │   ├── Data/
│   │   │   ├── ModelHasOrganizationData.php
│   │   │   └── OrganizationData.php
│   │   ├── Schemas/
│   │   │   ├── ModelHasOrganization.php
│   │   │   └── Organization.php
│   │   └── ModuleOrganization.php
│   ├── Data/
│   │   ├── ModelHasOrganizationData.php  # DTO for organization assignments
│   │   └── OrganizationData.php          # DTO for organization data
│   ├── Models/
│   │   ├── ModelHasOrganization.php      # Pivot model for polymorphic relations
│   │   └── Organization.php              # Main organization model
│   ├── Providers/
│   │   └── CommandServiceProvider.php
│   ├── Resources/
│   │   └── Organization/
│   │       ├── ShowOrganization.php      # Detailed single resource
│   │       └── ViewOrganization.php      # List resource
│   ├── Schemas/
│   │   ├── ModelHasOrganization.php      # Schema for pivot operations
│   │   └── Organization.php              # Schema for organization operations
│   ├── ModuleOrganization.php            # Main module class
│   └── ModuleOrganizationServiceProvider.php
├── assets/
│   ├── config/
│   │   └── config.php                    # Module configuration
│   └── database/
│       └── migrations/
│           └── 0001_01_02_000013_create_model_has_organizations_table.php
└── composer.json
```

## Key Models

### Organization

The main organization model extending `Unicode` (polymorphic type system).

**File:** `src/Models/Organization.php`

**Key characteristics:**
- Uses the `unicodes` table (polymorphic storage)
- Supports hierarchical structures via `parent_id`
- Auto-generates organization codes on creation
- Has address support via `HasAddress` trait
- Has phone support via `HasPhone` trait

**Important relationships:**
```php
// Get the organization assignment pivot
$organization->modelHasOrganization();

// Parent organization (self-referencing)
$organization->parent;
```

### ModelHasOrganization

Pivot model for polymorphic many-to-many relationships between any model and organizations.

**File:** `src/Models/ModelHasOrganization.php`

**Table structure:**
| Column | Type | Description |
|--------|------|-------------|
| id | ULID | Primary key |
| organization_type | string(50) | Polymorphic type |
| organization_id | string(36) | Polymorphic ID |
| model_type | string(50) | Related model type |
| model_id | string(36) | Related model ID |
| current | timestamp | Current assignment timestamp |
| props | json | Additional properties |

**Key traits:**
- `HasUlids` - Uses ULID primary keys
- `HasProps` - JSON properties support
- `SoftDeletes` - Soft deletion

## Schemas (Service Classes)

### Organization Schema

**File:** `src/Schemas/Organization.php`

**Key methods:**
- `prepareStoreOrganization(OrganizationData $dto)` - Create/update organization
- `organization($conditionals)` - Query builder for organizations

**Caching:**
- Implements forever cache with tags: `organization`, `organization-index`

### ModelHasOrganization Schema

**File:** `src/Schemas/ModelHasOrganization.php`

**Key methods:**
- `preapreStoreModelHasOrganization(ModelHasOrganizationData $dto)` - Create/update assignment
- `modelHasOrganization($conditionals)` - Query builder

## Data Transfer Objects (DTOs)

### OrganizationData

Extends `UnicodeData` for organization creation/updates.

**Key properties (inherited from UnicodeData):**
- `name` - Organization name
- `flag` - Type identifier (default: 'Organization')
- `props` - Additional properties including address

### ModelHasOrganizationData

**Properties:**
- `id` - Assignment ID
- `reference_type` - Related model type
- `reference_id` - Related model ID
- `organization_type` - Organization type
- `organization_id` - Organization ID

## API Resources

### ViewOrganization

List view resource with basic fields:
- `id`, `parent_id`, `name`, `flag`, `label`
- Dynamic code field based on flag (e.g., `organization_code`)
- `phone_company`, `email_company`

### ShowOrganization

Detailed view extending ViewOrganization with:
- `phone_owner`, `address`, `name_owner`
- Full `ShowUnicode` properties

## CRITICAL: ServiceProvider Warning

**WARNING:** The `ModuleOrganizationServiceProvider` extends `BaseServiceProvider` from `laravel-support`. Be cautious about the following:

### Safe Pattern (Current Implementation)

```php
class ModuleOrganizationServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->registerMainClass(ModuleOrganization::class)
            ->registerCommandService(Providers\CommandServiceProvider::class)
            ->registers([
                '*',
                'Services' => function () {
                    $this->binds([
                        Contracts\ModuleOrganization::class    => OrganizationModel::class,
                        Contracts\Organization::class          => OrganizationSchema::class,
                        Contracts\ModelHasOrganization::class  => ModelHasOrganizationSchema::class,
                    ]);
                },
            ]);
    }
}
```

### Memory Safety Notes

1. **`registers(['*'])`** is now safe - it only registers safe methods (Config, Model, Database, Migration, Route, Namespace, Provider)

2. **Dangerous methods are excluded from `'*'`:**
   - `Schema` - Can cause memory issues due to class loading chains
   - `Services` - Must be explicitly called

3. **Current implementation uses explicit 'Services' callback** - This is the correct pattern as it defers the bindings.

### If Extending This Provider

When creating a child provider that extends this module's service provider:

```php
// SAFE - explicit service registration
class MyServiceProvider extends ModuleOrganizationServiceProvider
{
    public function register()
    {
        parent::register();

        // Register additional services with closures (deferred)
        $this->app->singleton(MyService::class, fn() => new MyService());
    }
}
```

```php
// DANGEROUS - avoid this pattern
class MyServiceProvider extends ModuleOrganizationServiceProvider
{
    public function register()
    {
        parent::register();

        // DON'T do this - can cause memory exhaustion
        $this->registers(['Schema', 'Services']);
    }
}
```

## Usage Patterns

### Creating an Organization

```php
use Hanafalah\ModuleOrganization\Contracts\Schemas\Organization;
use Hanafalah\ModuleOrganization\Data\OrganizationData;

$schema = app(Organization::class);

$dto = OrganizationData::from([
    'name' => 'My Clinic',
    'flag' => 'Clinic',
    'props' => [
        'address' => [
            'street' => '123 Main St',
            'city' => 'Jakarta',
        ],
    ],
]);

$organization = $schema->prepareStoreOrganization($dto);
```

### Querying Organizations

```php
use Hanafalah\ModuleOrganization\Contracts\Schemas\Organization;

$schema = app(Organization::class);

// Get all organizations
$organizations = $schema->organization()->get();

// With conditions
$clinics = $schema->organization(['flag' => 'Clinic'])->get();

// Using the contract's provided methods (via docblock)
$list = $schema->viewOrganizationList();
$paginated = $schema->viewOrganizationPaginate();
$single = $schema->showOrganization($model);
```

### Assigning Models to Organizations

```php
use Hanafalah\ModuleOrganization\Contracts\Schemas\ModelHasOrganization;
use Hanafalah\ModuleOrganization\Data\ModelHasOrganizationData;

$schema = app(ModelHasOrganization::class);

$dto = ModelHasOrganizationData::from([
    'organization_id' => $organizationId,
    'organization_type' => 'Clinic',
    'reference_id' => $userId,
    'reference_type' => 'User',
]);

$assignment = $schema->preapreStoreModelHasOrganization($dto);
```

### Using the HasOrganization Trait

```php
use Hanafalah\ModuleOrganization\Concerns\HasOrganization;

class MyModel extends BaseModel
{
    use HasOrganization;

    // The trait provides organization relationship methods
}
```

## Installation

Run the installation command to publish migrations:

```bash
php artisan module-organization:install
```

This publishes:
- Migration files to `database/migrations/`

## Configuration

The module configuration is in `assets/config/config.php`:

```php
return [
    'app' => [
        'contracts' => [
            // Contract bindings
        ]
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts',
        'schema' => 'Schemas',
        'database' => 'Database',
        'data' => 'Data',
        'resource' => 'Resources',
        'migration' => '../assets/database/migrations'
    ],
    'database' => [
        'models' => [
            // Model overrides
        ]
    ],
    'commands' => [
        InstallMakeCommand::class
    ]
];
```

## Integration with Multi-Tenancy

Organizations are central to the multi-tenant architecture:
- Organizations can represent clinics, hospitals, or healthcare facilities
- Each tenant may have multiple organizations
- The `ModelHasOrganization` pivot allows any model to be associated with organizations

**Important:** Organization data is tenant-specific. When working with organizations in Octane, ensure tenant context is properly set before querying.

## Common Operations

### Get organization with relationships

```php
$organization = $schema->organization()
    ->with(['parent', 'modelHasOrganization'])
    ->find($id);
```

### Check if model belongs to organization

```php
$exists = app(ModelHasOrganization::class)
    ->modelHasOrganization([
        'model_type' => get_class($model),
        'model_id' => $model->id,
        'organization_id' => $orgId,
    ])
    ->exists();
```

### Hierarchical organization queries

```php
// Get all child organizations
$children = $schema->organization(['parent_id' => $parentId])->get();

// Get organization tree (recursive)
$organization = $schema->organization()
    ->with('children.children')
    ->whereNull('parent_id')
    ->get();
```
