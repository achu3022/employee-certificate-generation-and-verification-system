<?php
namespace App\Models;

use CodeIgniter\Model;

class OfferLetterDetailModel extends Model
{
    protected $table = 'offer_letter_details';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'employee_id', 'joining_date', 'salary', 'reporting_manager', 'created_at'
    ];
    public $timestamps = false;
} 