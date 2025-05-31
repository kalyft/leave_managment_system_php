<?php
it('submits vacation request', function () {
    $employee = User::factory()->create(['role' => 'employee']);
    $this->actingAs($employee);

    $response = $this->post('/employee/dashboard', [
        'start_date' => '2023-01-01',
        'end_date' => '2023-01-05',
        'reason' => 'holiday'
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('vacation_requests', [
        'user_id' => $user->id,
        'status' => 'pending'
    ]);
});
