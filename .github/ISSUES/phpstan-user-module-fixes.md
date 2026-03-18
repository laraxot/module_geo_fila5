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

**Current Status**: ✅ **9 errors fixed**, 4 errors remaining.

---

## 🎉 Progress Update (2026-03-18)

**Fixed**:
- ✅ Merge conflicts in OauthClient.php
- ✅ Merge conflicts in OauthRefreshTokenFactory.php
- ✅ Duplicate methods in OauthAccessTokenResource.php
- ✅ OauthAccessTokenResource return type annotation
- ✅ OauthClientResource column type errors (6 errors)
- ✅ ViewOauthRefreshToken class not found (autoloading issue resolved)

**Remaining**: 4 errors in 2 files

---

## Error Breakdown

### ✅ FIXED - OauthAccessTokenResource - Return Type Mismatch (Line 203)

**Status**: ✅ FIXED  
**File**: `app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource.php`  

**Fix Applied**: Updated docblock return type to match actual return type.

---

### ✅ FIXED - OauthClientResource - Type Errors (Lines 61, 68, 71, 74)

**Status**: ✅ FIXED  
**File**: `app/Filament/Clusters/Passport/Resources/OauthClientResource.php`  

**Fix Applied**: Converted TextColumn to IconColumn for boolean values.

---

### ✅ FIXED - ViewOauthRefreshToken - Missing Class (Line 17)

**Status**: ✅ FIXED  
**File**: `app/Filament/Clusters/Passport/Resources/OauthRefreshTokenResource/Pages/ViewOauthRefreshToken.php`  

**Fix Applied**: Class exists, was PHPStan bootstrap order issue. Resolved by fixing other files first.

---

### ⏳ REMAINING - OauthClient - Return Type Compatibility (Line 55)

**File**: `app/Models/OauthClient.php`  
**Error Count**: 1

```
Return type of Modules\User\Models\OauthClient::user() should be compatible with 
Laravel\Passport\Client::user()
```

**Analysis**: This is a known limitation when extending Laravel Passport's Client model while using Laraxot's XotData::getUserClass(). The implementation is correct for Laraxot compatibility.

**Recommended Fix**: Add justified `@phpstan-ignore` annotation.

---

### ⏳ REMAINING - OauthPersonalAccessClientFactory - Undefined Method (Lines 23)

**File**: `database/factories/OauthPersonalAccessClientFactory.php`  
**Error Count**: 3

```
- Call to an undefined method OauthClientFactory::asPersonalAccessTokenClient()
- Cannot access property $id on mixed
- Cannot call method create() on mixed
```

**Fix Needed**: Add `asPersonalAccessTokenClient()` method to OauthClientFactory.

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
| 2026-03-18 | Qwen | Created GitHub Issue & Discussion | ✅ Done |
| 2026-03-18 | Qwen | Fixed OauthClientResource column types | ✅ Done |
| 2026-03-18 | Qwen | Fixed OauthAccessTokenResource return type | ✅ Done |
| 2026-03-18 | Qwen | Resolved ViewOauthRefreshToken bootstrap issue | ✅ Done |
| 2026-03-18 | Qwen | Commit & push all fixes | ✅ Done |
| 2026-03-18 | | Fix OauthClient return type (add @phpstan-ignore) | ⏳ Pending |
| 2026-03-18 | | Add asPersonalAccessTokenClient() to OauthClientFactory | ⏳ Pending |
| 2026-03-18 | | Final verification: PHPStan Level 10 with 0 errors | ⏳ Pending |

---

**Related Issues**: None yet  
**Related PRs**: None yet  
**GitHub Discussion**: Link to discussion when created
