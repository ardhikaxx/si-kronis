<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public function create($userId, $type, $title, $message, $data = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data ? json_encode($data) : null,
            'is_read' => false,
        ]);
    }
    
    public function bookingConfirmed($booking)
    {
        return $this->create(
            $booking->patient_id,
            'booking.confirmed',
            'Booking Dikonfirmasi',
            "Booking Anda dengan kode {$booking->kode_booking} telah dikonfirmasi.",
            ['booking_id' => $booking->id]
        );
    }
    
    public function bookingCancelled($booking)
    {
        return $this->create(
            $booking->patient_id,
            'booking.cancelled',
            'Booking Dibatalkan',
            "Booking Anda dengan kode {$booking->kode_booking} telah dibatalkan.",
            ['booking_id' => $booking->id]
        );
    }
    
    public function prescriptionIssued($prescription)
    {
        return $this->create(
            $prescription->patient_id,
            'prescription.issued',
            'Resep Tersedia',
            "Resep dengan kode {$prescription->kode_resep} telah tersedia.",
            ['prescription_id' => $prescription->id]
        );
    }
}
