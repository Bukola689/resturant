<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // reset cached roles and permissions
         app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

         $storeUser = 'storeUser';
         $updateUser = 'updateUser';
         $deleteUser = 'deleteUser';
         $viewUser = 'viewUser';
 
         $viewFood = 'viewFood';
         $storeFood = 'store food';
         $updateFood = 'update food';
         $deleteFood = 'delete food';
 
         $storeReservation = 'store reservation';
         $updateReservation = 'update reservation';
         $deleteReservation = 'delete reservation';
 
         $storeChef = 'store chef';
         $updateChef = 'update chef';
         $deleteChef = 'delete chef';
 
         $accessAllFood = 'access allFood';
         $accessCart = 'access cart';
         $addCart = 'add cart';
         $removeCart = 'remove cart';
 
         $allReservation = 'all-reservation';
         $getReservationById = 'get-reservation';

         $accessPlaceOrder = 'access-PlaceOrder';
         $accessCartitem = 'access-Cartitem';

         $allFood = 'access-PlaceOrder';
         $getFoodById = 'access-Cartitem';

         $allChef = 'access-chef';
         $getChefById = 'access-chef-id';
 
         //user permisssion..//
         Permission::create(['name' => $viewUser]);
         Permission::create(['name' => $storeUser]);
         Permission::create(['name' => $updateUser]);
         Permission::create(['name' => $deleteUser]);
 
         Permission::create(['name' => $storeFood]);
         Permission::create(['name' => $updateFood]);
         Permission::create(['name' => $deleteFood]);
 
         Permission::create(['name' => $storeReservation]);
         Permission::create(['name' => $updateReservation]);
         Permission::create(['name' => $deleteReservation]);
 
         Permission::create(['name' => $storeChef]);
         Permission::create(['name' => $updateChef]);
         Permission::create(['name' => $deleteChef]);
 
         Permission::create(['name' => $accessAllFood]);
         Permission::create(['name' => $accessCart]);
         Permission::create(['name' => $addCart]);
         Permission::create(['name' => $removeCart]);
 
         Permission::create(['name' => $accessPlaceOrder]);
 
         Permission::create(['name' => $accessCartitem]);

         Permission::create(['name' => $allFood]);
         Permission::create(['name' => $getFoodById]);

         Permission::create(['name' => $allChef]);
         Permission::create(['name' => $getChefById]);

         Permission::create(['name' => $allReservation]);
         Permission::create(['name' => $getReservationById]);
 
           //...Roles...//
 
           $superAdmin = 'super-admin';
           $systemAdmin = 'system-admin';
           $resturantOwner = 'resturant-owner';
           $resturantAdmin = 'resturant-admin';
           $chef = 'chef';
           $customer = 'customer';

        Role::create(['name' => $superAdmin])->givePermissionTo(Permission::all());

        Role::create(['name' => $systemAdmin])->givePermissionTo([
            $storeUser,
            $updateUser,
            $deleteUser,
            $storeFood,
            $updateFood,
            $deleteFood,
        ]);

        Role::create(['name' => $resturantOwner])->givePermissionTo([
            $storeFood,
            $updateFood,
            $deleteFood,
            $storeReservation,
            $updateReservation,
            $deleteReservation,
            $storeChef,
            $updateChef,
            $deleteChef,
        ]);

        Role::create(['name' => $resturantAdmin])->givePermissionTo([
            $storeFood,
            $updateFood,
            $deleteFood,
        ]);
 
 
         Role::create(['name' => $chef])->givePermissionTo([
             $storeFood,
             $updateFood,
             $deleteFood,
         ]);
 
         Role::create(['name' => $customer])->givePermissionTo([
             $viewFood,
         ]);

  }
    
}
