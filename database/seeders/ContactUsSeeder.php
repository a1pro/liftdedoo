<?php

namespace Database\Seeders;
use App\Models\contact_right;
use Illuminate\Database\Seeder;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $contact = contact_right::find(1);
        if (!$contact) {
            $contact = new contact_right();
            $contact->id = "1";
        }
        $contact->address = "San Francisco, CA 4999, USA";
        $contact->mobile = "5464565665";
        $contact->email = "contact1234@test.com";
        $contact->save();

    }
}
