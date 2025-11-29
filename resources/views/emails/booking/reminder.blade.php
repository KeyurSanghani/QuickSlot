@extends('emails.layout')

@section('title', __('message.booking_reminder_subject'))

@section('content')
    <!-- Main Content -->
    <h2 style="color: #2D3748; font-size: 24px; margin-bottom: 20px; text-align: center;">
        {{ __('message.booking_reminder_subject') }}
    </h2>

    <p style="color: #4A5568; font-size: 16px; margin-bottom: 20px;">
        {{ __('message.booking_reminder_greeting', ['name' => $booking->client_name]) }}
    </p>

    <p style="color: #4A5568; font-size: 16px; margin-bottom: 20px;">
        {{ __('message.booking_reminder_intro') }}
    </p>

    <div style="background-color: #F7FAFC; padding: 15px; border-radius: 5px; margin: 20px 0;">
        <p style="color: #2D3748; font-size: 18px; margin-bottom: 15px; font-weight: 600;">
            {{ __('message.booking_details') }}
        </p>
        <p style="color: #4A5568; font-size: 14px; margin: 5px 0;">
            <strong>{{ __('validation.attributes.service') }}:</strong> {{ $service->name }}
        </p>
        <p style="color: #4A5568; font-size: 14px; margin: 5px 0;">
            <strong>{{ __('validation.attributes.booking_date') }}:</strong> {{ $booking->booking_date->format(config('constant.DEFAULT_DATE_FORMAT')) }}
        </p>
        <p style="color: #4A5568; font-size: 14px; margin: 5px 0;">
            <strong>{{ __('validation.attributes.start_time') }}:</strong> {{ $booking->start_time }}
        </p>
        <p style="color: #4A5568; font-size: 14px; margin: 5px 0;">
            <strong>{{ __('validation.attributes.end_time') }}:</strong> {{ $booking->end_time }}
        </p>
        <p style="color: #4A5568; font-size: 14px; margin: 5px 0;">
            <strong>{{ __('validation.attributes.duration') }}:</strong> {{ $service->duration }} {{ __('message.minutes') }}
        </p>
        @if($booking->notes)
        <p style="color: #4A5568; font-size: 14px; margin: 5px 0;">
            <strong>{{ __('validation.attributes.notes') }}:</strong> {{ $booking->notes }}
        </p>
        @endif
    </div>

    <div style="margin: 20px 0; padding: 15px; border-left: 4px solid #667eea;">
        <p style="color: #4A5568; font-size: 14px; margin-bottom: 10px;">
            {{ __('message.booking_reminder_footer') }}
        </p>
        <p style="color: #4A5568; font-size: 14px; margin: 5px 0;">
            {{ __('message.booking_contact_info', ['phone' => $booking->client_phone]) }}
        </p>
    </div>

    <!-- Action Button -->
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ config('app.url') }}" style="display: inline-block; padding: 12px 30px; background-color: #667eea; color: #ffffff; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: 600;">
            {{ __('message.view_booking_details') }}
        </a>
    </div>

    <p style="color: #4A5568; font-size: 14px; margin-top: 20px;">
        {{ __('message.thanks') }}<br>
        <strong>{{ config('app.name') }} {{ __('message.team') }}</strong>
    </p>
@endsection

