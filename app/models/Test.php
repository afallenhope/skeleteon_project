<?php
class Test extends Model {
   // The primary key used to uniquely identify a record
   protected static $primaryKey = 'test_id';

   // The list of fields in the table
   protected static $fields = array(
       'test_id'=> 'INTEGER IDENTITY(1,1)',
       'test_date' => 'DATETIME DEFAULT (getdate())'
   );
}