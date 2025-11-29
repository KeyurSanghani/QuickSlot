export const DAYS_OF_WEEK = [
    { value: 0, label: 'Sunday' },
    { value: 1, label: 'Monday' },
    { value: 2, label: 'Tuesday' },
    { value: 3, label: 'Wednesday' },
    { value: 4, label: 'Thursday' },
    { value: 5, label: 'Friday' },
    { value: 6, label: 'Saturday' },
] as const

export const BOOKING_STATUSES = [
    { value: 'pending', label: 'Pending', color: 'yellow' },
    { value: 'confirmed', label: 'Confirmed', color: 'blue' },
    { value: 'cancelled', label: 'Cancelled', color: 'red' },
    { value: 'completed', label: 'Completed', color: 'green' },
] as const

export const TIME_FORMAT = 'HH:mm'
export const DATE_FORMAT = 'DD-MM-YYYY'
export const DATETIME_FORMAT = 'DD-MM-YYYY HH:mm'

export const DEFAULT_PER_PAGE = 15
export const DEFAULT_UPCOMING_LIMIT = 10
