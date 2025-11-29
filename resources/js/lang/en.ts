/**
 * English Language Translations
 *
 * This file contains all English translations for the application.
 * Follow the nested structure for better organization.
 */

export const en = {
    // Common
    common: {
        actions: 'Actions',
        add: 'Add',
        back: 'Back',
        cancel: 'Cancel',
        clear: 'Clear',
        close: 'Close',
        confirm: 'Confirm',
        create: 'Create',
        delete: 'Delete',
        deleted: 'Deleted',
        download: 'Download',
        edit: 'Edit',
        loading: 'Loading...',
        next: 'Next',
        no: 'No',
        previous: 'Previous',
        save: 'Save',
        search: 'Search',
        show: 'Show',
        submit: 'Submit',
        update: 'Update',
        yes: 'Yes',
        activate: 'Activate',
        deactivate: 'Deactivate',
        active: 'Active',
        inactive: 'Inactive',
        required: 'Required',
        optional: 'Optional',
        status: 'Status',
        select_status: 'Select status',
        all: 'All',
        filter: 'Filter',
        clear_filters: 'Clear Filters',
        showing_results: 'Showing {from} to {to} of {total} results',
        restore: 'Restore',
        created_by: 'Created By',
        updated_by: 'Updated By',
        view: 'View',
    },

    // Navigation
    nav: {
        dashboard: 'Dashboard',
        home: 'Home',
        contacts: 'Contacts',
        custom_fields: 'Custom Fields',
        settings: 'Settings',
        logout: 'Logout',
    },

    // Custom Field
    custom_field_definition: {
        title: 'Custom Fields',
        title_singular: 'Custom Field Definition',
        description: 'Manage custom fields for your contacts and entities',
        create_custom_field: 'Create Custom Field',
        edit_custom_field: 'Edit Custom Field',
        add_custom_field: 'Add Custom Field',
        create_description: 'Create a new custom field definition for your entities',
        edit_description: 'Update the custom field definition details',
        field_name: 'Field Name',
        field_label: 'Field Label',
        field_type: 'Field Type',
        display_order: 'Display Order',
        is_required: 'Required',
        is_searchable: 'Searchable',
        validation_rules: 'Validation Rules',
        field_options: 'Field Options',
        field_name_help: 'Use lowercase letters, numbers, and underscores only (e.g., custom_email)',
        is_required_help: 'Make this field mandatory',
        is_searchable_help: 'Include in search',
        status_help: 'Enable or disable this field',
        validation_rules_help: 'Add Laravel validation rules (e.g., required, email, max:255)',
        field_options_help: 'Add options for select, radio, or checkbox fields',
        no_validation_rules: 'No validation rules added yet',

        // Field Types
        field_types: {
            text: 'Text',
            email: 'Email',
            number: 'Number',
            date: 'Date',
            select: 'Select',
            textarea: 'Textarea',
            checkbox: 'Checkbox',
            radio: 'Radio',
            url: 'URL',
        },

        // Filters
        filters: {
            all_status: 'All Status',
            all_types: 'All Types',
            searchable: 'Searchable',
            not_searchable: 'Not Searchable',
            all: 'All',
        },

        // Messages
        messages: {
            no_records: 'No custom field definitions found',
            delete_confirmation: 'Are you sure you want to delete "{name}"? This action cannot be undone.',
            delete_title: 'Delete Custom Field Definition',
            create_success: 'Custom field definition created successfully',
            update_success: 'Custom field definition updated successfully',
            delete_success: 'Custom field definition deleted successfully',
            status_updated: 'Status updated successfully',
            error_loading: 'Failed to load custom field definitions',
            error_creating: 'Failed to create custom field definition',
            error_updating: 'Failed to update custom field definition',
            error_deleting: 'Failed to delete custom field definition',
        },

        // Placeholders
        placeholders: {
            search: 'Search by name or label...',
            field_name: 'Enter field name (e.g., custom_email)',
            field_label: 'Enter field label (e.g., Custom Email)',
            field_type: 'Select field type',
            add_option: 'Enter option value',
            add_validation_rule: 'Enter validation rule (e.g., required)',
            display_order: 'Enter display order',
        },
    },

    // Contact
    contact: {
        title: 'Contacts',
        title_singular: 'Contact',
        description: 'Manage your contacts and their information',
        create_contact: 'Create Contact',
        edit_contact: 'Edit Contact',
        view_contact: 'View Contact',
        add_contact: 'Add Contact',
        create_description: 'Create a new contact with their details',
        edit_description: 'Update the contact information',
        name: 'Name',
        email: 'Email',
        phone: 'Phone',
        gender: 'Gender',
        profile_image: 'Profile Image',
        additional_file: 'Additional File',
        basic_information: 'Basic Information',
        additional_emails: 'Additional Emails',
        additional_phones: 'Additional Phones',
        custom_fields: 'Custom Fields',
        add_email: 'Add Email',
        add_phone: 'Add Phone',
        
        // View Contact Page
        overview: 'Overview',
        contact_details: 'Contact Details',
        secondary_contact: 'Secondary Contact',
        activity: 'Activity',
        primary_email: 'Primary Email',
        primary_phone: 'Primary Phone',
        created_at: 'Created At',
        updated_at: 'Updated At',
        created_by: 'Created By',
        updated_by: 'Updated By',
        merge_information: 'Merge Information',
        merged_into_contact: 'This contact has been merged',
        merged_into_description: 'This contact was merged into {name}',
        has_secondary_contact: 'Has Secondary Contact',
        secondary_contact_description: 'This contact has a secondary contact: {name}',
        secondary_contact_info: 'Secondary Contact Information',
        secondary_contact_description_full: 'Details of the secondary contact that was merged with this master contact',
        email_addresses: 'Email Addresses',
        phone_numbers: 'Phone Numbers',
        no_emails: 'No email addresses found',
        no_phones: 'No phone numbers found',
        no_custom_fields: 'No custom fields found',
        primary: 'Primary',
        from_merge: 'From {name}',
        secondary_emails: 'Secondary Contact Emails',
        secondary_phones: 'Secondary Contact Phones',
        secondary_custom_fields: 'Secondary Contact Custom Fields',
        activity_log: 'Activity Log',
        activity_description: 'Track all changes made to this contact',
        no_activity: 'No activity found',
        system: 'System',
        old_values: 'Old Values',
        new_values: 'New Values',
        deleted: 'Deleted',
        merged: 'Merged',
        not_found: 'Contact not found',
        
        // Genders
        genders: {
            male: 'Male',
            female: 'Female',
            other: 'Other',
        },
        
        // Email Types
        email_types: {
            work: 'Work',
            personal: 'Personal',
            other: 'Other',
        },
        
        // Phone Types
        phone_types: {
            mobile: 'Mobile',
            work: 'Work',
            home: 'Home',
            fax: 'Fax',
            other: 'Other',
        },
        
        // Messages
        messages: {
            no_records: 'No contacts found',
            no_records_description: 'Get started by creating your first contact',
            created_successfully: 'Contact created successfully',
            updated_successfully: 'Contact updated successfully',
            deleted_successfully: 'Contact deleted successfully',
            restored_successfully: 'Contact restored successfully',
            error_occurred: 'An error occurred',
            file_selected: 'File selected',
            new_file: 'New file selected',
            current_file: 'Current file',
            locked: 'Locked',
            merge_locked: 'Used in merge',
        },
        
        // Confirmations
        delete_confirmation_title: 'Delete Contact',
        delete_confirmation_description: 'Are you sure you want to delete {name}? This action can be reversed later.',
        restore_confirmation_title: 'Restore Contact',
        restore_confirmation_description: 'Are you sure you want to restore {name}?',
        
        // Placeholders
        placeholders: {
            search: 'Search by name, email, or phone...',
            name: 'Enter full name',
            email: 'Enter email address',
            phone: 'Enter phone number',
            gender: 'Select gender',
        },
    },

    // Audit Log
    audit: {
        actions: {
            created: 'Created',
            updated: 'Updated',
            deleted: 'Deleted',
            restored: 'Restored',
        },
    },

    // Validation
    validation: {
        required: 'This field is required',
        email: 'Please enter a valid email address',
        min: 'Minimum {min} characters required',
        max: 'Maximum {max} characters allowed',
        numeric: 'Please enter a valid number',
        url: 'Please enter a valid URL',
        please_fix_errors: 'Please fix the errors below',
    },
};

export type Translations = typeof en;

export default en;
