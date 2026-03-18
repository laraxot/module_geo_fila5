# PHPStan User Module Fixes - Discussion & Coordination

**Category**: Development / Code Quality  
**Tags**: phpstan, user-module, code-quality, level-10, laravel, filament  
**Related Issue**: `.github/ISSUES/phpstan-user-module-fixes.md`  
**Created**: 2026-03-18  
**Status**: Open for Discussion  

---

## 🎯 Objective

Achieve **PHPStan Level 10** compliance for the User module by fixing all 13 identified errors while maintaining full backward compatibility and functionality.

---

## 📊 Current State

### Error Summary

| Category | Error Count | Severity |
|----------|-------------|----------|
| Return Type Mismatch | 2 | High |
| Undefined Methods | 4 | High |
| Class Not Found | 1 | Critical |
| Type Inference | 6 | Medium |
| **Total** | **13** | **High** |

### Files Affected

1. `OauthAccessTokenResource.php` - 1 error
2. `OauthClientResource.php` - 6 errors
3. `ViewOauthRefreshToken.php` - 1 error (Critical)
4. `OauthClient.php` - 1 error
5. `OauthPersonalAccessClientFactory.php` - 3 errors

---

## 🔍 Technical Analysis

### 1. OauthClient Model - Parent Class Compatibility

**Issue**: The `user()` method return type doesn't match Laravel Passport's `Client::user()`.

**Current**:
```php
public function user(): BelongsTo
```

**Parent Signature** (Laravel\Passport\Client):
```php
public function user(): BelongsTo
```

**Analysis**: The issue is with the generic type parameters. We're using `Modules\Xot\Contracts\UserContract` while Passport expects `Illuminate\Foundation\Auth\User`.

**Proposed Solutions**:

**Option A** - Use PHPStan generics:
```php
/**
 * @return BelongsTo<\Illuminate\Foundation\Auth\User, $this>
 */
public function user(): BelongsTo
```

**Option B** - Keep current implementation with ignore annotation (justified):
```php
public function user(): BelongsTo
{
    /** @var class-string<\Illuminate\Database\Eloquent\Model> $userClass */
    $userClass = XotData::make()->getUserClass();
    
    return $this->belongsTo($userClass, 'user_id'); // @phpstan-ignore return.type
}
```

**Recommendation**: Option B is already in place and justified for Laraxot compatibility.

---

### 2. OauthClientResource - Column Type Errors

**Issue**: Using `TextColumn::boolean()` which doesn't exist.

**Current** (incorrect):
```php
TextColumn::make('personal_access_client')
    ->boolean()
```

**Fix**:
```php
IconColumn::make('personal_access_client')
    ->boolean()
    ->label('Personal Access')
```

**Affected Columns**:
- `personal_access_client`
- `password_client`
- `revoked`

---

### 3. ViewOauthRefreshToken - Missing Resource Class

**Issue**: References non-existent `OauthRefreshTokenResource`.

**Analysis**: The resource class needs to be created or the namespace is incorrect.

**Action Items**:
1. Check if resource exists in another location
2. Create the resource if missing
3. Update namespace if incorrect

---

### 4. OauthAccessTokenResource - Form Schema Return Type

**Issue**: DocBlock says `PageRegistration` but returns `Section`.

**Current**:
```php
/**
 * @return array<string, \Filament\Resources\Pages\PageRegistration>
 */
public static function getFormSchema(): array
```

**Fix**:
```php
/**
 * @return array<string, \Filament\Schemas\Components\Component>
 */
public static function getFormSchema(): array
```

---

### 5. OauthPersonalAccessClientFactory - Factory Chain

**Issue**: Undefined method `asPersonalAccessTokenClient()`.

**Current**:
```php
OauthClient::factory()
    ->asPersonalAccessTokenClient()
    ->create()
```

**Fix Options**:

**Option A** - Use factory state:
```php
OauthClient::factory()
    ->state(['personal_access_client' => true])
    ->create()
```

**Option B** - Create missing factory method:
```php
public function asPersonalAccessTokenClient(): static
{
    return $this->state(['personal_access_client' => true]);
}
```

**Recommendation**: Option B provides better API consistency.

---

## 🤝 Discussion Questions

### Question 1: OauthClient Return Type

Should we:
- **A**: Keep the `@phpstan-ignore` with justification (Laraxot compatibility)
- **B**: Try to match parent signature exactly
- **C**: Refactor to use a different pattern

**Vote**: Leave comment with A, B, or C

---

### Question 2: Missing Resource Class

For `OauthRefreshTokenResource`:
- **A**: Create the full resource (time-intensive)
- **B**: Remove the View page if not needed
- **C**: Fix namespace if it exists elsewhere

**Vote**: Leave comment with A, B, or C

---

### Question 3: Factory Pattern

For factory methods:
- **A**: Add convenience methods to factories (better API)
- **B**: Use raw state() calls (simpler)
- **C**: Create a base factory trait for common patterns

**Vote**: Leave comment with A, B, or C

---

## 📋 Implementation Plan

### Wave 1: Critical Fixes (Day 1)
- [ ] Fix ViewOauthRefreshToken class reference
- [ ] Fix OauthClientResource column types
- [ ] Fix OauthAccessTokenResource return type

### Wave 2: Factory Fixes (Day 2)
- [ ] Add `asPersonalAccessTokenClient()` to OauthClientFactory
- [ ] Fix OauthPersonalAccessClientFactory

### Wave 3: Verification (Day 3)
- [ ] Run full PHPStan analysis
- [ ] Run all tests
- [ ] Manual testing in Filament panel
- [ ] Documentation update

---

## 🧪 Testing Strategy

### Automated Tests
```bash
# PHPStan Level 10
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/User

# Pest tests
./vendor/bin/pest --filter=User

# Code formatting
./vendor/bin/pint
```

### Manual Testing
1. OAuth Client management in Filament
2. Token creation and revocation
3. Personal access client functionality
4. Refresh token operations

---

## 📚 References

- [PHPStan Level 10 Documentation](https://phpstan.org/user-guide/level-reference)
- [Laravel Passport Documentation](https://laravel.com/docs/passport)
- [Filament v5 Documentation](https://filamentphp.com/docs)
- [Laraxot Patterns](laravel/Modules/Xot/docs/)
- [Project Patterns](.agents/docs/agents-guide/13-references/project-patterns.md)

---

## 🔄 Coordination

### AI Agents Working on This

| Agent | Role | Status |
|-------|------|--------|
| Qwen | Analysis & Issue Creation | ✅ Complete |
| | Implementation | ⏳ Pending |

### Other Bases Affected

- [ ] base_fixcity_fila5 (Gemini) - May need sync
- [ ] base_quaeris_fila5 (Claude) - May need sync
- [ ] base_predict_fila5 - Check for similar issues

### Sync Strategy

Once fixes are complete:
1. Commit with clear message
2. Push to remote
3. Notify other agents via GitHub Discussion
4. Create sync PR if needed

---

## 📝 Progress Updates

### 2026-03-18 - Initial Analysis (Qwen)

**Completed**:
- ✅ Ran PHPStan analysis on User module
- ✅ Fixed merge conflicts blocking analysis
- ✅ Identified 13 errors across 5 files
- ✅ Created GitHub Issue
- ✅ Created this Discussion

**Next Steps**:
- Await feedback on discussion questions
- Begin Wave 1 implementation

---

## 💬 Comments

**Add your comments, questions, and votes below!**

---

**Last Updated**: 2026-03-18  
**Maintained By**: AI Agent Team  
**GitHub**: [base_ptv_fila5_mono](https://github.com/provtv/base_ptv_fila5_mono)
