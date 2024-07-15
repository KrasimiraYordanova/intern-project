<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Car;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $admin;
    private Car $car;
    private Property $property;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser('user');
        $this->admin = $this->createUser('admin');
        $this->car = Car::create([
            'brand' => 'Hundai',
            'model' => 'Tucson',
            'year' => 2023,
            'price' => 546000,
            'manufacturing' => 2022,
        ]);
        $this->property = Property::create([
            'type' => 'villa',
            'address' => 'Boston',
            'price' => 450000,
            'manufacturing' => 2022,
        ]);
    }

    // PASSED
    public function test_auth_user_on_empty_record(): void
    {
        $response = $this->actingAs($this->user)->get('/user/cars');

        $response->assertStatus(200);
        $response->assertSee('Add car');
    }

    // PASSED
    public function test_unauth_user_cannot_access_cars_page() {
        $response = $this->get('/user/cars');
        $response->assertRedirect('login');
    }

    // PASSED
    public function test_auth_admin_on_cars_list_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/cars');

        $response->assertStatus(200);
        $response->assertSee('Hundai');
    }

    // FAILED
    public function test_auth_admin_on_cars_list_empty(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/cars');

        $response->assertStatus(200);
        // dd($response);
        $response->assertSee("There is no property records");
    }

    // FAILED
    public function test_auth_user_can_save_items()
    {
        $response = $this->actingAs($this->user)->post('/user/car/store',  $this->car->toArray());

        $response->assertStatus(302);
        $response->assertRedirect('/user/cars');

        $this->assertDatabaseHas('cars', $this->car->toArray());

        $lastCar = Car::latest()->first();
        $this->assertEquals($this->car['brand'], $lastCar->brand);
        $this->assertEquals($this->car['model'], $lastCar->model);
        $this->assertEquals($this->car['year'], $lastCar->year);
        $this->assertEquals($this->car['price'], $lastCar->price);
    }

    // PASSED
    public function test_guest_cannot_create_a_car()
    {
        $response = $this->get('/user/car/create');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    // PASSED
    public function test_auth_admin_cannot_see_create_item_form()
    {
        $response = $this->actingAs($this->admin)->get('/user/car/create');

        $response->assertStatus(302);
        $response->assertRedirect('/admin/dashboard');
    }

    // FAILED
    public function test_car_on_wrong_update_validation_redirects_back_to_form()
    {
        $response = $this->actingAs($this->user)->put('/user/car/' . $this->car->id, [
            'brand' => '',
            'model' => 'Tucson',
            'year' => 2023,
            'price' => 54600,
            'manufacturing' => 2022,
        ]);

        // dd($response);
        $response->assertStatus(302);
        $response->assertRedirect('/user/car/' . $this->car->id . '/edit');
        $response->assertInvalid(['brand']);
    }

    // FAILED
    public function test_car_deleted_successfully()
    {
        $response = $this->actingAs($this->user)->delete('/user/delete/car/' . $this->car->id);

        $response->assertStatus(302);
        $response->assertRedirect('/user/cars');

        $this->assertDatabaseMissing('cars', $this->car->toArray());
        $this->assertDatabaseCount('cars', 0);
    }

    private function createUser($role): User
    {
        return User::factory()->create([
            'role' => $role
        ]);
    }

     // public function test_car_edit_contains_correct_values()
    // {

    //     $car = Car::create([
    //         'brand' => 'Hundai',
    //         'model' => 'Tucson',
    //         'year' => 2023,
    //         'price' => 546000,
    //     ]);

    //     $response = $this->actingAs($this->user)->get('/user/car/' . $car->id . '/edit');
    //     $response->assertStatus(200);
    //     dd($response);
    //     $response->assertSee('value="' . $car->brand . '"', false);
    //     $response->assertSee('value="' . $car->model . '"', false);
    //     $response->assertSee('value="' . $car->year . '"', false);
    //     $response->assertSee('value="' . $car->price . '"', false);
    //     $response->assertViewHas('car', $car);
    // }
}
