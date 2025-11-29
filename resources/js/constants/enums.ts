// Status Constants - matching StatusEnum.php
export const STATUS = {
    ACTIVE: 1,
    INACTIVE: 0,
} as const;

export type Status = (typeof STATUS)[keyof typeof STATUS];

// Trash Status Constants - matching TrashStatusEnum.php
export const TRASH_STATUS = {
    ONLY_TRASHED: 'ONLY_TRASHED',
    WITH_TRASHED: 'WITH_TRASHED',
} as const;

export type TrashStatus = (typeof TRASH_STATUS)[keyof typeof TRASH_STATUS];

// Role Constants - matching config/constant.php
export const DEFAULT_ROLES = {
    SUPER_ADMIN: 'super-admin',
} as const;
