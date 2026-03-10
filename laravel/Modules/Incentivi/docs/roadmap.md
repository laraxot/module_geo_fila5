# Incentivi Module Roadmap

## Visione

Modulo per la gestione degli incentivi: progetti, attività, dipendenti, workgroup, capital percentages e liquidazioni.

## Fasi di Sviluppo

### Fase 1: Stabilizzazione (In Progress)
- [ ] PHPStan Level 10 Compliance (❌ Found 11 errors - Reported #77)
- [ ] PHPMD issues (LongVariable, CyclomaticComplexity, etc.)
- [ ] Test Coverage improvement

### Fase 2: Refactoring (Planned)
- [ ] Riduzione complessità UpdateProjectActivitiesAction
- [ ] Refactoring EmployeesRelationManager
- [ ] Documentazione completa

### Fase 3: Integrazione (Future)
- [ ] Integrazione con moduli HR
- [ ] Traduzioni it/en complete

## Checklist Qualità

- [ ] PHPStan Level 10 (Fixing errors in #77)
- [ ] PHPMD compliance
- [ ] Test coverage
- [ ] Documentazione in docs/

---

## PHPMD Issues (dettaglio)

### LongVariable
- [ ] `app/Actions/SpareImportoTotaleAction.php:43`: Avoid excessively long variable names like `$importoEffettivoFondo`. Keep variable name length under 20.
- [ ] `app/Actions/SpareImportoTotaleAction.php:44`: Avoid excessively long variable names like `$importoEffettivoFondoFloat`. Keep variable name length under 20.
- [ ] `app/Actions/UpdateActivitiesEmployeesAction.php:59`: Avoid excessively long variable names like `$percentualeAttivitaDipendente`. Keep variable name length under 20.
- [ ] `app/Actions/UpdateProjectActivitiesAction.php:49`: Avoid excessively long variable names like `$componenteIncentivante`. Keep variable name length under 20.
- [ ] `app/Actions/UpdateProjectActivitiesAction.php:91`: Avoid excessively long variable names like `$percentualeAttivitaDipendente`. Keep variable name length under 20.
- [ ] `app/Filament/Resources/ProjectResource.php:52`: Avoid excessively long variable names like `$subNavigationPosition`. Keep variable name length under 20.
- [ ] `app/Filament/Resources/ProjectResource/Pages/CreateProject.php:35`: Avoid excessively long variable names like `$componenteIncentivante`. Keep variable name length under 20.

### CyclomaticComplexity
- [ ] `app/Actions/UpdateActivitiesEmployeesAction.php:26`: The method `execute()` has a Cyclomatic Complexity of 13. The configured cyclomatic complexity threshold is 10.
- [ ] `app/Actions/UpdateProjectActivitiesAction.php:27`: The method `execute()` has a Cyclomatic Complexity of 22. The configured cyclomatic complexity threshold is 10.
- [ ] `app/Filament/Resources/ActivityResource/RelationManagers/EmployeesRelationManager.php:36`: The method `getFormSchema()` has a Cyclomatic Complexity of 12. The configured cyclomatic complexity threshold is 10.
- [ ] `app/Filament/Resources/ActivityResource/RelationManagers/EmployeesRelationManager.php:130`: The method `getTableHeaderActions()` has a Cyclomatic Complexity of 17. The configured cyclomatic complexity threshold is 10.
- [ ] `app/Filament/Resources/ProjectResource/Pages/ManageProjectEmployees.php:89`: The method `sumPerColumn()` has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- [ ] `app/Http/Controllers/PdfDownloadController.php:19`: The method `download()` has a Cyclomatic Complexity of 10. The configured cyclomatic complexity threshold is 10.
- [ ] `app/Models/StabiDirigente.php:172`: The method `getNomeDiriAttribute()` has a Cyclomatic Complexity of 12. The configured cyclomatic complexity threshold is 10.

### NPathComplexity
- [ ] `app/Actions/UpdateActivitiesEmployeesAction.php:26`: The method `execute()` has an NPath complexity of 1552. The configured NPath complexity threshold is 200.
- [ ] `app/Actions/UpdateProjectActivitiesAction.php:27`: The method `execute()` has an NPath complexity of 49952. The configured NPath complexity threshold is 200.

### UnusedFormalParameter (Apply @SuppressWarnings(PHPMD.UnusedFormalParameter))
- [ ] `app/Filament/Resources/ActivityResource.php:52`: Avoid unused parameters such as '$get'.
- [ ] `app/Filament/Resources/ActivityResource/RelationManagers/EmployeesRelationManager.php:48`: Avoid unused parameters such as '$attribute'.
- [ ] `app/Filament/Resources/ActivityResource/RelationManagers/EmployeesRelationManager.php:93`: Avoid unused parameters such as '$get'.
- [ ] `app/Filament/Resources/WorkgroupResource/Actions/WorkgroupSeederAction.php:28`: Avoid unused parameters such as '$user'.
- [ ] `app/Filament/Resources/WorkgroupResource/Actions/WorkgroupSeederAction.php:28`: Avoid unused parameters such as '$data'.
- [ ] `app/Models/Employee.php:129`: Avoid unused parameters such as '$query'.
- [ ] `app/Models/Employee.php:129`: Avoid unused parameters such as '$workgroup_id'.
- [ ] `app/Models/Employee.php:137`: Avoid unused parameters such as '$value'.
- [ ] `app/Models/Policies/ActivityEmployeePolicy.php:54`: Avoid unused parameters such as '$user'.
- [ ] `app/Models/Policies/ActivityEmployeePolicy.php:54`: Avoid unused parameters such as '$activityEmployee'.
- [ ] `app/Models/Policies/ActivityPolicy.php:17`: Avoid unused parameters such as '$user'.
- [ ] `app/Models/Policies/ActivityPolicy.php:50`: Avoid unused parameters such as '$user'.
- [ ] `app/Models/Policies/ActivityPolicy.php:50`: Avoid unused parameters such as '$activity'.
- [ ] `app/Models/Policies/ActivityPolicy.php:71`: Avoid unused parameters such as '$activity'.
- [ ] `app/Models/Policies/ActivityPolicy.php:105`: Avoid unused parameters such as '$activity'.
- [ ] `app/Models/Policies/CapitalPercentagePolicy.php:29`: Avoid unused parameters such as '$capitalPercentage'.
- [ ] `app/Models/Policies/CapitalPercentagePolicy.php:45`: Avoid unused parameters such as '$capitalPercentage'.
- [ ] `app/Models/Policies/CapitalPercentagePolicy.php:53`: Avoid unused parameters such as '$capitalPercentage'.
- [ ] `app/Models/Policies/DefaultActivityPolicy.php:29`: Avoid unused parameters such as '$defaultActivity'.
- [ ] `app/Models/Policies/DefaultActivityPolicy.php:45`: Avoid unused parameters such as '$defaultActivity'.
- [ ] `app/Models/Policies/DefaultActivityPolicy.php:53`: Avoid unused parameters such as '$defaultActivity'.
- [ ] `app/Models/Policies/EmployeePolicy.php:17`: Avoid unused parameters such as '$user'.
- [ ] `app/Models/Policies/EmployeePolicy.php:56`: Avoid unused parameters such as '$user'.
- [ ] `app/Models/Policies/EmployeePolicy.php:56`: Avoid unused parameters such as '$employee'.
- [ ] `app/Models/Policies/EmployeePolicy.php:65`: Avoid unused parameters such as '$employee'.
- [ ] `app/Models/Policies/EmployeePolicy.php:99`: Avoid unused parameters such as '$employee'.
- [ ] `app/Models/Policies/EmployeePolicy.php:113`: Avoid unused parameters such as '$employee'.
- [ ] `app/Models/Policies/EmployeePolicy.php:121`: Avoid unused parameters such as '$employee'.
- [ ] `app/Models/Policies/EmployeeProjectPolicy.php:21`: Avoid unused parameters such as '$user'.
- [ ] `app/Models/Policies/EmployeeProjectPolicy.php:30`: Avoid unused parameters such as '$assignment'.
- [ ] `app/Models/Policies/EmployeeProjectPolicy.php:55`: Avoid unused parameters such as '$user'.
- [ ] `app/Models/Policies/EmployeeProjectPolicy.php:55`: Avoid unused parameters such as '$assignment'.
- [ ] `app/Models/Policies/EmployeeProjectPolicy.php:69`: Avoid unused parameters such as '$assignment'.
- [ ] `app/Models/Policies/EmployeeWorkgroupPolicy.php:54`: Avoid unused parameters such as '$membership'.
- [ ] `app/Models/Policies/EmployeeWorkgroupPolicy.php:70`: Avoid unused parameters such as '$membership'.
- [ ] `app/Models/Policies/ProjectPolicy.php:17`: Avoid unused parameters such as '$user'.
- [ ] `app/Models/Policies/ProjectPolicy.php:47`: Avoid unused parameters such as '$user'.
- [ ] `app/Models/Policies/ProjectPolicy.php:55`: Avoid unused parameters such as '$user'.
- [ ] `app/Models/Policies/ProjectPolicy.php:122`: Avoid unused parameters such as '$project'.
- [ ] `app/Models/Policies/SettlementPolicy.php:80`: Avoid unused parameters such as '$settlement'.
- [ ] `app/Models/Policies/SettlementPolicy.php:102`: Avoid unused parameters such as '$settlement'.
- [ ] `app/Models/Policies/WorkgroupPolicy.php:54`: Avoid unused parameters such as '$workgroup'.
- [ ] `app/Models/Policies/WorkgroupPolicy.php:62`: Avoid unused parameters such as '$workgroup'.
- [ ] `app/Models/Policies/WorkgroupPolicy.php:75`: Avoid unused parameters such as '$workgroup'.
- [ ] `app/Models/Policies/WorkgroupPolicy.php:108`: Avoid unused parameters such as '$workgroup'.

### CouplingBetweenObjects
- [ ] `app/Filament/Resources/ProjectResource.php:40`: The class `ProjectResource` has a coupling between objects value of 24. Consider to reduce the number of dependencies under 13.
- [ ] `app/Filament/Resources/WorkgroupResource/RelationManagers/EmployeesRelationManager.php:23`: The class `EmployeesRelationManager` has a coupling between objects value of 13. Consider to reduce the number of dependencies under 13.

### ExcessiveMethodLength
- [ ] `app/Filament/Resources/ProjectResource.php:55`: The method `getFormSchema()` has 151 lines of code. Current threshold is set to 100. Avoid really long methods.
- [ ] `database/seeders/SeedCapitalPercentagesSeeder.php:15`: The method `run()` has 142 lines of code. Current threshold is set to 100. Avoid really long methods.
- [ ] `database/seeders/SeedDefaultActivitySeeder.php:17`: The method `run()` has 338 lines of code. Current threshold is set to 100. Avoid really long methods.

### UnusedLocalVariable
- [ ] `app/Http/Controllers/PdfDownloadController.php:117`: Avoid unused local variables such as '$years'.
- [ ] `app/Http/Controllers/PdfDownloadController.php:124`: Avoid unused local variables such as '$employee'.
- [ ] `app/Models/StabiDirigente.php:202`: Avoid unused local variables such as '$conn'.
- [ ] `app/Projectors/AttivitaImportoProjector.php:16`: Avoid unused local variables such as '$project'.

### ElseExpression
- [ ] `app/Models/Policies/EmployeeProjectPolicy.php:73`: The method `delete` uses an else expression. Else clauses are basically not necessary and you can simplify the code by not using them.

## PHPStan Issues
- [ ] Found 11 errors (Reported #77).

## PHPInsights Issues
- [ ] Unable to run due to missing composer.lock file.
