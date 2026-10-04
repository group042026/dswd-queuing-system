<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Queue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class ReceptionistOnlineRegistrationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Gate::define('access-receptionist', fn (): bool => true);
        $this->actingAs(new User);
    }

    public function test_online_registrations_show_only_today_by_default(): void
    {
        $today = now()->toDateString();
        $todayQueue = $this->createPendingRegistration('TODAY-001', now()->toDateTimeString());
        $this->createPendingRegistration('YESTERDAY-001', now()->subDay()->toDateTimeString());

        $response = $this->get(route('receptionist.online-registrations'));

        $response->assertOk()
            ->assertViewHas('selectedDate', $today)
            ->assertViewHas('onlineRegistrations', function ($registrations) use ($todayQueue): bool {
                return $registrations->count() === 1
                    && $registrations->first()->is($todayQueue);
            });
    }

    public function test_online_registrations_can_be_filtered_to_a_selected_date(): void
    {
        $selectedDate = now()->subDay()->toDateString();
        $selectedQueue = $this->createPendingRegistration(
            'SELECTED-001',
            now()->subDay()->toDateTimeString()
        );
        $this->createPendingRegistration('TODAY-002', now()->toDateTimeString());

        $response = $this->get(route('receptionist.online-registrations', ['date' => $selectedDate]));

        $response->assertOk()
            ->assertViewHas('selectedDate', $selectedDate)
            ->assertViewHas('onlineRegistrations', function ($registrations) use ($selectedQueue): bool {
                return $registrations->count() === 1
                    && $registrations->first()->is($selectedQueue);
            });
    }

    private function createPendingRegistration(string $queueNumber, string $dateIssued): Queue
    {
        $client = Client::query()->create([
            'first_name' => 'Test',
            'last_name' => 'Client',
            'suffix' => null,
            'sex' => 'Female',
            'age' => 30,
            'civil_status' => 'Single',
            'barangay' => 'Test Barangay',
            'district' => 'Test District',
            'municipality' => 'Test Municipality',
            'province' => 'Test Province',
            'contact_number' => '09123456789',
            'valid_id_type' => 'National ID',
            'valid_id_number' => 'TEST-123',
            'client_category' => 'Senior Citizens',
            'program_requested' => 'AICS',
            'type_of_assistance' => 'Medical',
            'date_registered' => $dateIssued,
        ]);

        return Queue::query()->create([
            'queue_number' => $queueNumber,
            'client_id' => $client->id,
            'priority' => false,
            'queue_status' => 'Pending Arrival',
            'date_issued' => $dateIssued,
        ]);
    }
}
