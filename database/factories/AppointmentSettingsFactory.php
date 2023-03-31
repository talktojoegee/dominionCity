<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AppointmentSettingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
        'user_id'=>1,
        'org_id'=>1,
        'avail_by_appt_type'=>1,
        'avail_by_location'=>1,
        'avail_by_contact_type'=>1,

        'supported_contact_types'=>1,
        'init_phone_call_appt'=>1,

        'pre_same_day_appt'=>1,
        'appt_buffer'=>0,
        'only_allow_appt_spec_intervals'=>1,
        'min_time_advance'=>0,
        'max_time_advance'=>0,
        'calendar_start'=>null,
        'calendar_end'=>null,

        'send_init_notice_email'=>1,
        'client_email_reminder'=>1,
        'client_sms_reminder'=>1,
        'client_form_reminder'=>1,

        'client_can_cancel_appt'=>1,
        'client_can_reschedule_appt'=>1,
        'require_client_confirm_appt'=>1,
        'auto_confirm_appt'=>0,
        'client_can_cancel_appt_via_txt'=>0,
        'allow_book_without_credits'=>1,
        'restore_credit_when_appt_cancelled'=>0,
        ];
    }
}
