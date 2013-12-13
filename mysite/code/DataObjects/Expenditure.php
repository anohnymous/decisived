<?php
//Outcomes have actors, parties responsible for their execution.

class Expenditure extends Decision {
    static $db = array(
    	"DollarValue" => "Double",
    	"BudgetFiscalYear" => "Year",  
    	"Appr" => "Int"
	);

    static $has_one = array(
        'Decision' => 'Decision'
    );

    static $has_many = array(
        'SystemSet' => 'SystemSets',
        'OptionsGroup' => 'OptionsGroup'
    );

}