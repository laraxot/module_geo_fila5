# ManageRelatedRecords Styling - Zero Theme

## Focus
The 'Zero' theme provides the clean, standard foundations for the Laraxot ecosystem. For related record pages, it focuses on clarity, readability, and semantic structure.

## Layout Guidelines
- **Header**: Large title with a clear relation to the parent record.
- **Table**: Striped rows with a primary color border on the active row.
- **Actions**: Simple icon + text buttons for header actions, icon-only buttons for record actions.

## Default Tokens
- **Table Striping**: `gray-50` background for even rows.
- **Header Action Color**: `primary-600` for the Create button.
- **Empty State**: Gray-scale icon with a prompt to add the first related record.

## Accessibility
- All table column headers use `aria-sort` when applicable.
- Buttons have clear `aria-label` derived from the automatic translation keys.
