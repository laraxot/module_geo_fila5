# UI/UX Standard for Read-Only Fields

This document defines the standard styling for read-only input fields within Filament forms in the IndennitaResponsabilita module. The goal is to visually differentiate read-only fields from editable fields, clearly indicating that their values are computed or non-editable, thereby improving the user experience (UI/UX).

## 🎯 Goal

-   **Clarity**: Visually distinguish read-only fields.
-   **Consistency**: Apply a uniform style across all read-only fields.
-   **Feedback**: Provide immediate visual feedback that a field cannot be edited.

## ✅ Standard Styling

Read-only `TextInput` components in Filament forms should apply the following `extraInputAttributes` classes:

```php
->extraInputAttributes([
    'class' => 'bg-gray-100 dark:bg-gray-800 border-l-4 border-l-blue-400 dark:border-l-blue-500 text-blue-900 dark:text-blue-100 cursor-not-allowed',
    'aria-readonly' => 'true', // Semantic attribute for accessibility
])
```

### Breakdown of Classes:

-   `bg-gray-100`: Light gray background for light mode.
-   `dark:bg-gray-800`: Dark gray background for dark mode.
-   `border-l-4`: A 4px left border.
-   `border-l-blue-400`: Blue left border for light mode.
-   `dark:border-l-blue-500`: Darker blue left border for dark mode.
-   `text-blue-900`: Dark blue text color for light mode.
-   `dark:text-blue-100`: Light blue text color for dark mode.
-   `cursor-not-allowed`: Changes the cursor to indicate the field is not editable.
-   `aria-readonly="true"`: An accessibility attribute to semantically mark the field as read-only.

## 🛠️ Implementation Example

This styling is applied within the `getFormSchema()` method of Filament Page/Resource classes where fields are defined.

**Example (from `CompilaIndennitaResponsabilita2.php`):**

```php
TextInput::make($fieldname)
    // ... other field configurations ...
    ->readOnly() // Mark as read-only
    ->extraInputAttributes([
        'class' => 'bg-gray-100 dark:bg-gray-800 border-l-4 border-l-blue-400 dark:border-l-blue-500 text-blue-900 dark:text-blue-100 cursor-not-allowed',
        'aria-readonly' => 'true',
    ]);
```

## 🔗 Related Documentation

-   [Filament Forms Documentation](https://filamentphp.com/docs/5.x/forms/fields/text-input#customizing-the-text-input-field)
-   [Tailwind CSS Background Color](https://tailwindcss.com/docs/background-color)
-   [Tailwind CSS Borders](https://tailwindcss.com/docs/border-width)
-   [Tailwind CSS Text Color](https://tailwindcss.com/docs/text-color)
