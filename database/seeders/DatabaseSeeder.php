<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\BookSlot;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Slot;
use App\Models\SlotClassification;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->testUsers();
        $this->createAdminAndManagerRoles();
        $this->assignAdminRole();
        $this->assignManagerRole();
        $this->addCompanyForAdmin();
        $this->addBranchesForAdminAndManager();
        $this->slots();
        $this->slotClassifications();
        $this->bookSlots();
    }

    private function testUsers()
    {
        \App\Models\User::factory()->create([
            'mobile' => 9493970073,
        ]);
        \App\Models\User::factory()->create([
            'mobile' => 9493970074,
        ]);
        \App\Models\User::factory()->create([
            'mobile' => 9493970075,
        ]);
        \App\Models\User::factory()->create([
            'mobile' => 9493970076,
        ]);
    }

    private function createAdminAndManagerRoles()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'manager']);
    }

    private function assignAdminRole()
    {
        $user = User::find(1);
        $user->assignRole('admin');
    }

    private function assignManagerRole()
    {
        $manager = User::find(2);
        $manager->assignRole('manager');

        $manager = User::find(3);
        $manager->assignRole('manager');

        $manager = User::find(4);
        $manager->assignRole('manager');
    }

    private function addCompanyForAdmin()
    {
        $user = User::find(1);
        Company::factory()->create(['user_id' => $user->id]);
    }

    private function addBranchesForAdminAndManager()
    {
        $user = User::find(1);
        // $manager = User::whereIn('id', [2, 3, 4])->inRandomOrder()->first()->id;
        $company = Company::find(1);
        Branch::factory(7)->create([
            'user_id' => $user->id,
            'company_id' => $company->id,
            'is_main_branch' => 0,
        ]);

        Branch::where('id', 1)->update(['is_main_branch' => 1]);
    }

    private function slots()
    {
        $company = Company::find(1);
        $branches = Branch::all();

        $slot_types = ['One-time', 'Subscription'];
        foreach ($slot_types as $slot_type) {
            $sports = ['Swimming', 'Gym', 'Cricket', 'Badminton', 'Tennis'];
            foreach ($sports as $sport) {
                $days_of_week = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                $slot_name = fake()->name();

                foreach ($days_of_week as $day) {
                    foreach ($branches as $branch) {

                        if ($slot_type == "One-time") {
                            $days_of_plan = 1;
                            $no_of_times_allowed = $days_of_plan;
                        } else {
                            $days_of_plan = random_int(30, 730);
                            $no_of_times_allowed = $days_of_plan;
                        }

                        Slot::factory(7)->create([
                            'company_id' => $company->id,
                            'branch_id' => $branch->id,
                            'day' => $day,
                            'sport' => $sport,
                            'slot_type' => $slot_type,
                            'slot_name' => $slot_name,
                            'days_of_plan' => $days_of_plan,
                            'no_of_times_allowed' => $no_of_times_allowed,
                        ]);
                    }
                }
            }
        }
    }

    private function slotClassifications()
    {
        $slots = Slot::all();

        foreach ($slots as $slot) {
            $genders = ['Male', 'Female', 'Kids'];

            foreach ($genders as $gender) {

                if ($gender == "Male") {
                    $allowed_age_from = 18;
                    $allowed_age_to = 60;
                    $amount = 200;
                } elseif ($gender == "Female") {
                    $allowed_age_from = 18;
                    $allowed_age_to = 60;
                    $amount = 200;
                } elseif ($gender == "Kids") {
                    $allowed_age_from = 18;
                    $allowed_age_to = 60;
                    $amount = 100;
                }

                SlotClassification::create([
                    'slot_id' => $slot->id,
                    'allowed_gender' => $gender,
                    'allowed_age_from' => $allowed_age_from,
                    'allowed_age_to' => $allowed_age_to,
                    'amount' => $amount
                ]);
            }
        }
    }

    private function bookSlots()
    {
        $company = Company::find(1);
        $branches = Branch::all();
        $users = User::all();

        foreach ($users as $user) {

            foreach ($branches as $branch) {
                BookSlot::factory(10)->create(['user_id'=>$user->id,'company_id' => $company->id, 'branch_id' => $branch->id]);
            }
        }
    }
}
