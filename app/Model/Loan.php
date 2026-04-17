<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    public $timestamps = false;
    protected $table = 'books_loans';
    protected $primaryKey = 'id_loan';

    protected $fillable = [
        'id_book',
        'card_number',
        'loan_date',
        'return_date',
        'actual_return_date',
        'id_status_loan'
    ];
}