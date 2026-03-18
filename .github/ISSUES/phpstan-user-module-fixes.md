# PHPStan Level 10 Fixes - User Module

**Issue Type**: Bug Fix / Code Quality  
**Priority**: High  
**Module**: User  
**PHPStan Level**: 10  
**Created**: 2026-03-18  
**Status**: Open  

---

## Summary

PHPStan analysis on the User module found **13 errors** that need to be fixed to achieve Level 10 compliance.

---

## Error Breakdown

### 1. OauthAccessTokenResource - Return Type Mismatch (Line 203)

**File**: `app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource.php`  
**Error Count**: 1

```
Method Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource::getFormSchema() 
should return array<string, Filament\Resources\Pages\PageRegistration> but returns 
array<string, Filament\Schemas\Components\Section>.
```

**Fix Needed**: Update return type annotation to match actual return type.

---

### 2. OauthClientResource - Type Errors (Lines 61, 68, 71, 74)

**File**: `app/Filament/Clusters/Passport/Resources/OauthClientResource.php`  
**Error Count**: 6

```
- Parameter #1 $columns of method Filament\Tables\Table::columns() expects array<Column|ColumnGroup|Layout>
- Call to an undefined method Filament\Tables\Columns\TextColumn::boolean()
- Cannot call method label() on mixed
```

**Fix Needed**: 
- Fix array type inference
- Use correct column types (IconColumn for boolean)
- Add proper type hints

---

### 3. ViewOauthRefreshToken - Missing Class (Line 17)

**File**: `app/Filament/Resources/OauthRefreshTokenResource/Pages/ViewOauthRefreshToken.php`  
**Error Count**: 1

```
Class Modules\User\Filament\Resources\OauthRefreshTokenResource not found.
```

**Fix Needed**: Create missing resource class or fix namespace.

---

### 4. OauthClient - Return Type Compatibility (Line 55)

**File**: `app/Models/OauthClient.php`  
**Error Count**: 1

```
Return type of Modules\User\Models\OauthClient::user() should be compatible with 
Laravel\Passport\Client::user()
```

**Fix Needed**: Match parent class return type or use proper generics.

---

### 5. OauthPersonalAccessClientFactory - Undefined Method (Lines 23)

**File**: `database/factories/OauthPersonalAccessClientFactory.php`  
**Error Count**: 3

```
- Call to an undefined method OauthClientFactory::asPersonalAccessTokenClient()
- Cannot access property $id on mixed
- Cannot call method create() on mixed
```

**Fix Needed**: Fix factory method chain and add proper type hints.

---

## Action Plan

### Phase 1: Critical Fixes (Blocking)
- [ ] Fix OauthClientResource column types
- [ ] Fix OauthClient return type compatibility
- [ ] Create/fix OauthRefreshTokenResource class

### Phase 2: Type Safety
- [ ] Fix OauthAccessTokenResource return type
- [ ] Fix OauthPersonalAccessClientFactory type hints

### Phase 3: Verification
- [ ] Run PHPStan Level 10 on entire module
- [ ] Run tests to ensure no regressions
- [ ] Update documentation

---

## Commands

```bash
# Run PHPStan on User module
cd laravel
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/User --no-progress

# Run tests
./vendor/bin/pest --filter=User

# Format code
./vendor/bin/pint
```

---

## Related Files

- `laravel/Modules/User/app/Models/OauthClient.php`
- `laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource.php`
- `laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource.php`
- `laravel/Modules/User/app/Filament/Resources/OauthRefreshTokenResource/Pages/ViewOauthRefreshToken.php`
- `laravel/Modules/User/database/factories/OauthPersonalAccessClientFactory.php`

---

## Testing Checklist

- [ ] PHPStan Level 10 passes with 0 errors
- [ ] All existing tests pass
- [ ] No runtime errors in Filament admin panel
- [ ] OAuth client functionality works correctly
- [ ] Token management works correctly

---

## Notes for AI Agents

**Read → Reason → Study → Update → Improve**

1. **Read** the error messages carefully
2. **Reason** about the root cause
3. **Study** similar patterns in other modules (Xot, etc.)
4. **Update** the code with minimal changes
5. **Improve** by running PHPStan + PHPMD + PHPInsights

**DO NOT**:
- Ignore errors in phpstan.neon
- Use `@phpstan-ignore` without justification
- Break existing functionality

**DO**:
- Follow Laraxot patterns
- Use XotBase wrappers
- Maintain strict types
- Add proper type hints

---

## Progress Tracking

| Date | Agent | Action | Status |
|------|-------|--------|--------|
| 2026-03-18 | Qwen | Initial analysis, fixed merge conflicts | ✅ Done |
| 2026-03-18 | Qwen | Created GitHub Issue | ✅ Done |
| 2026-03-18 | | Fix OauthClientResource | ⏳ Pending |
| 2026-03-18 | | Fix OauthClient return type | ⏳ Pending |
| 2026-03-18 | | Fix ViewOauthRefreshToken | ⏳ Pending |
| 2026-03-18 | | Fix OauthAccessTokenResource | ⏳ Pending |
| 2026-03-18 | | Fix OauthPersonalAccessClientFactory | ⏳ Pending |

---

**Related Issues**: None yet  
**Related PRs**: None yet  
**GitHub Discussion**: Link to discussion when created
