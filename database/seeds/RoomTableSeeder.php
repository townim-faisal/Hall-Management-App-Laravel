<?php

use Illuminate\Database\Seeder;

use App\Room;

class RoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->roomSave(101, 126, 1, 4);
        $this->roomSave(201, 227, 2, 4);
        $this->roomSave(301, 327, 3, 4);
        $this->roomSave(401, 427, 4, 4);
        $this->roomSave(501, 427, 5, 5);

        
    }

    public function roomSave($start, $end, $floor_no, $max_persons)
    {
    	for($i=$start; $i<=$end; $i++) {
        	$room = new Room;
        	$room->floor_no = $floor_no;
        	$room->room_no = $i;
            $room->max_persons = $max_persons;
        	$room->save();
        }
    }
}
