<?php
use PHPUnit\Framework\TestCase;
use App\VacationRequest;

class VacationRequestTest extends TestCase
{
    public function test_it_rejects_invalid_dates()
    {
        $request = new VacationRequest(1 ,'', '', 'sick_leave', 'pending');
        $this->expectException(InvalidArgumentException::class);
    }

    public function test_delete_pending()
    {
        $request = new VacationRequest(1 ,'', '', 'sick_leave', 'pending');
        $request->setReasonKey('sick_leave');
        $this->assertFalse($request->requiresApproval());
    }
}
