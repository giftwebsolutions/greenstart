SysAdmin Core Implementation Checklist
Use this checklist when implementing the same SysAdmin improvements in another Laravel project.
1. Form validation
- Use a dedicated FormRequest for every create/update form.
- Separate create and update validation rules.
- On update, ignore only the current primary-key ID in unique validation.
- Use Laravel fluent Rule::unique() and Rule::exists().
- Confirm validation table names and column names match the database.
- Validate uploaded file type, MIME, and maximum size.
- Validate boolean fields consistently as 0/1 or true/false.
- Trim text inputs before validation.
- Add clear custom field names and error messages.
- Show all validation errors in an alert above the form.
- Keep server-side validation authoritative.
2. Common unique-validation mistakes
- Forgetting to ignore the current row during update.
- Using the wrong route parameter name.
- Using a singular table name when the database uses plural, or vice versa.
- Checking only one column when the database has compound uniqueness.
- Trusting a hidden request ID instead of the route/model ID.
- Depending entirely on JavaScript remote validation.
- Forgetting to clear production configuration and view caches.
3. Client-side validation
- Use the correct Bootstrap validation template.
- Error messages must be red and readable.
- Invalid fields must receive a red border.
- Avoid remote AJAX validation for database rules when production servers reject PATCH or return CSRF 419 errors.
- Keep simple required, length, number, and format checks on the client.
- Always repeat complete validation on the server.
4. Form user interface
- Preload existing values on edit forms.
- Preserve submitted values with old() after validation failure.
- Preselect current dropdown values.
- Display the existing image before replacement.
- Provide explicit image removal controls.
- Display upload size and accepted file types.
- Make automatically calculated fields read-only.
- Show success/error notifications after create, update, delete, and import.
- Place relationship or general validation errors above the form.
5. Relationships
- Validate every foreign key with an exists rule.
- Validate that a subcategory belongs to the selected main category.
- Validate that a product belongs to the selected enquiry category.
- Restrict category parent selection to valid root categories.
- Prevent a page/category from becoming its own parent.
- Accept 0 or null when “No parent” is valid.
- Eager-load relationships on listing and view pages.
- Display related names instead of numeric IDs.
- Use the exact Eloquent relationship name in views.
- Show a safe fallback when related data has been deleted.
- Audit existing orphaned and mismatched records before adding constraints.
6. Product forms
- Load categories, subcategories, brands, statuses, and offer types.
- On update, preload the selected subcategory and brand.
- Include an inactive brand if it is already assigned to the product.
- Reload subcategories when the main category changes.
- Use same-origin relative AJAX URLs.
- Validate that prices cannot exceed MRP.
- Validate stock as a non-negative integer.
- Store status consistently as boolean.
- Calculate discount from MRP and offer price on the server.
- Do not trust a submitted discount value.
- Show the calculated discount in a read-only field.
7. Images and files
- Store stable relative database paths.
- Do not store environment-specific absolute URLs.
- Resolve the existing database image before showing a default image.
- Use a fallback image only when the stored image cannot be loaded.
- Keep an existing image when no replacement is uploaded.
- Remove old files only after confirming the target record and path.
- Support JPG, JPEG, PNG, and WebP consistently.
8. Export and import
- Install and verify the spreadsheet exporter dependency.
- Confirm required PHP extensions are available.
- Export primary product IDs for reliable updates.
- Stock/price imports must update only existing product IDs.
- Reject missing and nonexistent IDs.
- Reject duplicate IDs within the spreadsheet.
- Validate required headers before processing rows.
- Add row numbers to import error messages.
- Validate price relationships and boolean values.
- Recalculate derived fields such as discount.
- Do not trust calculated spreadsheet columns.
- Wrap imports in a database transaction.
- Set a maximum number of import rows and file size.
- Protect spreadsheets against formula injection.
- Exclude HTML action-button columns from exports.
- Test CSV and XLSX export/import round trips.
9. Settings
- Group settings by type, such as:
  - Core
  - System
  - Social media
  - SMTP
- Load settings once and expose them through application configuration.
- Clear the settings cache after create, update, or delete.
- Use settings for contact details rather than hard-coded values.
- Normalize legacy or hyphenated keys centrally.
- Use configured values consistently across:
  - Contact page
  - Header
  - Footer
  - Phone links
  - WhatsApp links
  - Instagram links
  - Google Maps links
  - Email links
- Hide optional contact rows when no value is configured.
10. DataTables
- Mark action columns as computed.
- Make action columns non-searchable and non-orderable.
- Exclude action columns from Excel, CSV, PDF, and print.
- Verify server-side Excel dependencies.
- Return user-friendly errors instead of generic 500 pages.
- Test pagination, sorting, searching, printing, and exporting.
11. Notifications and error handling
- Use consistent success messages for every operation.
- Preserve validation errors when redirecting back.
- Avoid catching validation exceptions unnecessarily.
- Log unexpected exceptions while showing a safe user-facing message.
- Do not silently hide relationship or database failures.
- Display import row errors together when practical.
12. Module/service-provider structure
- Load module views from the module’s own resources/views directory.
- Do not register frontend module views from the application root provider.
- Keep frontend-specific configuration inside the frontend module provider.
- Avoid database access during console commands when it can break deployment.
- Gracefully handle temporary database unavailability during frontend boot.
13. Database integrity
- Add database unique indexes matching important validation rules.
- Use foreign keys where legacy data permits.
- Check duplicates before adding unique indexes.
- Check orphaned records before adding foreign keys.
- Use transactions for multi-row updates.
- Never automatically repair relationships when the correct target cannot be inferred.
14. Testing before deployment
- Test create with valid and invalid data.
- Test update without changing unique fields.
- Test update using another row’s unique value.
- Test null, zero, valid, missing, and self-parent IDs.
- Test valid and mismatched relationships.
- Test active and inactive statuses.
- Test image retain, replace, remove, and missing-file fallback.
- Test spreadsheet positive and negative cases.
- Compile Blade templates and cache routes.
- Test using production-like HTTPS, sessions, and middleware.