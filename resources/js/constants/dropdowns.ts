export const STATUS_DROPDOWN = [
    { value: 1, label: 'Active' },
    { value: 0, label: 'Inactive' },
];

export type StatusOption = (typeof STATUS_DROPDOWN)[number];

export const GENDER_DROPDOWN = [
    { value: 1, label: 'Male' },
    { value: 2, label: 'Female' },
    { value: 3, label: 'Other' },
];

export type GenderOption = (typeof GENDER_DROPDOWN)[number];

export const EMAIL_TYPE_DROPDOWN = [
    { value: 'work', label: 'Work' },
    { value: 'personal', label: 'Personal' },
    { value: 'other', label: 'Other' },
];

export type EmailTypeOption = (typeof EMAIL_TYPE_DROPDOWN)[number];

export const PHONE_TYPE_DROPDOWN = [
    { value: 'mobile', label: 'Mobile' },
    { value: 'work', label: 'Work' },
    { value: 'home', label: 'Home' },
    { value: 'other', label: 'Other' },
];

export type PhoneTypeOption = (typeof PHONE_TYPE_DROPDOWN)[number];
